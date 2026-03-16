<?php
$page_title = 'Dashboard';
$admin_page = 'dashboard';
require_once __DIR__ . '/admin_header.php';
$svc_count = db_row("SELECT COUNT(*) c FROM services WHERE active=1")['c'] ?? 0;
$blog_count = db_row("SELECT COUNT(*) c FROM blog_posts WHERE published=1")['c'] ?? 0;
$msg_count = db_row("SELECT COUNT(*) c FROM messages")['c'] ?? 0;
$unread = db_row("SELECT COUNT(*) c FROM messages WHERE is_read=0")['c'] ?? 0;
$recent_msgs = db_query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
?>

<div class="stat-row">
  <div class="stat-card"><div class="stat-ic" style="background:#FEF3C7">🔧</div><div><div class="stat-val"><?= $svc_count ?></div><div class="stat-lbl">Hizmet</div></div></div>
  <div class="stat-card"><div class="stat-ic" style="background:#DBEAFE">📝</div><div><div class="stat-val"><?= $blog_count ?></div><div class="stat-lbl">Blog Yazısı</div></div></div>
  <div class="stat-card"><div class="stat-ic" style="background:#D1FAE5">✉️</div><div><div class="stat-val"><?= $msg_count ?></div><div class="stat-lbl">Mesaj</div></div></div>
  <div class="stat-card"><div class="stat-ic" style="background:#FEE2E2">🔴</div><div><div class="stat-val"><?= $unread ?></div><div class="stat-lbl">Okunmamış</div></div></div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Son Gelen Mesajlar</div>
    <a href="/admin/messages.php" class="btn btn-outline btn-sm">Tümünü Gör</a>
  </div>
  <?php if ($recent_msgs): ?>
  <table>
    <thead><tr><th>Ad Soyad</th><th>Telefon</th><th>Hizmet</th><th>Tarih</th><th>Durum</th></tr></thead>
    <tbody>
      <?php foreach ($recent_msgs as $m): ?>
      <tr>
        <td><strong><?= h($m['name']) ?></strong></td>
        <td><a href="tel:<?= h($m['phone']) ?>" style="color:#C8860A;font-weight:600"><?= h($m['phone']) ?></a></td>
        <td><?= h($m['service'] ?: '—') ?></td>
        <td style="color:#64748B;font-size:12px"><?= h(date('d.m.Y H:i', strtotime($m['created_at']))) ?></td>
        <td><span class="badge <?= $m['is_read'] ? 'badge-gray' : 'badge-yellow' ?>"><?= $m['is_read'] ? 'Okundu' : 'Yeni' ?></span></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <div style="text-align:center;padding:32px;color:#94A3B8">Henüz mesaj yok.</div>
  <?php endif; ?>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
  <?php foreach([
    ['/admin/services.php','🔧','Hizmetleri Düzenle','İçerik ve özellikler'],
    ['/admin/blog.php','📝','Blog Yönetimi','Yeni yazı ekle'],
    ['/admin/settings.php','⚙️','Site Ayarları','Telefon, adres vb.'],
    ['/admin/homepage.php','🏠','Ana Sayfa','Hero ve istatistikler'],
  ] as $item): ?>
  <a href="<?= $item[0] ?>" class="card" style="cursor:pointer;transition:border-color .2s;display:block" onmouseover="this.style.borderColor='#C8860A'" onmouseout="this.style.borderColor='#E2E8F0'">
    <div style="font-size:28px;margin-bottom:10px"><?= $item[1] ?></div>
    <div style="font-weight:700;margin-bottom:4px"><?= $item[2] ?></div>
    <div style="font-size:12px;color:#64748B"><?= $item[3] ?></div>
  </a>
  <?php endforeach; ?>
</div>

</main></div>
</body></html>
