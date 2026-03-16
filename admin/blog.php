<?php
$admin_page = 'blog';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = ''; $edit = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_desc = trim($_POST['meta_desc'] ?? '');
    $published = isset($_POST['published']) ? 1 : 0;
    $pub_date = $_POST['published_at'] ?: date('Y-m-d');
    $sl = slug($title);
    $image = '';
    if (!empty($_FILES['image']['tmp_name'])) {
        $up = upload_image($_FILES['image'], 'uploads');
        if (isset($up['path'])) $image = $up['path'];
    }
    if (isset($_POST['id']) && $_POST['id']) {
        $id = (int)$_POST['id'];
        $existing = db_row("SELECT image,slug FROM blog_posts WHERE id=?", [$id], 'i');
        if (!$image) $image = $existing['image'] ?? '';
        if (!$sl) $sl = $existing['slug'];
        db_query("UPDATE blog_posts SET title=?,slug=?,category=?,excerpt=?,content=?,image=?,meta_title=?,meta_desc=?,published=?,published_at=? WHERE id=?",
            [$title,$sl,$category,$excerpt,$content,$image,$meta_title,$meta_desc,$published,$pub_date,$id]);
        $msg = '✅ Yazı güncellendi.';
    } else {
        db_query("INSERT INTO blog_posts (title,slug,category,excerpt,content,image,meta_title,meta_desc,published,published_at) VALUES (?,?,?,?,?,?,?,?,?,?)",
            [$title,$sl,$category,$excerpt,$content,$image,$meta_title,$meta_desc,$published,$pub_date]);
        $msg = '✅ Yazı eklendi.';
    }
}
if (isset($_GET['delete'])) { db_query("DELETE FROM blog_posts WHERE id=?", [(int)$_GET['delete']], 'i'); header('Location: /admin/blog.php?ok=1'); exit; }
if (isset($_GET['edit'])) $edit = db_row("SELECT * FROM blog_posts WHERE id=?", [(int)$_GET['edit']], 'i');
$posts = db_query("SELECT id,title,category,published,published_at FROM blog_posts ORDER BY id DESC");
$page_title = $edit ? 'Blog Yazısı Düzenle' : 'Blog Yazıları';
require_once __DIR__ . '/admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-success"><?= h($msg) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">✅ İşlem tamamlandı.</div><?php endif; ?>

<?php if ($edit): ?>
<div class="card">
  <div class="card-header">
    <div class="card-title">Yazı Düzenle</div>
    <a href="/admin/blog.php" class="btn btn-outline btn-sm">← Geri</a>
  </div>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <div class="grid-2">
      <div class="form-group" style="grid-column:1/-1"><label class="form-label">Başlık *</label><input class="form-control" name="title" value="<?= h($edit['title']) ?>" required></div>
      <div class="form-group"><label class="form-label">Kategori</label><input class="form-control" name="category" value="<?= h($edit['category']) ?>"></div>
      <div class="form-group"><label class="form-label">Yayın Tarihi</label><input class="form-control" type="date" name="published_at" value="<?= h($edit['published_at']) ?>"></div>
    </div>
    <div class="form-group"><label class="form-label">Kısa Özet</label><textarea class="form-control" name="excerpt" style="min-height:70px"><?= h($edit['excerpt']) ?></textarea></div>
    <div class="form-group"><label class="form-label">İçerik</label><textarea class="form-control" name="content" style="min-height:240px"><?= h($edit['content']) ?></textarea></div>
    <div class="grid-2">
      <div class="form-group">
        <label class="form-label">Kapak Görseli</label>
        <?php if ($edit['image']): ?><img src="<?= h($edit['image']) ?>" class="img-preview" style="margin-bottom:8px"><br><?php endif; ?>
        <input class="form-control" type="file" name="image" accept="image/*">
      </div>
      <div></div>
    </div>
    <div class="grid-2">
      <div class="form-group"><label class="form-label">SEO Başlık</label><input class="form-control" name="meta_title" value="<?= h($edit['meta_title']) ?>"></div>
      <div class="form-group"><label class="form-label">SEO Açıklama</label><input class="form-control" name="meta_desc" value="<?= h($edit['meta_desc']) ?>"></div>
    </div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="published" <?= $edit['published']?'checked':'' ?>><span class="form-label" style="margin:0">Yayında</span></label></div>
    <button type="submit" class="btn btn-primary">💾 Kaydet</button>
  </form>
</div>

<?php else: ?>
<div class="card">
  <div class="card-header">
    <div class="card-title">Blog Yazıları (<?= count($posts) ?>)</div>
    <a href="/admin/blog.php?edit=new" class="btn btn-primary btn-sm">+ Yeni Yazı</a>
  </div>
  <?php if ($posts): ?>
  <table>
    <thead><tr><th>Başlık</th><th>Kategori</th><th>Tarih</th><th>Durum</th><th>İşlem</th></tr></thead>
    <tbody>
      <?php foreach ($posts as $p): ?>
      <tr>
        <td><strong><?= h($p['title']) ?></strong></td>
        <td><?= h($p['category']) ?></td>
        <td style="color:#64748B;font-size:12px"><?= h($p['published_at']) ?></td>
        <td><span class="badge <?= $p['published']?'badge-green':'badge-gray' ?>"><?= $p['published']?'Yayında':'Taslak' ?></span></td>
        <td style="white-space:nowrap">
          <a href="?edit=<?= $p['id'] ?>" class="btn btn-outline btn-sm">✏️</a>
          <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istiyor musunuz?')">🗑️</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <div style="text-align:center;padding:40px;color:#94A3B8">Henüz blog yazısı yok. Yeni yazı ekleyin!</div>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php if (isset($_GET['edit']) && $_GET['edit'] === 'new'): ?>
<script>
// Redirect to handle ?edit=new properly
window.onload = function(){
  // handled above in PHP
}
</script>
<?php endif; ?>

</main></div></body></html>
