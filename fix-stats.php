<?php
require_once __DIR__ . '/includes/db.php';
session_start();
require_admin();
db_query("DELETE FROM stats");
$stats = [['40+','Yıllık Tecrübe',0],['500+','Tamamlanan Proje',1],['100%','Müşteri Memnuniyeti',2],['2 Yıl','İş Garantisi',3]];
foreach ($stats as $s) { db_query("INSERT INTO stats (number_text,label,sort_order) VALUES (?,?,?)", $s); }
echo '✅ Temizlendi! <a href="/">Siteye git</a>';
```

6. **Kaydet** → Notepad'i kapat

Sonra CMD'de:
```
git add .
git commit -m "stats duzelt"
git push origin main