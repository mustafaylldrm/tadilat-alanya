<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
require_admin();
$unread = db_row("SELECT COUNT(*) as c FROM messages WHERE is_read=0");
$unread_count = $unread['c'] ?? 0;
$admin_page = $admin_page ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= h($page_title ?? 'Admin') ?> – Yönetim Paneli</title>
<link rel="stylesheet" href="/admin/admin.css">
</head>
<body>
<div class="admin-wrap">

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sb-head">
    <img src="https://tadilatalanya.com/wp-content/uploads/2021/10/tadilatalanya-logo-mobile.png" alt="Tadilat Alanya" style="height:32px;margin-bottom:4px;display:block">
    <div class="sb-badge">Yönetim Paneli</div>
  </div>
  <nav class="sb-nav">
    <div class="sb-section">Genel</div>
    <a href="/admin/" class="sb-link <?= $admin_page==='dashboard'?'active':'' ?>"><span class="ic">📊</span> Dashboard</a>
    <a href="/admin/messages.php" class="sb-link <?= $admin_page==='messages'?'active':'' ?>">
      <span class="ic">✉️</span> Mesajlar
      <?php if ($unread_count > 0): ?><span class="badge badge-yellow" style="margin-left:auto"><?= $unread_count ?></span><?php endif; ?>
    </a>

    <div class="sb-section">İçerik</div>
    <a href="/admin/services.php" class="sb-link <?= $admin_page==='services'?'active':'' ?>"><span class="ic">🔧</span> Hizmetler</a>
    <a href="/admin/blog.php" class="sb-link <?= $admin_page==='blog'?'active':'' ?>"><span class="ic">📝</span> Blog Yazıları</a>
    <a href="/admin/faq.php" class="sb-link <?= $admin_page==='faq'?'active':'' ?>"><span class="ic">❓</span> SSS</a>

    <div class="sb-section">Ayarlar</div>
    <a href="/admin/settings.php" class="sb-link <?= $admin_page==='settings'?'active':'' ?>"><span class="ic">⚙️</span> Site Ayarları</a>
    <a href="/admin/homepage.php" class="sb-link <?= $admin_page==='homepage'?'active':'' ?>"><span class="ic">🏠</span> Ana Sayfa</a>
    <a href="/admin/password.php" class="sb-link <?= $admin_page==='password'?'active':'' ?>"><span class="ic">🔒</span> Şifre Değiştir</a>

    <div class="sb-section">İşlemler</div>
    <a href="/" target="_blank" class="sb-link"><span class="ic">👁️</span> Siteyi Gör</a>
    <a href="/admin/logout.php" class="sb-link" style="color:rgba(255,100,100,.7)"><span class="ic">🚪</span> Çıkış Yap</a>
  </nav>
</aside>

<!-- MAIN -->
<main class="main">
<div class="topbar">
  <div style="display:flex;align-items:center;gap:12px">
    <button class="btn btn-outline btn-sm mobile-sb-btn" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
    <h1><?= h($page_title ?? 'Dashboard') ?></h1>
  </div>
  <div class="topbar-right">
    <span style="font-size:12px;color:#64748B">👤 <?= h($_SESSION['admin_user'] ?? 'admin') ?></span>
  </div>
</div>
