<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (is_admin_logged()) { header('Location: /admin/'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $row = db_row("SELECT * FROM admins WHERE username=?", [$user]);
    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_user'] = $user;
        header('Location: /admin/');
        exit;
    }
    $error = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Girişi</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#0F0A02;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 70% 50% at 20% 60%,rgba(200,134,10,.12) 0%,transparent 60%)}
.box{background:#fff;border-radius:16px;padding:40px 36px;width:100%;max-width:420px;position:relative;z-index:1}
.logo{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#0F0A02;margin-bottom:4px}
.logo span{color:#1A6BC4}
.sub{color:#6b7280;font-size:14px;margin-bottom:32px}
.form-group{margin-bottom:16px}
label{display:block;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#6b7280;margin-bottom:7px}
input{width:100%;padding:12px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:inherit;font-size:14px;outline:none;transition:border-color .2s}
input:focus{border-color:#1A6BC4}
.btn{width:100%;padding:14px;background:#1A6BC4;color:#fff;border:none;border-radius:8px;font-family:inherit;font-size:15px;font-weight:700;cursor:pointer;margin-top:8px;transition:background .2s}
.btn:hover{background:#155BA0}
.error{background:#fee2e2;color:#dc2626;padding:12px 14px;border-radius:8px;font-size:14px;margin-bottom:16px;border:1px solid #fecaca}
.back{display:block;text-align:center;margin-top:20px;color:#9ca3af;font-size:13px}
.back a{color:#1A6BC4;font-weight:600}
</style>
</head>
<body>
<div class="box">
  <img src="https://tadilatalanya.com/wp-content/uploads/2021/10/tadilatalanya-logo-mobile.png" alt="Tadilat Alanya" style="height:42px;margin:0 auto 10px;display:block">
  <div class="sub">Yönetim Paneli Girişi</div>
  <?php if ($error): ?><div class="error">⚠️ <?= h($error) ?></div><?php endif; ?>
  <form method="POST">
    <div class="form-group"><label>Kullanıcı Adı</label><input name="username" required autofocus placeholder="admin"></div>
    <div class="form-group"><label>Şifre</label><input name="password" type="password" required placeholder="••••••••"></div>
    <button type="submit" class="btn">Giriş Yap →</button>
  </form>
  <div class="back"><a href="/">← Siteye Dön</a></div>
</div>
</body>
</html>
