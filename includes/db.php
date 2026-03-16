<?php
// Veritabanı bağlantı ayarları - kurulumdan sonra config.php'de değiştirin
$config_file = __DIR__ . '/../config.php';
if (!file_exists($config_file)) {
    // Alternatif: aynı klasörde ara
    $config_file = dirname(__DIR__) . '/config.php';
}

if (file_exists($config_file)) {
    require_once $config_file;
} else {
    $install_check = strpos($_SERVER['REQUEST_URI'], 'install.php');
    if ($install_check === false) {
        header('Location: /install.php');
        exit;
    }
}

function db_connect() {
    if (!defined('DB_HOST')) return null;
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT ?? 3306);
    if ($conn->connect_error) {
        die('Veritabanı bağlantı hatası: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function db_query($sql, $params = [], $types = '') {
    $conn = db_connect();
    if (!$params) {
        $result = $conn->query($sql);
        if ($result === false) return false;
        if ($result === true) { $id = $conn->insert_id; $conn->close(); return $id ?: true; }
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $rows;
    }
    $stmt = $conn->prepare($sql);
    if (!$types) {
        $types = str_repeat('s', count($params));
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close(); $conn->close();
        return $rows;
    }
    $id = $conn->insert_id;
    $stmt->close(); $conn->close();
    return $id ?: true;
}

function db_row($sql, $params = [], $types = '') {
    $rows = db_query($sql, $params, $types);
    return $rows ? $rows[0] : null;
}

function setting($key, $default = '') {
    static $cache = [];
    if (isset($cache[$key])) return $cache[$key];
    $row = db_row("SELECT value FROM settings WHERE `key`=?", [$key]);
    $cache[$key] = $row ? $row['value'] : $default;
    return $cache[$key];
}

function save_setting($key, $value) {
    db_query("INSERT INTO settings (`key`, value) VALUES (?,?) ON DUPLICATE KEY UPDATE value=?", [$key, $value, $value]);
}

function slug($str) {
    $str = mb_strtolower($str, 'UTF-8');
    $tr = ['ş'=>'s','ı'=>'i','ğ'=>'g','ü'=>'u','ö'=>'o','ç'=>'c','Ş'=>'s','İ'=>'i','Ğ'=>'g','Ü'=>'u','Ö'=>'o','Ç'=>'c'];
    $str = strtr($str, $tr);
    $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
    $str = preg_replace('/[\s-]+/', '-', trim($str));
    return $str;
}

function h($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function is_admin_logged() {
    return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}

function require_admin() {
    if (!is_admin_logged()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function upload_image($file, $folder = 'uploads') {
    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return ['error' => 'Geçersiz dosya türü'];
    if ($file['size'] > 5 * 1024 * 1024) return ['error' => 'Dosya çok büyük (max 5MB)'];
    $name = uniqid() . '_' . time() . '.' . $ext;
    $dir = __DIR__ . '/../' . $folder . '/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (move_uploaded_file($file['tmp_name'], $dir . $name)) {
        return ['path' => '/' . $folder . '/' . $name];
    }
    return ['error' => 'Yükleme başarısız'];
}
