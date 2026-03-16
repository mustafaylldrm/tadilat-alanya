<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$_page_title = 'Hakkımızda – ' . setting('site_title');
$_page_desc = '40 yıllık tecrübeyle Alanya\'da tadilat ve tamirat hizmetleri.';
$stats = db_query("SELECT * FROM stats ORDER BY sort_order");
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-header">
  <div class="container">
    <div class="breadcrumb"><a href="/">Ana Sayfa</a> <span>›</span> <span>Hakkımızda</span></div>
    <h1>Hakkımızda</h1>
    <p>40 yıllık tecrübeyle Alanya'nın güvenilir tadilat firması.</p>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="sec-tag">Biz Kimiz?</div>
    <h2 class="sec-title"><?= h(setting('about_title','40 Yıllık Ustaların Elinden!')) ?></h2>
    <p style="color:var(--text-2);font-size:16px;line-height:1.85;margin-top:14px;max-width:680px"><?= h(setting('about_text','')) ?></p>

    <?php if ($stats): ?>
    <div class="trust-bar" style="margin-top:36px;border-radius:12px;overflow:hidden">
      <div class="trust-grid">
        <?php foreach ($stats as $s): ?>
        <div class="trust-item">
          <div class="trust-num"><?= h($s['number_text']) ?></div>
          <div class="trust-label"><?= h($s['label']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="why-grid" style="margin-top:36px">
      <?php foreach ([
        ['🏆','Kaliteli Malzeme','Alanya\'nın iklimine uygun, dayanıklı malzemeler kullanıyoruz.'],
        ['⚡','Zamanında Teslim','Söz verilen sürede, eksiksiz teslim garantisi.'],
        ['🛡️','Garantili İş','Tüm işlerimize minimum 2 yıl garanti veriyoruz.'],
        ['💰','Uygun Fiyat','Bütçenize uygun, şeffaf fiyatlandırma politikası.'],
      ] as $w): ?>
      <div class="why-item">
        <div class="why-icon"><?= $w[0] ?></div>
        <div><h4><?= $w[1] ?></h4><p><?= $w[2] ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="margin-top:36px;text-align:center">
      <a href="/iletisim" style="display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:#fff;font-weight:700;font-size:15px;padding:15px 32px;border-radius:var(--r)">Ücretsiz Keşif İste →</a>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
