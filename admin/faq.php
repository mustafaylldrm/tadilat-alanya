<?php
// Admin FAQ
$admin_page = 'faq';
require_once __DIR__ . '/../includes/db.php';
session_start(); require_admin();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_all'])) {
        db_query("DELETE FROM faq");
        $qs = $_POST['question'] ?? [];
        $as = $_POST['answer'] ?? [];
        foreach ($qs as $i => $q) {
            if (trim($q)) db_query("INSERT INTO faq (question,answer,sort_order,active) VALUES (?,?,?,1)", [trim($q), trim($as[$i]??''), $i]);
        }
        $msg = '✅ SSS kaydedildi.';
    }
}
if (isset($_GET['delete'])) { db_query("DELETE FROM faq WHERE id=?", [(int)$_GET['delete']], 'i'); header('Location: /admin/faq.php?ok=1'); exit; }
$faqs = db_query("SELECT * FROM faq ORDER BY sort_order");
$page_title = 'Sıkça Sorulan Sorular';
require_once __DIR__ . '/admin_header.php';
?>
<?php if ($msg || isset($_GET['ok'])): ?><div class="alert alert-success">✅ İşlem tamamlandı.</div><?php endif; ?>
<div class="card">
  <div class="card-header">
    <div class="card-title">SSS Yönetimi (<?= count($faqs) ?> soru)</div>
    <button type="button" class="btn btn-primary btn-sm" onclick="addFaq()">+ Soru Ekle</button>
  </div>
  <form method="POST" id="faqForm">
    <div id="faqList">
      <?php foreach ($faqs as $i => $f): ?>
      <div class="faq-row" style="border:1px solid #E2E8F0;border-radius:8px;padding:16px;margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;margin-bottom:10px">
          <span style="font-weight:700;font-size:12px;color:#64748B">SORU <?= $i+1 ?></span>
          <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.faq-row').remove()">🗑️ Sil</button>
        </div>
        <div class="form-group"><label class="form-label">Soru</label><input class="form-control" name="question[]" value="<?= h($f['question']) ?>" required></div>
        <div class="form-group"><label class="form-label">Cevap</label><textarea class="form-control" name="answer[]"><?= h($f['answer']) ?></textarea></div>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="submit" name="save_all" class="btn btn-primary">💾 Tümünü Kaydet</button>
  </form>
</div>
<script>
let count = <?= count($faqs) ?>;
function addFaq(){
  count++;
  const div = document.createElement('div');
  div.className = 'faq-row';
  div.style = 'border:1px solid #E2E8F0;border-radius:8px;padding:16px;margin-bottom:12px';
  div.innerHTML = `<div style="display:flex;justify-content:space-between;margin-bottom:10px"><span style="font-weight:700;font-size:12px;color:#64748B">SORU ${count}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.faq-row').remove()">🗑️ Sil</button></div><div class="form-group"><label class="form-label">Soru</label><input class="form-control" name="question[]" required></div><div class="form-group"><label class="form-label">Cevap</label><textarea class="form-control" name="answer[]"></textarea></div>`;
  document.getElementById('faqList').appendChild(div);
}
</script>
</main></div></body></html>
