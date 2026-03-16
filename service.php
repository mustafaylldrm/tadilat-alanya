<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$slug = $_GET['slug'] ?? '';
$service = db_row("SELECT * FROM services WHERE slug=? AND active=1", [$slug]);
if (!$service) { header('HTTP/1.0 404 Not Found'); echo '<h1>Sayfa bulunamadı</h1>'; exit; }
$_page_title = ($service['meta_title'] ?: $service['title'] . ' – ' . setting('site_title'));
$_page_desc = $service['meta_desc'] ?: $service['short_desc'];
$other_services = db_query("SELECT id,title,slug FROM services WHERE active=1 AND id!=? ORDER BY sort_order LIMIT 5", [$service['id']], 'i');
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> <span>›</span> <a href="/hizmetler">Hizmetler</a> <span>›</span> <span><?= h($service['title']) ?></span></div>
    <h1><?= h($service['title']) ?></h1>
    <p><?= h($service['short_desc']) ?></p>
  </div>
</div>
<section class="section">
  <div class="container">
    <?php if ($service['image']): ?>
    <img src="<?= h($service['image']) ?>" alt="<?= h($service['title']) ?>" style="width:100%;max-height:360px;object-fit:cover;border-radius:12px;margin-bottom:28px">
    <?php endif; ?>
    <p style="color:var(--text-2);font-size:15px;line-height:1.85;margin-bottom:24px"><?= nl2br(h($service['full_desc'] ?: $service['short_desc'])) ?></p>
    <?php if ($service['features']): ?>
    <div style="margin-bottom:28px">
      <div style="font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--text-2);margin-bottom:12px">Kapsam</div>
      <div class="service-tags">
        <?php foreach (explode(',', $service['features']) as $f): ?>
        <span class="stag" style="padding:7px 14px;font-size:13px">✓ <?= h(trim($f)) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
    <div style="display:flex;flex-direction:column;gap:10px;max-width:400px">
      <a href="/iletisim" style="display:flex;align-items:center;justify-content:center;gap:8px;background:var(--gold);color:var(--white);font-weight:700;font-size:15px;padding:15px;border-radius:var(--r)">🔑 Ücretsiz Fiyat Teklifi Al</a>
      <a href="tel:<?= h($_site['phone_raw']) ?>" style="display:flex;align-items:center;justify-content:center;gap:8px;background:var(--cream-2);color:var(--dark);font-weight:600;font-size:14px;padding:13px;border-radius:var(--r)">📞 <?= h($_site['phone']) ?></a>
    </div>
    <?php if ($other_services): ?>
    <div style="margin-top:40px">
      <div class="sec-tag">Diğer Hizmetlerimiz</div>
      <div class="services-list" style="margin-top:12px">
        <?php foreach ($other_services as $s): ?>
        <a href="/hizmetler/<?= h($s['slug']) ?>" class="service-card">
          <div class="service-card-accent"></div>
          <div class="service-card-body"><h3><?= h($s['title']) ?></h3></div>
          <div class="service-card-arrow">›</div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
