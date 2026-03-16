<!-- Float CTA (mobile only) -->
<div class="float-cta">
  <a href="tel:<?= h($_site['phone_raw']) ?>" class="call">📞 Hemen Ara</a>
  <a href="https://wa.me/<?= h($_site['whatsapp']) ?>?text=Merhaba, bilgi almak istiyorum." target="_blank" class="whatsapp">💬 WhatsApp</a>
</div>

<footer class="site-footer">
  <div class="container">
    <div class="footer-inner">
      <div>
        <img src="https://tadilatalanya.com/wp-content/uploads/2021/10/tadilatalanya-logo-mobile.png" alt="Tadilat Alanya" style="height:40px;margin-bottom:12px">
        <p class="footer-desc"><?= h($_site['tagline']) ?> — Kaliteli işçilik, zamanında teslim.</p>
        <a href="tel:<?= h($_site['phone_raw']) ?>" class="footer-phone"><?= h($_site['phone']) ?></a>
      </div>
      <div>
        <div style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px">Hizmetler</div>
        <div class="footer-links">
          <?php foreach ($_services_nav as $s): ?>
          <a href="/hizmetler/<?= h($s['slug']) ?>"><?= h($s['title']) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <div style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:14px">Bağlantılar</div>
        <div class="footer-links">
          <a href="/">Ana Sayfa</a>
          <a href="/hakkimizda">Hakkımızda</a>
          <a href="/blog">Blog</a>
          <a href="/iletisim">İletişim</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> <?= h($_site['title']) ?> — Tüm hakları saklıdır.</div>
  </div>
</footer>

<script>
// Mobile nav
const toggle = document.getElementById('navToggle');
const nav = document.getElementById('mobileNav');
if(toggle && nav){
  toggle.addEventListener('click',()=>{
    toggle.classList.toggle('open');
    nav.classList.toggle('open');
    document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
  });
}
// FAQ accordion
document.querySelectorAll('.faq-q').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(i=>i.classList.remove('open'));
    if(!isOpen) item.classList.add('open');
  });
});
</script>
</body>
</html>
