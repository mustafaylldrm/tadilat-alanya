<?php
$admin_page = 'password';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = ''; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cur = $_POST['current'] ?? '';
    $new = $_POST['new'] ?? '';
    $con = $_POST['confirm'] ?? '';
    $row = db_row("SELECT * FROM admins WHERE username=?", [$_SESSION['admin_user']]);
    if (!password_verify($cur, $row['password'])) $err = 'Mevcut şifre hatalı.';
    elseif ($new !== $con) $err = 'Yeni şifreler eşleşmiyor.';
    elseif (strlen($new) < 6) $err = 'Şifre en az 6 karakter olmalı.';
    else {
        db_query("UPDATE admins SET password=? WHERE username=?", [password_hash($new, PASSWORD_DEFAULT), $_SESSION['admin_user']]);
        $msg = '✅ Şifre güncellendi!';
    }
}
$page_title = 'Şifre Değiştir';
require_once __DIR__ . '/admin_header.php';
?>
<?php if ($msg): ?><div class="alert alert-success"><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><?= h($err) ?></div><?php endif; ?>
<div class="card" style="max-width:440px">
  <div class="card-header"><div class="card-title">Şifre Değiştir</div></div>
  <form method="POST">
    <div class="form-group"><label class="form-label">Mevcut Şifre</label><input class="form-control" type="password" name="current" required></div>
    <div class="form-group"><label class="form-label">Yeni Şifre</label><input class="form-control" type="password" name="new" required></div>
    <div class="form-group"><label class="form-label">Yeni Şifre (Tekrar)</label><input class="form-control" type="password" name="confirm" required></div>
    <button type="submit" class="btn btn-primary">🔒 Güncelle</button>
  </form>
</div>
</main></div></body></html>
