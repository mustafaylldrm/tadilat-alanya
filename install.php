<?php
session_start();
$step = $_GET['step'] ?? 1;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step == 1) {
    $host = trim($_POST['db_host'] ?? 'localhost');
    $user = trim($_POST['db_user'] ?? '');
    $pass = $_POST['db_pass'] ?? '';
    $name = trim($_POST['db_name'] ?? '');
    $port = trim($_POST['db_port'] ?? '3306');

    $conn = @new mysqli($host, $user, $pass, $name, (int)$port);
    if ($conn->connect_error) {
        $error = 'Veritabanı bağlantısı kurulamadı: ' . $conn->connect_error;
    } else {
        $conn->set_charset('utf8mb4');
        // Tabloları oluştur
        $sql = "
        CREATE TABLE IF NOT EXISTS settings (
            `key` varchar(100) PRIMARY KEY,
            value text
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS admins (
            id int AUTO_INCREMENT PRIMARY KEY,
            username varchar(100) UNIQUE,
            password varchar(255),
            created_at timestamp DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS services (
            id int AUTO_INCREMENT PRIMARY KEY,
            title varchar(255),
            slug varchar(255) UNIQUE,
            short_desc text,
            full_desc longtext,
            features text,
            image varchar(500),
            meta_title varchar(255),
            meta_desc text,
            sort_order int DEFAULT 0,
            active tinyint DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS blog_posts (
            id int AUTO_INCREMENT PRIMARY KEY,
            title varchar(500),
            slug varchar(500) UNIQUE,
            category varchar(255),
            excerpt text,
            content longtext,
            image varchar(500),
            meta_title varchar(255),
            meta_desc text,
            published tinyint DEFAULT 0,
            published_at date,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS faq (
            id int AUTO_INCREMENT PRIMARY KEY,
            question text,
            answer text,
            sort_order int DEFAULT 0,
            active tinyint DEFAULT 1
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS messages (
            id int AUTO_INCREMENT PRIMARY KEY,
            name varchar(255),
            phone varchar(50),
            email varchar(255),
            service varchar(255),
            message text,
            is_read tinyint DEFAULT 0,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS stats (
            id int AUTO_INCREMENT PRIMARY KEY,
            number_text varchar(50),
            label varchar(255),
            sort_order int DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $conn->multi_query($sql);
        while ($conn->next_result()) {}

        // Default ayarlar
        $defaults = [
            'site_title' => 'Tadilat Alanya',
            'site_tagline' => 'Alanya Tadilat & Tamirat Hizmetleri',
            'site_phone' => '+90 544 880 66 68',
            'site_email' => 'info@tadilatalanya.com',
            'site_address' => 'Alanya, Antalya',
            'site_working_hours' => 'Hafta içi 08:00 - 18:00',
            'site_whatsapp' => '905448806668',
            'hero_title' => 'Alanya\'da <em>Güvenilir</em> Tadilat & Tamirat',
            'hero_subtitle' => '40 Yıllık Tecrübe ile Kaliteli İnşaat ve Tadilat Hizmetleri',
            'hero_cta' => 'ÜCRETSİZ KEŞİF AL',
            'about_title' => '40 Yıllık Ustaların Elinden, Kalitede Son Nokta!',
            'about_text' => 'Müşterilerimizin hayallerindeki mekanları bütçe dostu fiyatlarla gerçeğe dönüştürüyor, zamanında teslim ve temiz iş prensibiyle çalışıyoruz.',
            'meta_title' => 'Tadilat Alanya – Alanya Tadilat & Tamirat Hizmetleri',
            'meta_desc' => '40 yıllık tecrübeyle Alanya\'da tadilat, tamirat, boya, fayans ve mutfak yenileme hizmetleri. Ücretsiz keşif için arayın.',
            'google_analytics' => '',
            'facebook_pixel' => '',
        ];
        foreach ($defaults as $k => $v) {
            $conn->query("INSERT IGNORE INTO settings (`key`, value) VALUES ('$k', '" . $conn->real_escape_string($v) . "')");
        }

        // Default stats
        $stats = [['40+','Yıllık Tecrübe'],['500+','Tamamlanan Proje'],['100%','Müşteri Memnuniyeti'],['2 Yıl','İş Garantisi']];
        foreach ($stats as $i => $s) {
            $conn->query("INSERT IGNORE INTO stats (number_text, label, sort_order) VALUES ('{$s[0]}', '{$s[1]}', $i)");
        }

        // Default services
        $services_data = [
            ['Tamirat & Tadilat Hizmetleri','tamirat-tadilat-hizmetleri','Su tesisatından elektrik arızalarına kadar her türlü tamirat.','Su tesisatından elektrik arızalarına, kapı-pencere tamiratlarından duvar onarımlarına kadar her türlü küçük-büyük tamirat işleriniz için hizmetinizdeyiz.','Su tesisatı,Elektrik arızası,Kapı-pencere tamiri,Duvar onarımı','https://tadilatalanya.com/wp-content/uploads/2025/04/tamirat-banner.jpg'],
            ['Boya Badana Hizmetleri','boya-badana-hizmetleri','İç-dış cephe boya, badana, alçı ve sıva işleri.','Ev ve işyerleriniz için iç-dış cephe boya, badana, alçı ve sıva işlerinde uzman ekibimizle hizmetinizdeyiz.','İç cephe boya,Dış cephe boya,Alçı & sıva,Badana','https://tadilatalanya.com/wp-content/uploads/2025/04/tadilat-alanya-banner-3.jpg'],
            ['Mutfak & Banyo Yenileme','mutfak-yenileme-hizmetleri','Modern tasarımlarla anahtar teslim yenileme.','Eski ve yıpranmış mutfak banyolarınızı modern, fonksiyonel ve şık tasarımlarla yeniliyoruz.','Mutfak yenileme,Banyo yenileme,Tesisat,Fayans döşeme','https://tadilatalanya.com/wp-content/uploads/2025/04/tamirat-banner.jpg'],
            ['Fayans & Kalebodur İşleri','fayans-kalebodur-yenileme-ve-onarim','Profesyonel fayans ve seramik uygulamaları.','Banyo, mutfak, tuvalet, balkon ve teraslarınız için en kaliteli fayans, seramik ve kalebodur uygulamaları.','Fayans döşeme,Seramik kaplama,Kalebodur,Su yalıtımı','https://tadilatalanya.com/wp-content/uploads/2025/04/tadilat-alanya-banner-3.jpg'],
            ['Tuvalet Yenileme ve Tamiratı','tuvalet-yenileme-ve-tamirati','Modern, hijyenik tuvalet tadilatları.','Eski ve sorunlu tuvaletlerinizi modern, hijyenik ve kullanışlı mekanlara dönüştürüyoruz.','Tesisat yenileme,Su kaçak tamiri,Modern tasarım,Hijyen çözümleri','https://tadilatalanya.com/wp-content/uploads/2025/04/tamirat-banner.jpg'],
        ];
        foreach ($services_data as $i => $s) {
            $img = $conn->real_escape_string($s[5] ?? '');
            $conn->query("INSERT IGNORE INTO services (title, slug, short_desc, full_desc, features, image, sort_order) VALUES ('{$conn->real_escape_string($s[0])}','{$s[1]}','{$conn->real_escape_string($s[2])}','{$conn->real_escape_string($s[3])}','{$s[4]}','$img',$i)");
        }

        // Default FAQ
        $faqs = [
            ['Ücretsiz keşif yapıyor musunuz?','Evet, Alanya ve çevresindeki tüm müşterilerimiz için ücretsiz keşif hizmeti sunuyoruz.'],
            ['İşleriniz ne kadar sürüyor?','Küçük işler 1-3 gün, kapsamlı projeler 7-15 iş günü sürebilir.'],
            ['İş bitiminden sonra sorun çıkarsa ne yapmalıyım?','Tüm işlerimize minimum 2 yıl garanti veriyoruz.'],
        ];
        foreach ($faqs as $i => $f) {
            $conn->query("INSERT IGNORE INTO faq (question, answer, sort_order) VALUES ('{$conn->real_escape_string($f[0])}','{$conn->real_escape_string($f[1])}',$i)");
        }

        // Config dosyasını yaz
        $admin_user = trim($_POST['admin_user'] ?? 'admin');
        $admin_pass = password_hash($_POST['admin_pass'] ?? 'admin123', PASSWORD_DEFAULT);
        $conn->query("INSERT IGNORE INTO admins (username, password) VALUES ('$admin_user', '$admin_pass')");
        $conn->close();

        $config = "<?php\ndefine('DB_HOST', '$host');\ndefine('DB_USER', '$user');\ndefine('DB_PASS', '$pass');\ndefine('DB_NAME', '$name');\ndefine('DB_PORT', $port);\ndefine('SITE_URL', '" . rtrim($_POST['site_url'] ?? '', '/') . "');\ndefine('SECRET_KEY', '" . bin2hex(random_bytes(32)) . "');\n";
        $config_path = __DIR__ . '/config.php';
        $written = file_put_contents($config_path, $config);
        if ($written === false) {
            $error = 'config.php yazılamadı! Lütfen public_html/test.tadilatalanya.com klasörüne yazma izni (755) verin veya boş bir config.php dosyası oluşturup izni 644 yapın.';
        } else {
            header('Location: /install.php?step=2');
            exit;
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kurulum – Tadilat Alanya</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#1a1208;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.box{background:#fff;border-radius:12px;padding:40px;width:100%;max-width:520px}
h1{font-size:24px;margin-bottom:8px;color:#1a1208}
p{color:#6b7280;font-size:14px;margin-bottom:28px}
.form-group{margin-bottom:16px}
label{display:block;font-size:12px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#6b7280;margin-bottom:6px}
input{width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:6px;font-size:14px;outline:none}
input:focus{border-color:#c8860a}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.btn{width:100%;padding:13px;background:#c8860a;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:700;cursor:pointer;margin-top:8px}
.btn:hover{background:#a36a00}
.error{background:#fee2e2;color:#dc2626;padding:12px;border-radius:6px;font-size:14px;margin-bottom:16px}
.success{background:#dcfce7;color:#16a34a;padding:20px;border-radius:8px;text-align:center}
.success h2{font-size:20px;margin-bottom:8px}
.badge{display:inline-block;background:#fef3c7;color:#92400e;padding:2px 10px;border-radius:100px;font-size:12px;font-weight:700}
</style>
</head>
<body>
<div class="box">
<?php if ($step == 2): ?>
    <div class="success">
        <div style="font-size:48px;margin-bottom:12px">✅</div>
        <h2>Kurulum Tamamlandı!</h2>
        <p style="color:#166534;margin:8px 0 20px">Siteniz hazır. Şimdi admin paneline giriş yapabilirsiniz.</p>
        <a href="/admin/" style="display:inline-block;background:#c8860a;color:#fff;padding:12px 28px;border-radius:6px;font-weight:700;text-decoration:none">Admin Paneline Git →</a>
        <p style="margin-top:16px;font-size:12px;color:#6b7280">⚠️ Güvenlik için <span class="badge">install.php</span> dosyasını silin!</p>
    </div>
<?php else: ?>
    <h1>🏗️ Kurulum</h1>
    <p>Tadilat Alanya CMS kurulumu için bilgileri doldurun.</p>
    <?php if ($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
    <form method="POST">
        <div style="background:#f8fafc;padding:16px;border-radius:8px;margin-bottom:20px">
            <div style="font-size:12px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#6b7280;margin-bottom:12px">Veritabanı Bilgileri</div>
            <div class="grid">
                <div class="form-group"><label>DB Host</label><input name="db_host" value="localhost" required></div>
                <div class="form-group"><label>DB Port</label><input name="db_port" value="3306"></div>
            </div>
            <div class="form-group"><label>DB Kullanıcı Adı</label><input name="db_user" required placeholder="cpanel_kullanici"></div>
            <div class="form-group"><label>DB Şifre</label><input name="db_pass" type="password"></div>
            <div class="form-group"><label>DB Adı</label><input name="db_name" required placeholder="cpanel_veritabani"></div>
        </div>
        <div style="background:#f8fafc;padding:16px;border-radius:8px;margin-bottom:20px">
            <div style="font-size:12px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#6b7280;margin-bottom:12px">Admin Hesabı</div>
            <div class="grid">
                <div class="form-group"><label>Admin Kullanıcı</label><input name="admin_user" value="admin" required></div>
                <div class="form-group"><label>Admin Şifre</label><input name="admin_pass" type="password" required placeholder="Güçlü şifre girin"></div>
            </div>
        </div>
        <div class="form-group"><label>Site URL</label><input name="site_url" value="https://tadilatalanya.com" required></div>
        <button type="submit" class="btn">Kurulumu Tamamla →</button>
    </form>
<?php endif; ?>
</div>
</body>
</html>
