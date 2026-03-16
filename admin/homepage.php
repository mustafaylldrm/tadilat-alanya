<?php
$admin_page = 'homepage';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_hero'])) {
        foreach (['hero_title','hero_subtitle','hero_cta','about_title','about_text'] as $f)
            save_setting($f, trim($_POST[$f] ?? ''));
        $msg = '✅ Hero kaydedildi.';
    }
    if (isset($_POST['save_stats'])) {
        db_query("DELETE FROM stats");
        $nums = $_POST['num'] ?? [];
        $labels = $_POST['label'] ?? [];
        foreach ($nums as $i => $num) {
            if (trim($num)) db_query("INSERT INTO stats (number_text,label,sort_order) VALUES (?,?,?)", [trim($num), trim($labels[$i]??''), $i]);
        }
        $msg = '✅ İstatistikler kaydedildi.';
    }
}
$stats = db_query("SELECT * FROM stats ORDER BY sort_order");
while (count($stats) < 4) $stats[] = ['number_text'=>'','label'=>''];
$page_title = 'Ana Sayfa Düzenle';
require_once __DIR__ . '/admin_header.php';
?>
<?php if ($msg): ?><div class="alert alert-success"><?= h($msg) ?></div><?php endif; ?>

<div class="card">
  <div class="card-header"><div class="card-title">Hero Bölümü</div></div>
  <form method="POST">
    <div class="form-group"><label class="form-label">Hero Başlık <small style="text-transform:none;font-weight:400">(HTML kullanabilirsiniz, örn: &lt;em&gt;Güvenilir&lt;/em&gt;)</small></label><input class="form-control" name="hero_title" value="<?= h(setting('hero_title')) ?>"></div>
    <div class="form-group"><label class="form-label">Hero Alt Başlık</label><input class="form-control" name="hero_subtitle" value="<?= h(setting('hero_subtitle')) ?>"></div>
    <div class="form-group"><label class="form-label">Buton Metni</label><input class="form-control" name="hero_cta" value="<?= h(setting('hero_cta')) ?>"></div>
    <div class="form-group"><label class="form-label">Hakkımızda Başlık</label><input class="form-control" name="about_title" value="<?= h(setting('about_title')) ?>"></div>
    <div class="form-group"><label class="form-label">Hakkımızda Metin</label><textarea class="form-control" name="about_text"><?= h(setting('about_text')) ?></textarea></div>
    <button type="submit" name="save_hero" class="btn btn-primary">💾 Hero Kaydet</button>
  </form>
</div>

<div class="card">
  <div class="card-header"><div class="card-title">İstatistik Çubukları (4 adet)</div></div>
  <form method="POST">
    <div class="grid-2">
      <?php foreach ($stats as $i => $s): ?>
      <div style="display:grid;grid-template-columns:1fr 2fr;gap:8px;align-items:end;margin-bottom:12px">
        <div class="form-group" style="margin:0"><label class="form-label">Sayı <?= $i+1 ?></label><input class="form-control" name="num[]" value="<?= h($s['number_text']) ?>" placeholder="40+"></div>
        <div class="form-group" style="margin:0"><label class="form-label">Etiket</label><input class="form-control" name="label[]" value="<?= h($s['label']) ?>" placeholder="Yıllık Tecrübe"></div>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="submit" name="save_stats" class="btn btn-primary">💾 İstatistikleri Kaydet</button>
  </form>
</div>
</main></div></body></html>
