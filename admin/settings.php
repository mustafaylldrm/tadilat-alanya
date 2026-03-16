<?php
$admin_page = 'settings';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['site_title','site_tagline','site_phone','site_email','site_address','site_working_hours','site_whatsapp','meta_title','meta_desc','google_analytics'];
    foreach ($fields as $f) save_setting($f, trim($_POST[$f] ?? ''));
    $msg = '✅ Ayarlar kaydedildi.';
}
$page_title = 'Site Ayarları';
require_once __DIR__ . '/admin_header.php';
?>
<?php if ($msg): ?><div class="alert alert-success"><?= h($msg) ?></div><?php endif; ?>
<div class="card">
  <div class="card-header"><div class="card-title">Site Genel Bilgileri</div></div>
  <form method="POST">
    <div class="grid-2">
      <?php foreach ([
        ['site_title','Site Başlığı'],['site_tagline','Slogan'],
        ['site_phone','Telefon'],['site_email','E-posta'],
        ['site_address','Adres'],['site_working_hours','Çalışma Saatleri'],
        ['site_whatsapp','WhatsApp Numarası (sadece rakam)'],['google_analytics','Google Analytics ID'],
      ] as $f): ?>
      <div class="form-group"><label class="form-label"><?= $f[1] ?></label><input class="form-control" name="<?= $f[0] ?>" value="<?= h(setting($f[0])) ?>"></div>
      <?php endforeach; ?>
      <div class="form-group" style="grid-column:1/-1"><label class="form-label">Meta Açıklama (SEO)</label><textarea class="form-control" name="meta_desc"><?= h(setting('meta_desc')) ?></textarea></div>
      <div class="form-group" style="grid-column:1/-1"><label class="form-label">Meta Başlık (SEO)</label><input class="form-control" name="meta_title" value="<?= h(setting('meta_title')) ?>"></div>
    </div>
    <button type="submit" class="btn btn-primary">💾 Kaydet</button>
  </form>
</div>
</main></div></body></html>
