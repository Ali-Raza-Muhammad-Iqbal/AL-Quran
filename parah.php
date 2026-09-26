<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$db = new PDO("sqlite:db/quran.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$parah_id = intval($_GET['id']);

/* =====================
   GET PARAH INFO
===================== */
$parah = $db->prepare("SELECT * FROM parah WHERE id=?");
$parah->execute([$parah_id]);
$parah = $parah->fetch(PDO::FETCH_ASSOC);

if (!$parah) {
    die("Invalid Parah");
}

/* =====================
   AYAH TABLE (IF NOT EXISTS)
===================== */
$db->exec("
CREATE TABLE IF NOT EXISTS ayahs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    surah TEXT,
    ayah_no INTEGER,
    parah_id INTEGER,
    text_ar TEXT,
    text_en TEXT
)
");

/* =====================
   SAMPLE DATA (ONLY ONCE)
===================== */
$count = $db->query("SELECT COUNT(*) FROM ayahs")->fetchColumn();
if ($count == 0) {
    $db->exec("
    INSERT INTO ayahs (surah,ayah_no,parah_id,text_ar,text_en) VALUES
    ('Al-Baqarah',1,1,'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ','In the name of Allah, the Most Gracious, the Most Merciful'),
    ('Al-Baqarah',2,1,'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ','All praise is due to Allah, Lord of the worlds'),
    ('Al-Baqarah',142,2,'سَيَقُولُ السُّفَهَاءُ','The foolish among the people will say')
    ");
}

/* =====================
   FETCH AYAHs BY PARAH
===================== */
$stmt = $db->prepare("SELECT * FROM ayahs WHERE parah_id=? ORDER BY id");
$stmt->execute([$parah_id]);
$ayahs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parah <?= $parah['id'] ?></title>
    <link href="assets/bootstrap.min.css" rel="stylesheet">
    <style>
        .ayah-ar {
            font-size: 26px;
            direction: rtl;
            text-align: right;
            font-family: 'Scheherazade', serif;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <a href="index.php" class="navbar-brand">⬅ Parahs</a>
        <span class="text-white">
            Parah <?= $parah['id'] ?> — <?= $parah['name'] ?>
        </span>
    </div>
</nav>

<div class="container mt-4">

<?php if (count($ayahs) == 0): ?>
    <div class="alert alert-warning">No Ayahs found for this Parah.</div>
<?php endif; ?>

<?php foreach ($ayahs as $a): ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="ayah-ar">
                <?= $a['text_ar'] ?>
            </div>
            <hr>
            <p class="mb-0 text-muted">
                <strong><?= $a['surah'] ?> : <?= $a['ayah_no'] ?></strong><br>
                <?= $a['text_en'] ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>

</div>

</body>
</html>
