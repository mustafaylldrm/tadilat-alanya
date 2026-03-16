<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$services = db_query("SELECT * FROM services WHERE active=1 ORDER BY sort_order LIMIT 6");
$stats = db_query("SELECT * FROM stats ORDER BY sort_order");
$faqs = db_query("SELECT * FROM faq WHERE active=1 ORDER BY sort_order LIMIT 6");
$posts = db_query("SELECT id,title,slug,category,excerpt,image,published_at FROM blog_posts WHERE published=1 ORDER BY published_at DESC LIMIT 3");
$hero_cta = setting('hero_cta','ÜCRETSİZ KEŞİF AL');
$about_title = setting('about_title','40 Yıllık Ustaların Elinden!');
$about_text = setting('about_text','');
$form_success = false; $form_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $phone) {
        db_query("INSERT INTO messages (name,phone,service,message) VALUES (?,?,?,?)", [$name,$phone,$service,$message]);
        $form_success = true;
    } else { $form_error = 'Ad ve telefon zorunludur.'; }
}

// Slider verileri - her slide bir hizmet
$slides = [
    [
        'img'   => 'https://tadilatalanya.com/wp-content/uploads/2025/04/tamirat-banner.jpg',
        'badge' => 'Tamirat & Tadilat',
        'title' => 'Her Türlü Tamirat<br>İşin Uzmanı',
        'desc'  => 'Su tesisatından elektrik arızalarına, kapı-pencere tamiratlarından duvar onarımlarına kadar hizmetinizdeyiz.',
        'link'  => '/hizmetler/tamirat-tadilat-hizmetleri',
    ],
    [
        'img'   => 'https://tadilatalanya.com/wp-content/uploads/2025/04/boya-badana-hizmetleri-tadilatalanya.jpg',
        'badge' => 'Boya & Badana',
        'title' => 'Profesyonel Boya<br>Badana Hizmetleri',
        'desc'  => 'İç-dış cephe boya, badana, alçı ve sıva işlerinde Alanya\'nın iklime dayanıklı özel çözümleri.',
        'link'  => '/hizmetler/boya-badana-hizmetleri',
    ],
    [
        'img'   => 'https://tadilatalanya.com/wp-content/uploads/2025/04/mutfak-banyo-yenileme-tadilat-alanya.jpg',
        'badge' => 'Mutfak & Banyo',
        'title' => 'Modern Mutfak &<br>Banyo Yenileme',
        'desc'  => 'Anahtar teslim projelerde su ve elektrik tesisatından fayans döşemeye kadar her şey.',
        'link'  => '/hizmetler/mutfak-yenileme-hizmetleri',
    ],
    [
        'img'   => 'https://tadilatalanya.com/wp-content/uploads/2025/04/fayans-yenileme-tadilatalanya-ic-sayfa.jpg',
        'badge' => 'Fayans & Kalebodur',
        'title' => 'Uzun Ömürlü Fayans<br>Kalebodur Uygulamaları',
        'desc'  => 'Su yalıtımına özel önem vererek profesyonel fayans ve seramik çözümleri.',
        'link'  => '/hizmetler/fayans-kalebodur-yenileme-ve-onarim',
    ],
    [
        'img'   => 'https://tadilatalanya.com/wp-content/uploads/2025/04/tuvalet-tamirati-tadilatalanya.jpg',
        'badge' => 'Tuvalet Yenileme',
        'title' => 'Hijyenik & Modern<br>Tuvalet Tadilatı',
        'desc'  => 'Su kaçaklarından eski tesisata kadar kökten çözüm, estetik ve fonksiyonel tasarım.',
        'link'  => '/hizmetler/tuvalet-yenileme-ve-tamirati',
    ],
];
require_once __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO SLIDER ===== -->
<div class="hero-slider" id="heroSlider">
  <div class="slides-wrapper" id="slidesWrapper">
    <?php foreach ($slides as $slide): ?>
    <div class="slide">
      <img src="<?= h($slide['img']) ?>" alt="<?= h($slide['badge']) ?>" class="slide-img" loading="eager">
      <div class="slide-overlay"></div>
      <div class="slide-content container">
        <div class="slide-badge">⭐ <?= h($slide['badge']) ?></div>
        <h2><?= $slide['title'] ?></h2>
        <p><?= h($slide['desc']) ?></p>
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center">
          <a href="<?= h($slide['link']) ?>" class="slide-btn">Detaylı Bilgi →</a>
          <a href="/iletisim" style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.12);color:var(--white);font-weight:600;font-size:13px;padding:11px 20px;border-radius:var(--r);border:1px solid rgba(255,255,255,.25)">🔑 <?= h($hero_cta) ?></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Arrows -->
  <div class="slider-arrows">
    <button class="slider-arrow" id="prevBtn">‹</button>
    <button class="slider-arrow" id="nextBtn">›</button>
  </div>
</div>

<!-- Dots -->
<div class="slider-dots" id="sliderDots">
  <?php foreach ($slides as $i => $_): ?>
  <button class="slider-dot <?= $i===0?'active':'' ?>" data-index="<?= $i ?>"></button>
  <?php endforeach; ?>
</div>

<script>
(function(){
  const wrapper = document.getElementById('slidesWrapper');
  const dots = document.querySelectorAll('.slider-dot');
  let cur = 0, total = <?= count($slides) ?>, timer;

  function go(n) {
    cur = (n + total) % total;
    wrapper.style.transform = 'translateX(-' + cur * 100 + '%)';
    dots.forEach((d,i) => d.classList.toggle('active', i === cur));
  }

  function autoplay() { timer = setInterval(() => go(cur + 1), 4500); }

  document.getElementById('nextBtn').onclick = () => { clearInterval(timer); go(cur+1); autoplay(); };
  document.getElementById('prevBtn').onclick = () => { clearInterval(timer); go(cur-1); autoplay(); };
  dots.forEach(d => d.addEventListener('click', () => { clearInterval(timer); go(+d.dataset.index); autoplay(); }));

  // Touch swipe
  let tx = 0;
  wrapper.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, {passive:true});
  wrapper.addEventListener('touchend', e => {
    const diff = tx - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) { clearInterval(timer); go(diff > 0 ? cur+1 : cur-1); autoplay(); }
  }, {passive:true});

  autoplay();
})();
</script>

<!-- TRUST BAR -->
<?php if ($stats): ?>
<div class="trust-bar">
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

<!-- SERVICES -->
<section class="section">
  <div class="container">
    <div class="sec-tag">Hizmetlerimiz</div>
    <h2 class="sec-title">Evinizi Yenileyin, Hayatınız Değişsin!</h2>
    <p class="sec-desc">Alanya'da her türlü tadilat ve tamirat ihtiyacınız için uzman ekibimizle yanınızdayız.</p>
    <div class="services-list">
      <?php foreach ($services as $s): ?>
      <a href="/hizmetler/<?= h($s['slug']) ?>" class="service-card">
        <div class="service-card-accent"></div>
        <?php if ($s['image']): ?>
        <div style="width:90px;min-height:100%;flex-shrink:0;overflow:hidden;align-self:stretch">
          <img src="<?= h($s['image']) ?>" alt="<?= h($s['title']) ?>" style="width:100%;height:100%;object-fit:cover;display:block" loading="lazy">
        </div>
        <?php endif; ?>
        <div class="service-card-body">
          <h3><?= h($s['title']) ?></h3>
          <p><?= h($s['short_desc']) ?></p>
          <?php if ($s['features']): ?>
          <div class="service-tags">
            <?php foreach (explode(',', $s['features']) as $f): ?>
            <span class="stag"><?= h(trim($f)) ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="service-card-arrow">›</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHY US -->
<section class="section section-alt">
  <div class="container">
    <div class="sec-tag">Neden Biz?</div>
    <h2 class="sec-title"><?= h($about_title) ?></h2>
    <p class="sec-desc"><?= h($about_text) ?></p>
    <div class="why-grid">
      <?php foreach ([
        ['🆓','Ücretsiz Keşif','Alanya ve çevresinde ücretsiz keşif ve fiyat teklifi.'],
        ['🛡️','2 Yıl Garanti','Tüm işlerimize minimum 2 yıl garanti veriyoruz.'],
        ['⚡','Hızlı Teslim','Acil işlerde aynı gün müdahale, söz verilen süre.'],
        ['🏆','40 Yıl Tecrübe','Ustalarımız 40 yıllık deneyimiyle hizmetinizde.'],
      ] as $w): ?>
      <div class="why-item">
        <div class="why-icon"><?= $w[0] ?></div>
        <div><h4><?= $w[1] ?></h4><p><?= $w[2] ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Proje görselleri -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:32px">
      <img src="https://tadilatalanya.com/wp-content/uploads/2025/04/tadilat-hizmetleri-tadilatalanya.jpg" alt="Tadilat Alanya Hizmetleri" style="width:100%;height:180px;object-fit:cover;border-radius:var(--r2)" loading="lazy">
      <img src="https://tadilatalanya.com/wp-content/uploads/2025/04/tadilat-alanya-banner-3.jpg" alt="Tadilat Alanya" style="width:100%;height:180px;object-fit:cover;border-radius:var(--r2)" loading="lazy">
    </div>
  </div>
</section>

<!-- FAQ -->
<?php if ($faqs): ?>
<section class="section">
  <div class="container">
    <div class="sec-tag">Sık Sorulan Sorular</div>
    <h2 class="sec-title">Merak Ettikleriniz</h2>
    <div class="faq-list">
      <?php foreach ($faqs as $f): ?>
      <div class="faq-item">
        <button class="faq-q"><?= h($f['question']) ?><span class="icon">+</span></button>
        <div class="faq-a"><?= h($f['answer']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- BLOG -->
<?php if ($posts): ?>
<section class="section section-alt">
  <div class="container">
    <div class="sec-tag">Tadilat Rehberi</div>
    <h2 class="sec-title">Son Yazılar</h2>
    <div class="blog-grid">
      <?php foreach ($posts as $p): ?>
      <a href="/blog/<?= h($p['slug']) ?>" class="blog-card">
        <div class="blog-card-img">
          <?php if ($p['image']): ?><img src="<?= h($p['image']) ?>" alt="<?= h($p['title']) ?>" loading="lazy"><?php else: ?>📰<?php endif; ?>
        </div>
        <div class="blog-card-content" style="padding:14px;flex:1">
          <div class="blog-cat"><?= h($p['category']) ?></div>
          <h3><?= h($p['title']) ?></h3>
          <div class="blog-date"><?= h($p['published_at']) ?></div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:24px">
      <a href="/blog" style="display:inline-block;padding:12px 28px;border:1.5px solid var(--border);border-radius:var(--r);font-size:14px;font-weight:600;color:var(--text-2)">Tüm Yazılar →</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CONTACT FORM -->
<section class="section" id="iletisim">
  <div class="container">
    <div class="contact-grid">
      <div>
        <div class="sec-tag">İletişim</div>
        <h2 class="sec-title">Ücretsiz Fiyat Teklifi</h2>
        <p class="sec-desc" style="margin-bottom:20px">Formu doldurun, sizi arayalım.</p>
        <div class="contact-info">
          <div class="cinfo-item"><div class="cinfo-icon">📞</div><div><div class="cinfo-label">Telefon</div><a href="tel:<?= h($_site['phone_raw']) ?>" class="cinfo-val"><?= h($_site['phone']) ?></a></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">📍</div><div><div class="cinfo-label">Adres</div><div class="cinfo-val"><?= h(setting('site_address','Alanya, Antalya')) ?></div></div></div>
          <div class="cinfo-item"><div class="cinfo-icon">🕐</div><div><div class="cinfo-label">Çalışma Saatleri</div><div class="cinfo-val"><?= h(setting('site_working_hours','')) ?></div></div></div>
        </div>
      </div>
      <div>
        <?php if ($form_success): ?><div class="alert alert-success">✅ Mesajınız alındı! En kısa sürede sizi arayacağız.</div><?php endif; ?>
        <?php if ($form_error): ?><div class="alert alert-error"><?= h($form_error) ?></div><?php endif; ?>
        <form method="POST">
          <input type="hidden" name="contact_form" value="1">
          <div class="form-row">
            <div class="form-group"><label class="form-label">Adınız *</label><input class="form-control" name="name" required placeholder="Ad Soyad"></div>
            <div class="form-group"><label class="form-label">Telefon *</label><input class="form-control" name="phone" required placeholder="0555 000 00 00" type="tel"></div>
          </div>
          <div class="form-group">
            <label class="form-label">Hizmet</label>
            <select class="form-control" name="service">
              <option value="">Hizmet Seçin</option>
              <?php foreach ($services as $s): ?><option value="<?= h($s['title']) ?>"><?= h($s['title']) ?></option><?php endforeach; ?>
              <option value="Diğer">Diğer</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label">Mesajınız</label><textarea class="form-control" name="message" placeholder="İşin kapsamı hakkında bilgi verin..."></textarea></div>
          <button type="submit" class="btn-submit">🔑 Ücretsiz Fiyat Teklifi İste</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
