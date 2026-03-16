<?php
require_once __DIR__ . '/includes/db.php';
session_start();
require_admin();

$posts = [
    [
        'title' => 'Alanya\'da Banyo Tadilatı Nasıl Yapılır? 2025 Rehberi',
        'slug' => 'alanyada-banyo-tadilati-nasil-yapilir-2025-rehberi',
        'category' => 'Alanya Banyo Yenileme',
        'excerpt' => 'Alanya\'da banyo tadilatı yaparken nelere dikkat etmeli? Malzeme seçiminden ustaya kadar tüm detayları anlattık.',
        'content' => 'Alanya\'da Banyo Tadilatı: Bilmeniz Gereken Her Şey

Alanya\'nın nemli ve sıcak iklimi, banyo tadilatında kullanılacak malzemelerin seçimini doğrudan etkiler. Yanlış malzeme seçimi kısa sürede küf, rutubet ve boya soyulması gibi sorunlara yol açabilir.

Malzeme Seçimi

Alanya iklimine uygun malzeme seçimi en kritik adımdır. Su geçirmez ve neme dayanıklı malzemeler tercih edilmelidir. Fayans ve seramik seçiminde su emme oranı düşük ürünler seçilmeli, derz dolgusu olarak mantar veya silikon bazlı ürünler kullanılmalıdır.

Tesisat Kontrolü

Banyo tadilatından önce mutlaka mevcut su tesisatı kontrol edilmelidir. Alanya\'daki eski binalarda paslanmış veya çatlak borular yaygın görülür. Tadilat sırasında boru yenileme maliyeti sonradan çok daha ucuza gelmektedir.

Zemin ve Duvar Kaplaması

Banyo zemininde kaymaz özellikli fayans tercih edilmesi hem güvenlik hem de uzun ömür açısından önemlidir. Duvar kaplamalarında ise en az 2 metre yüksekliğe kadar su yalıtımlı malzeme kullanılmalıdır.

Havalandırma

Alanya\'nın nemli ikliminde banyo havalandırması çok kritiktir. Yetersiz havalandırma küf ve rutubet sorununa yol açar. Mekanik havalandırma sistemi veya pencere tadilatı mutlaka göz önünde bulundurulmalıdır.

Profesyonel Destek

Tüm bu işleri kendiniz yapmaya çalışmak yerine 40 yıllık tecrübeli ustalarımızdan ücretsiz keşif talep edebilirsiniz. Alanya\'nın iklimine özel çözümler sunuyor, tüm işlerimize 2 yıl garanti veriyoruz.',
        'meta_title' => 'Alanya\'da Banyo Tadilatı 2025 | Fiyat ve Rehber – Tadilat Alanya',
        'meta_desc' => 'Alanya\'da banyo tadilatı fiyatları, malzeme seçimi ve dikkat edilmesi gerekenler. 40 yıllık tecrübeyle ücretsiz keşif için hemen arayın.',
        'image' => 'https://tadilatalanya.com/wp-content/uploads/2025/04/mutfak-banyo-yenileme-tadilat-alanya.jpg',
        'date' => '2025-03-10',
    ],
    [
        'title' => 'Alanya\'da Mutfak Yenileme: Anahtar Teslim Proje Süreci',
        'slug' => 'alanyada-mutfak-yenileme-anahtar-teslim-proje-sureci',
        'category' => 'Alanya Mutfak Yenileme',
        'excerpt' => 'Alanya\'da mutfak yenileme projesi nasıl yürütülür? Planlama aşamasından teslime kadar tüm süreç.',
        'content' => 'Alanya\'da Mutfak Yenileme Süreci

Mutfak yenileme, ev tadilatları arasında en kapsamlı ve en çok değer katan projelerden biridir. Doğru planlama yapıldığında hem estetik hem de fonksiyonel bir mutfağa kavuşmak mümkündür.

Planlama ve Tasarım

İyi bir mutfak yenileme projesi sağlam bir planlamayla başlar. Mevcut mutfağın ölçüleri alınır, kullanım alışkanlıkları değerlendirilir ve bütçe belirlenir. Alanya\'daki evlerin büyük çoğunluğunda dar ve uzun mutfak planları görülür; bu nedenle akıllı depolama çözümleri büyük önem taşır.

Dolap Sistemleri

Modern mutfak dolapları için PVC, lak veya akrilik kapak seçenekleri mevcuttur. Alanya\'nın nemine dayanıklı olması açısından PVC kaplamalar özellikle tavsiye edilir. İç mekan organizasyonu için çekmece sistemleri ve raf düzenleyiciler mutfak kullanımını kolaylaştırır.

Tezgah Seçimi

Granit, mermer ve kompakt tezgahlar en çok tercih edilen seçeneklerdir. Granit hem estetik hem de dayanıklılık açısından öne çıkar. Kompakt tezgahlar ise çizilmeye ve ısıya karşı direnç konusunda üstündür.

Fayans ve Zemin

Mutfak zemininde porselen granit veya büyük formatlı seramikler şık bir görünüm sağlar. Tezgah arkası için metro fayans veya cam mozaik popüler tercihler arasındadır.

Tesisat ve Elektrik

Mutfak yenileme sırasında su ve elektrik tesisatının da gözden geçirilmesi önerilir. Bulaşık makinesi, fırın ve davlumbaz için gerekli elektrik bağlantıları planlanmalıdır.

Anahtar Teslim Hizmet

Tadilat Alanya olarak mutfak yenileme projelerini baştan sona yönetiyoruz. Tasarımdan malzeme seçimine, uygulamadan temizliğe kadar tüm süreç bizim kontrolümüzdedir.',
        'meta_title' => 'Alanya Mutfak Yenileme 2025 | Anahtar Teslim – Tadilat Alanya',
        'meta_desc' => 'Alanya\'da mutfak yenileme fiyatları ve proje süreci. Dolap, tezgah, fayans ve tesisat dahil anahtar teslim hizmet. Ücretsiz keşif için arayın.',
        'image' => 'https://tadilatalanya.com/wp-content/uploads/2025/04/mutfak-banyo-yenileme-tadilat-alanya.jpg',
        'date' => '2025-03-15',
    ],
    [
        'title' => 'Alanya\'da Fayans Döşeme: Doğru Malzeme ve Uygulama Teknikleri',
        'slug' => 'alanyada-fayans-doseme-dogru-malzeme-ve-uygulama-teknikleri',
        'category' => 'Alanya Fayansçı',
        'excerpt' => 'Alanya\'da fayans döşemede hangi malzemeler kullanılmalı? Nemli iklime dayanıklı fayans seçimi ve uygulama ipuçları.',
        'content' => 'Alanya\'da Fayans Döşeme Rehberi

Alanya\'nın Akdeniz iklimine uygun fayans seçimi ve doğru uygulama teknikleri, uzun ömürlü ve sorunsuz bir zemin veya duvar kaplaması için vazgeçilmezdir.

Fayans Türleri

Seramik Fayans: Ekonomik ve geniş renk seçeneği sunan seramik fayanslar iç mekanlarda yaygın kullanılır. Su emme oranı yüksek olduğundan dış mekanlarda tercih edilmez.

Porselen Granit: Çok düşük su emme oranıyla Alanya\'nın nemli ortamına en uygun seçenektir. Hem iç hem dış mekanlarda güvenle kullanılabilir.

Doğal Taş: Mermer, traverten ve granit gibi doğal taşlar estetik görünüm sağlar ancak düzenli bakım gerektirir.

Su Yalıtımı

Alanya\'da fayans döşemeden önce su yalıtımı yapılması büyük önem taşır. Özellikle banyo, mutfak ve teras gibi ıslak alanlarda yalıtım atlanmamalıdır. Su yalıtımı yapılmadan döşenen fayanslar zamanla nem nedeniyle çatlar ve dökülür.

Derz Seçimi

Fayans aralarındaki derz malzemesi de iklime uygun seçilmelidir. Epoksi derz, su ve kimyasallara karşı en dayanıklı seçenektir. Banyo ve mutfak gibi ıslak alanlarda mutlaka tercih edilmelidir.

Uygulama Teknikleri

Zemin düzleme işlemi fayans döşemenin en kritik adımıdır. Düzgün olmayan zemin üzerine döşenen fayanslar kısa sürede çatlar. Yapıştırıcı seçiminde de iklime uygun ürünler tercih edilmelidir.

Profesyonel Uygulama

40 yıllık tecrübemizle Alanya\'da yüzlerce fayans uygulama projesi gerçekleştirdik. Ücretsiz keşif için hemen arayın.',
        'meta_title' => 'Alanya Fayans Döşeme 2025 | Fiyat ve Uygulama – Tadilat Alanya',
        'meta_desc' => 'Alanya\'da fayans döşeme fiyatları, malzeme seçimi ve uygulama teknikleri. Nemli iklime dayanıklı çözümler için 40 yıllık tecrübe.',
        'image' => 'https://tadilatalanya.com/wp-content/uploads/2025/04/fayans-yenileme-tadilatalanya-ic-sayfa.jpg',
        'date' => '2025-03-20',
    ],
    [
        'title' => 'Alanya\'da Boya Badana: İklime Uygun Boya Seçimi ve Fiyatlar',
        'slug' => 'alanyada-boya-badana-iklime-uygun-boya-secimi-ve-fiyatlar',
        'category' => 'Alanya Boya Badana',
        'excerpt' => 'Alanya\'nın sıcak ve nemli iklimine uygun boya seçimi nasıl yapılır? İç ve dış cephe boya fiyatları ve dikkat edilmesi gerekenler.',
        'content' => 'Alanya\'da Boya Badana Rehberi

Alanya\'nın Akdeniz iklimi dış cephe boyaları için zorlu koşullar yaratır. Yüksek UV ışını, tuz ve nem içeren hava, yanlış boya seçiminde hızlı bozulmaya neden olur.

İç Cephe Boya Seçimi

İç mekanlarda su bazlı boyalar en sağlıklı ve pratik seçenektir. Nem oranı yüksek olan Alanya\'da iç mekanlarda antifungal (küf önleyici) boya kullanımı tavsiye edilir. Banyo ve mutfak gibi ıslak alanlarda özel ıslak mekan boyaları tercih edilmelidir.

Dış Cephe Boya Seçimi

Dış cephede silikonlu veya akrilik boyalar en uzun ömürlü seçeneklerdir. Bu boyalar UV ışınlarına, yağmur ve tuz içeren deniz havasına karşı yüksek direnç gösterir. Alanya\'da dış cephe boyalarının en az 8-10 yıl dayanması beklenir.

Uygulama Öncesi Hazırlık

Boya uygulaması öncesinde yüzey hazırlığı son derece önemlidir. Eski boya, çatlaklar ve nem lekeleri mutlaka giderilmelidir. Gerektiğinde sıva tamiri yapılarak yüzey düzeltilmelidir.

Renk Seçimi

Alanya\'nın güneşli iklimine uygun renk seçimi hem estetik hem de pratik faydalar sağlar. Açık renkler ısıyı yansıtarak bina içini serin tutar. Koyu renkler ise daha hızlı solar ve bozulur.

Garanti ve Kalite

Tadilat Alanya olarak tüm boya badana işlerimize 2 yıl garanti veriyoruz. Kaliteli malzeme ve tecrübeli ustalarımızla uzun ömürlü sonuçlar elde ediyoruz.',
        'meta_title' => 'Alanya Boya Badana 2025 | Fiyat ve Malzeme – Tadilat Alanya',
        'meta_desc' => 'Alanya\'da boya badana fiyatları ve iklime uygun boya seçimi. İç ve dış cephe boya hizmetleri için 40 yıllık tecrübe. Ücretsiz keşif.',
        'image' => 'https://tadilatalanya.com/wp-content/uploads/2025/04/boya-badana-hizmetleri-tadilatalanya.jpg',
        'date' => '2025-04-01',
    ],
    [
        'title' => 'Alanya\'da Ev Tadilatı Maliyeti 2025: Güncel Fiyat Rehberi',
        'slug' => 'alanyada-ev-tadilati-maliyeti-2025-guncel-fiyat-rehberi',
        'category' => 'Alanya Tamirat Hizmetleri',
        'excerpt' => 'Alanya\'da ev tadilatı ne kadar tutar? 2025 yılı güncel fiyatları ve bütçe planlaması için kapsamlı rehber.',
        'content' => 'Alanya\'da Ev Tadilatı Maliyeti 2025

Alanya\'da ev tadilatı maliyeti; yapılacak işin kapsamı, kullanılacak malzemelerin kalitesi ve işçilik ücretlerine göre değişir. Bu rehberde 2025 yılı güncel fiyat aralıklarını paylaşıyoruz.

Banyo Tadilatı Maliyeti

Küçük banyo yenileme (fayans + boya + tesisat): 15.000 - 25.000 TL
Orta boy banyo komple yenileme: 25.000 - 45.000 TL
Büyük banyo lüks yenileme: 45.000 TL ve üzeri

Bu fiyatlar malzeme kalitesine ve kullanılacak ürünlere göre değişkenlik gösterir.

Mutfak Yenileme Maliyeti

Dolap yenileme (kapak + gövde): 20.000 - 40.000 TL
Tezgah değişimi: 5.000 - 15.000 TL
Komple mutfak yenileme: 35.000 - 80.000 TL

Boya Badana Maliyeti

Oda boya (20-25 m²): 3.000 - 6.000 TL
Daire komple boya (100 m²): 12.000 - 20.000 TL
Dış cephe boya (metrekare başına): 150 - 300 TL

Fayans Döşeme Maliyeti

Fayans döşeme işçiliği (m² başına): 200 - 400 TL
Malzeme dahil fayans döşeme: 400 - 900 TL/m²

Bütçe Planlaması İpuçları

Tadilatı aşamalı yapmak yerine toplu yaptırmak hem maliyet hem de zaman açısından avantaj sağlar. Ücretsiz keşif hizmetimizden yararlanarak projeniz için kesin fiyat teklifi alabilirsiniz.

Ücretsiz Keşif

Tadilat Alanya olarak Alanya ve çevresinde ücretsiz keşif hizmeti sunuyoruz. Projenizi yerinde değerlendirerek size en uygun fiyat teklifini sunuyoruz.',
        'meta_title' => 'Alanya Ev Tadilatı Fiyatları 2025 | Güncel Rehber – Tadilat Alanya',
        'meta_desc' => 'Alanya\'da ev tadilatı maliyeti 2025. Banyo, mutfak, boya ve fayans tadilatı güncel fiyatları. Ücretsiz keşif için hemen arayın.',
        'image' => 'https://tadilatalanya.com/wp-content/uploads/2025/04/tadilat-hizmetleri-tadilatalanya.jpg',
        'date' => '2025-04-10',
    ],
];

$count = 0;
foreach ($posts as $p) {
    $exists = db_row("SELECT id FROM blog_posts WHERE slug=?", [$p['slug']]);
    if (!$exists) {
        db_query(
            "INSERT INTO blog_posts (title,slug,category,excerpt,content,image,meta_title,meta_desc,published,published_at) VALUES (?,?,?,?,?,?,?,?,1,?)",
            [$p['title'],$p['slug'],$p['category'],$p['excerpt'],$p['content'],$p['image'],$p['meta_title'],$p['meta_desc'],$p['date']]
        );
        $count++;
    }
}

echo "✅ $count blog yazısı eklendi! <a href='/blog'>Blog sayfasına git</a> | <a href='/admin/blog.php'>Admin paneli</a>";
