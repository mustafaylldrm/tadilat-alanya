<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$_page_title = 'Tadilat Rehberi – ' . setting('site_title');
$_page_desc = 'Alanya\'da tadilat rehberi, ipuçları ve fiyat bilgileri.';
$posts = db_query("SELECT id,title,slug,category,excerpt,image,published_at FROM blog_posts WHERE published=1 ORDER BY published_at DESC");
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> <span>›</span> <span>Blog</span></div>
    <h1>Tadilat Rehberi</h1>
    <p>Tadilat, tamirat ve yenileme hakkında faydalı bilgiler.</p>
  </div>
</div>
<section class="section">
  <div class="container">
    <?php if ($posts): ?>
    <div class="blog-grid">
      <?php foreach ($posts as $p): ?>
      <a href="/blog/<?= h($p['slug']) ?>" class="blog-card" style="text-decoration:none">
        <div class="blog-card-img">
          <?php if ($p['image']): ?><img src="<?= h($p['image']) ?>" alt="<?= h($p['title']) ?>" loading="lazy"><?php else: ?>📰<?php endif; ?>
        </div>
        <div class="blog-card-content" style="padding:16px;flex:1">
          <div class="blog-cat"><?= h($p['category']) ?></div>
          <h3><?= h($p['title']) ?></h3>
          <?php if ($p['excerpt']): ?><p style="font-size:13px;color:var(--text-2);margin-top:6px;line-height:1.6"><?= h(mb_substr($p['excerpt'],0,100)) ?>...</p><?php endif; ?>
          <div class="blog-date" style="margin-top:8px"><?= h($p['published_at']) ?></div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:60px 0;color:var(--text-2)">Henüz blog yazısı yok.</div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
