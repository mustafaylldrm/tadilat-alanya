<?php
require_once __DIR__ . '/includes/db.php';
$_page_title = 'Hizmetlerimiz – ' . setting('site_title');
$_page_desc = 'Alanya\'da profesyonel tadilat ve tamirat hizmetleri. Boya, fayans, mutfak, banyo ve daha fazlası.';
$services = db_query("SELECT * FROM services WHERE active=1 ORDER BY sort_order");
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> › <span>Hizmetler</span></div>
    <h1>Hizmetlerimiz</h1>
    <p>Alanya'da 40 yıllık tecrübeyle sunduğumuz tadilat hizmetleri</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="services-list">
      <?php foreach ($services as $s): ?>
      <a href="/hizmetler/<?= h($s['slug']) ?>" class="service-card">
        <div class="service-card-accent"></div>
        <?php if ($s['image']): ?>
        <img src="<?= h($s['image']) ?>" alt="<?= h($s['title']) ?>" style="width:90px;height:90px;object-fit:cover;flex-shrink:0">
        <?php endif; ?>
        <div class="service-card-body">
          <h3><?= h($s['title']) ?></h3>
          <p><?= h($s['short_desc']) ?></p>
          <?php if ($s['features']): ?>
          <div class="service-tags">
            <?php foreach (explode(',', $s['features']) as $f): ?>
            <span class="stag"><?= h(trim($f)) ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="service-card-arrow">›</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
