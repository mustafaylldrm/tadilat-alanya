<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$slug = $_GET['slug'] ?? '';
$post = db_row("SELECT * FROM blog_posts WHERE slug=? AND published=1", [$slug]);
if (!$post) { header('HTTP/1.0 404 Not Found'); echo '<h1>Yazı bulunamadı</h1>'; exit; }
$_page_title = $post['meta_title'] ?: $post['title'] . ' – ' . setting('site_title');
$_page_desc = $post['meta_desc'] ?: $post['excerpt'];
$related = db_query("SELECT id,title,slug,published_at FROM blog_posts WHERE published=1 AND id!=? ORDER BY published_at DESC LIMIT 3", [$post['id']], 'i');
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> <span>›</span> <a href="/blog">Blog</a> <span>›</span> <span><?= h(mb_substr($post['title'],0,40)) ?>...</span></div>
    <div class="sec-tag"><?= h($post['category']) ?></div>
    <h1 style="margin-top:8px"><?= h($post['title']) ?></h1>
    <p style="margin-top:8px;font-size:13px">📅 <?= h($post['published_at']) ?></p>
  </div>
</div>
<section class="section">
  <div class="container" style="max-width:780px">
    <?php if ($post['image']): ?>
    <img src="<?= h($post['image']) ?>" alt="<?= h($post['title']) ?>" style="width:100%;max-height:380px;object-fit:cover;border-radius:12px;margin-bottom:28px">
    <?php endif; ?>
    <div style="font-size:16px;line-height:1.9;color:var(--text-2)">
      <?= nl2br(h($post['content'])) ?>
    </div>
    <div style="margin-top:40px;padding:24px;background:var(--cream);border-radius:12px;border-left:4px solid var(--gold)">
      <div style="font-weight:700;margin-bottom:8px">Bu konuda yardım almak ister misiniz?</div>
      <p style="font-size:14px;color:var(--text-2);margin-bottom:14px">Ücretsiz keşif ve fiyat teklifi için bizi arayın.</p>
      <a href="tel:<?= h($_site['phone_raw']) ?>" style="display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:#fff;font-weight:700;padding:12px 22px;border-radius:var(--r);font-size:14px">📞 <?= h($_site['phone']) ?></a>
    </div>
    <?php if ($related): ?>
    <div style="margin-top:40px">
      <div class="sec-tag">İlgili Yazılar</div>
      <div style="margin-top:14px;display:flex;flex-direction:column;gap:10px">
        <?php foreach ($related as $r): ?>
        <a href="/blog/<?= h($r['slug']) ?>" style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--cream);border-radius:var(--r);border:1px solid var(--border)">
          <span style="font-weight:600;font-size:14px"><?= h($r['title']) ?></span>
          <span style="color:var(--gold);flex-shrink:0">›</span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
