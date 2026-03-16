<?php
if (!defined('DB_HOST')) { require_once __DIR__ . '/../config.php'; }
require_once __DIR__ . '/db.php';
if (!isset($conn_started)) { session_start(); $conn_started = true; }
$_site = [
    'title' => setting('site_title','Tadilat Alanya'),
    'tagline' => setting('site_tagline','Alanya Tadilat'),
    'phone' => setting('site_phone','+90 544 880 66 68'),
    'phone_raw' => preg_replace('/[^0-9]/', '', setting('site_phone','+905448806668')),
    'whatsapp' => setting('site_whatsapp','905448806668'),
    'meta_title' => setting('meta_title','Tadilat Alanya'),
    'meta_desc' => setting('meta_desc','Alanya tadilat hizmetleri'),
    'ga' => setting('google_analytics',''),
];
$_services_nav = db_query("SELECT title, slug FROM services WHERE active=1 ORDER BY sort_order LIMIT 10");
$_page_title = $_page_title ?? $_site['title'];
$_page_desc = $_page_desc ?? $_site['meta_desc'];
$_page_canonical = $_page_canonical ?? (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="<?= h($_page_desc) ?>">
<title><?= h($_page_title) ?></title>
<link rel="canonical" href="<?= h($_page_canonical) ?>">
<meta property="og:title" content="<?= h($_page_title) ?>">
<meta property="og:description" content="<?= h($_page_desc) ?>">
<meta property="og:type" content="website">
<meta name="robots" content="index,follow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
<?php if ($_site['ga']): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= h($_site['ga']) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config','<?= h($_site['ga']) ?>');</script>
<?php endif; ?>
<!-- Schema.org -->
<script type="application/ld+json">{"@context":"https://schema.org","@type":"LocalBusiness","name":"<?= h($_site['title']) ?>","description":"<?= h($_site['meta_desc']) ?>","telephone":"<?= h($_site['phone']) ?>","address":{"@type":"PostalAddress","addressLocality":"Alanya","addressRegion":"Antalya","addressCountry":"TR"}}</script>
</head>
<body>

<header class="site-header">
  <div class="container">
    <div class="header-bar">
      <a href="/" class="site-logo">
        <img src="https://tadilatalanya.com/wp-content/uploads/2021/10/tadilatalanya-logo-mobile.png" alt="Tadilat Alanya" style="height:38px;width:auto;display:block">
      </a>

      <!-- Desktop Nav -->
      <nav class="desktop-nav">
        <a href="/">Ana Sayfa</a>
        <a href="/hakkimizda">Hakkımızda</a>
        <div class="dropdown">
          <a href="/hizmetler" style="display:flex;align-items:center;gap:4px">Hizmetler <span style="font-size:10px">▾</span></a>
          <div class="dropdown-menu">
            <?php foreach ($_services_nav as $s): ?>
            <a href="/hizmetler/<?= h($s['slug']) ?>"><?= h($s['title']) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <a href="/blog">Blog</a>
        <a href="/iletisim">İletişim</a>
      </nav>

      <a href="tel:<?= h($_site['phone_raw']) ?>" class="header-phone">
        <span class="icon">📞</span><?= h($_site['phone']) ?>
      </a>

      <!-- Mobile toggle -->
      <button class="nav-toggle" id="navToggle" aria-label="Menü">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- Mobile Nav -->
<nav class="mobile-nav" id="mobileNav">
  <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,.08)">
    <img src="https://tadilatalanya.com/wp-content/uploads/2021/10/tadilatalanya-logo-mobile.png" alt="Tadilat Alanya" style="height:32px">
  </div>
  <a href="/">🏠 Ana Sayfa</a>
  <a href="/hakkimizda">👤 Hakkımızda</a>
  <a href="/hizmetler">🔧 Hizmetlerimiz</a>
  <?php foreach ($_services_nav as $s): ?>
  <a href="/hizmetler/<?= h($s['slug']) ?>" class="sub">→ <?= h($s['title']) ?></a>
  <?php endforeach; ?>
  <a href="/blog">📝 Blog & Rehber</a>
  <a href="/iletisim">📍 İletişim</a>
  <a href="tel:<?= h($_site['phone_raw']) ?>" class="cta-item">📞 <?= h($_site['phone']) ?></a>
</nav>
