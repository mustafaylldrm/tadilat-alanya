<?php
$admin_page = 'messages';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
if (isset($_GET['read'])) { db_query("UPDATE messages SET is_read=1 WHERE id=?", [(int)$_GET['read']], 'i'); }
if (isset($_GET['delete'])) { db_query("DELETE FROM messages WHERE id=?", [(int)$_GET['delete']], 'i'); header('Location: /admin/messages.php?ok=1'); exit; }
if (isset($_GET['read_all'])) { db_query("UPDATE messages SET is_read=1"); header('Location: /admin/messages.php'); exit; }
$msgs = db_query("SELECT * FROM messages ORDER BY created_at DESC");
$page_title = 'Gelen Mesajlar';
require_once __DIR__ . '/admin_header.php';
?>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">✅ Silindi.</div><?php endif; ?>
<div class="card">
  <div class="card-header">
    <div class="card-title">Gelen Mesajlar (<?= count($msgs) ?>)</div>
    <a href="?read_all=1" class="btn btn-outline btn-sm">✅ Tümünü Okundu İşaretle</a>
  </div>
  <?php if ($msgs): ?>
  <table>
    <thead><tr><th>Ad Soyad</th><th>Telefon</th><th>Hizmet</th><th>Mesaj</th><th>Tarih</th><th>Durum</th><th>İşlem</th></tr></thead>
    <tbody>
      <?php foreach ($msgs as $m): ?>
      <tr style="<?= !$m['is_read'] ? 'background:#FFFBEB' : '' ?>">
        <td><strong><?= h($m['name']) ?></strong></td>
        <td><a href="tel:<?= h($m['phone']) ?>" style="color:#C8860A;font-weight:600"><?= h($m['phone']) ?></a></td>
        <td style="font-size:12px"><?= h($m['service'] ?: '—') ?></td>
        <td style="max-width:200px;font-size:12px;color:#64748B"><?= h(mb_substr($m['message'],0,80)) ?><?= mb_strlen($m['message'])>80?'...':'' ?></td>
        <td style="font-size:11px;color:#94A3B8;white-space:nowrap"><?= h(date('d.m.Y H:i',strtotime($m['created_at']))) ?></td>
        <td><span class="badge <?= $m['is_read']?'badge-gray':'badge-yellow' ?>"><?= $m['is_read']?'Okundu':'Yeni' ?></span></td>
        <td style="white-space:nowrap">
          <?php if (!$m['is_read']): ?><a href="?read=<?= $m['id'] ?>" class="btn btn-success btn-sm">✓</a><?php endif; ?>
          <a href="?delete=<?= $m['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silinsin mi?')">🗑️</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <div style="text-align:center;padding:40px;color:#94A3B8">Henüz mesaj yok.</div>
  <?php endif; ?>
</div>
</main></div></body></html>
