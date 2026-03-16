<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$_page_title = 'İletişim – ' . setting('site_title');
$_page_desc = 'Alanya tadilat için ücretsiz keşif ve fiyat teklifi alın.';
$services = db_query("SELECT id,title FROM services WHERE active=1 ORDER BY sort_order");
$form_success = false; $form_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $phone) {
        db_query("INSERT INTO messages (name,phone,email,service,message) VALUES (?,?,?,?,?)", [$name,$phone,$email,$service,$message]);
        $form_success = true;
    } else { $form_error = 'Ad ve telefon alanları zorunludur.'; }
}
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> <span>›</span> <span>İletişim</span></div>
    <h1>İletişim</h1>
    <p>Ücretsiz keşif için formu doldurun veya hemen arayın.</p>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="contact-grid">
      <div>
        <div class="sec-tag">Bize Ulaşın</div>
        <h2 class="sec-title">Ücretsiz Keşif & Fiyat Teklifi</h2>
        <p class="sec-desc" style="margin-bottom:20px">Projenizi anlatın, en kısa sürede sizi arayalım.</p>
        <div class="contact-info">
          <div class="cinfo-item"><div class="cinfo-icon">📞</div><div><div class="cinfo-label">Telefon</div><a href="tel:<?= h($_site['phone_raw']) ?>" class="cinfo-val"><?= h($_site['phone']) ?></a></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">💬</div><div><div class="cinfo-label">WhatsApp</div><a href="https://wa.me/<?= h($_site['whatsapp']) ?>" target="_blank" class="cinfo-val">WhatsApp ile Yaz</a></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">📧</div><div><div class="cinfo-label">E-posta</div><div class="cinfo-val"><?= h(setting('site_email')) ?></div></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">📍</div><div><div class="cinfo-label">Adres</div><div class="cinfo-val"><?= h(setting('site_address')) ?></div></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">🕐</div><div><div class="cinfo-label">Çalışma Saatleri</div><div class="cinfo-val"><?= h(setting('site_working_hours')) ?></div></div></div>
        </div>
      </div>
      <div>
        <?php if ($form_success): ?><div class="alert alert-success">✅ Mesajınız alındı! En kısa sürede sizi arayacağız.</div><?php endif; ?>
        <?php if ($form_error): ?><div class="alert alert-error"><?= h($form_error) ?></div><?php endif; ?>
        <?php if (!$form_success): ?>
        <div style="background:var(--cream);border-radius:12px;padding:24px">
          <div style="font-weight:700;font-size:16px;margin-bottom:18px">Fiyat Teklifi Formu</div>
          <form method="POST">
            <div class="form-row">
              <div class="form-group"><label class="form-label">Adınız *</label><input class="form-control" name="name" required placeholder="Ad Soyad"></div>
              <div class="form-group"><label class="form-label">Telefon *</label><input class="form-control" name="phone" type="tel" required placeholder="0555 000 00 00"></div>
            </div>
            <div class="form-group"><label class="form-label">E-posta</label><input class="form-control" name="email" type="email" placeholder="ornek@email.com"></div>
            <div class="form-group">
              <label class="form-label">Hizmet</label>
              <select class="form-control" name="service">
                <option value="">Hizmet Seçin</option>
                <?php foreach ($services as $s): ?><option value="<?= h($s['title']) ?>"><?= h($s['title']) ?></option><?php endforeach; ?>
                <option value="Diğer">Diğer</option>
              </select>
            </div>
            <div class="form-group"><label class="form-label">Mesajınız</label><textarea class="form-control" name="message" placeholder="Yapmak istediğiniz iş hakkında kısaca bilgi verin..."></textarea></div>
            <button type="submit" class="btn-submit">🔑 Gönder – Sizi Arayalım</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
