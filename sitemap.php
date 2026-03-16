<?php
require_once __DIR__ . '/includes/db.php';
header('Content-Type: application/xml; charset=utf-8');
$base = 'https://' . $_SERVER['HTTP_HOST'];
$services = db_query("SELECT slug,updated_at FROM services WHERE active=1");
$posts = db_query("SELECT slug,updated_at FROM blog_posts WHERE published=1");
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
$pages = [
    ['/', '1.0', 'daily'],
    ['/hizmetler', '0.9', 'weekly'],
    ['/blog', '0.8', 'weekly'],
    ['/hakkimizda', '0.7', 'monthly'],
    ['/iletisim', '0.7', 'monthly'],
];
foreach ($pages as $p) {
    echo "<url><loc>$base{$p[0]}</loc><priority>{$p[1]}</priority><changefreq>{$p[2]}</changefreq></url>\n";
}
foreach ($services as $s) {
    echo "<url><loc>$base/hizmetler/{$s['slug']}</loc><priority>0.8</priority><lastmod>{$s['updated_at']}</lastmod></url>\n";
}
foreach ($posts as $p) {
    echo "<url><loc>$base/blog/{$p['slug']}</loc><priority>0.7</priority><lastmod>{$p['updated_at']}</lastmod></url>\n";
}
echo '</urlset>';
