<?php
$admin_page = 'services';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = '';
$edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $short = trim($_POST['short_desc'] ?? '');
    $full = trim($_POST['full_desc'] ?? '');
    $features = trim($_POST['features'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_desc = trim($_POST['meta_desc'] ?? '');
    $active = isset($_POST['active']) ? 1 : 0;
    $sort = (int)($_POST['sort_order'] ?? 0);
    $sl = slug($title);
    $image = '';
    if (!empty($_FILES['image']['tmp_name'])) {
        $up = upload_image($_FILES['image'], 'uploads');
        if (isset($up['path'])) $image = $up['path'];
        elseif (isset($up['error'])) $msg = '⚠️ ' . $up['error'];
    }

    if (isset($_POST['id']) && $_POST['id']) {
        $id = (int)$_POST['id'];
        $existing = db_row("SELECT image FROM services WHERE id=?", [$id], 'i');
        if (!$image) $image = $existing['image'] ?? '';
        db_query("UPDATE services SET title=?,slug=?,short_desc=?,full_desc=?,features=?,image=?,meta_title=?,meta_desc=?,active=?,sort_order=? WHERE id=?",
            [$title,$sl,$short,$full,$features,$image,$meta_title,$meta_desc,$active,$sort,$id], 'ssssssssiiii');
        if (!$msg) $msg = '✅ Hizmet güncellendi.';
    } else {
        db_query("INSERT INTO services (title,slug,short_desc,full_desc,features,image,meta_title,meta_desc,active,sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)",
            [$title,$sl,$short,$full,$features,$image,$meta_title,$meta_desc,$active,$sort]);
        if (!$msg) $msg = '✅ Hizmet eklendi.';
    }
}

if (isset($_GET['delete'])) {
    db_query("DELETE FROM services WHERE id=?", [(int)$_GET['delete']], 'i');
    header('Location: /admin/services.php?ok=deleted'); exit;
}
if (isset($_GET['edit'])) {
    $edit = db_row("SELECT * FROM services WHERE id=?", [(int)$_GET['edit']], 'i');
}

$services = db_query("SELECT * FROM services ORDER BY sort_order, id");
$page_title = $edit ? 'Hizmet Düzenle' : 'Hizmetler';
require_once __DIR__ . '/admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?= strpos($msg,'✅')!==false?'success':'error' ?>"><?= h($msg) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">✅ İşlem tamamlandı.</div><?php endif; ?>

<?php if ($edit): ?>
<!-- EDIT FORM -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Hizmet Düzenle: <?= h($edit['title']) ?></div>
    <a href="/admin/services.php" class="btn btn-outline btn-sm">← Geri</a>
  </div>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <div class="grid-2">
      <div class="form-group"><label class="form-label">Hizmet Adı *</label><input class="form-control" name="title" value="<?= h($edit['title']) ?>" required></div>
      <div class="form-group"><label class="form-label">Sıra</label><input class="form-control" name="sort_order" type="number" value="<?= h($edit['sort_order']) ?>"></div>
    </div>
    <div class="form-group"><label class="form-label">Kısa Açıklama (Kart)</label><textarea class="form-control" name="short_desc" style="min-height:70px"><?= h($edit['short_desc']) ?></textarea></div>
    <div class="form-group"><label class="form-label">Tam Açıklama (Detay Sayfası)</label><textarea class="form-control" name="full_desc"><?= h($edit['full_desc']) ?></textarea></div>
    <div class="form-group"><label class="form-label">Özellikler (virgülle ayırın)</label><input class="form-control" name="features" value="<?= h($edit['features']) ?>" placeholder="Su tesisatı, Elektrik, Duvar onarımı"></div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Görsel</label>
        <?php if ($edit['image']): ?><img src="<?= h($edit['image']) ?>" class="img-preview" style="margin-bottom:8px"><br><?php endif; ?>
        <input class="form-control" type="file" name="image" accept="image/*">
      </div>
      <div></div>
    </div>
    <div class="grid-2">
      <div class="form-group"><label class="form-label">SEO Başlık</label><input class="form-control" name="meta_title" value="<?= h($edit['meta_title']) ?>"></div>
      <div class="form-group"><label class="form-label">SEO Açıklama</label><input class="form-control" name="meta_desc" value="<?= h($edit['meta_desc']) ?>"></div>
    </div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="active" <?= $edit['active']?'checked':'' ?>><span class="form-label" style="margin:0">Aktif (sitede görünsün)</span></label></div>
    <button type="submit" class="btn btn-primary">💾 Kaydet</button>
  </form>
</div>

<?php else: ?>
<!-- LIST + ADD FORM -->
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">
<div class="card">
  <div class="card-header"><div class="card-title">Tüm Hizmetler (<?= count($services) ?>)</div></div>
  <table>
    <thead><tr><th>Görsel</th><th>Hizmet</th><th>Durum</th><th>İşlem</th></tr></thead>
    <tbody>
      <?php foreach ($services as $s): ?>
      <tr>
        <td><?php if ($s['image']): ?><img src="<?= h($s['image']) ?>" class="img-preview"><?php else: ?>—<?php endif; ?></td>
        <td><strong><?= h($s['title']) ?></strong><br><span style="font-size:11px;color:#94A3B8"><?= h(mb_substr($s['short_desc'],0,60)) ?>...</span></td>
        <td><span class="badge <?= $s['active']?'badge-green':'badge-gray' ?>"><?= $s['active']?'Aktif':'Pasif' ?></span></td>
        <td style="white-space:nowrap">
          <a href="?edit=<?= $s['id'] ?>" class="btn btn-outline btn-sm">✏️ Düzenle</a>
          <a href="?delete=<?= $s['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinizden emin misiniz?')">🗑️</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="card">
  <div class="card-header"><div class="card-title">Yeni Hizmet Ekle</div></div>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group"><label class="form-label">Hizmet Adı *</label><input class="form-control" name="title" required placeholder="Hizmet adı"></div>
    <div class="form-group"><label class="form-label">Kısa Açıklama</label><textarea class="form-control" name="short_desc" style="min-height:65px" placeholder="Kart açıklaması"></textarea></div>
    <div class="form-group"><label class="form-label">Özellikler (virgülle)</label><input class="form-control" name="features" placeholder="Su tesisatı, Elektrik"></div>
    <div class="form-group"><label class="form-label">Görsel</label><input class="form-control" type="file" name="image" accept="image/*"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="active" checked><span class="form-label" style="margin:0">Aktif</span></label></div>
    <button type="submit" class="btn btn-primary" style="width:100%">+ Ekle</button>
  </form>
</div>
</div>
<?php endif; ?>

</main></div>
</body></html>
