<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* =====================
   DATABASES
===================== */
$quranDB = new PDO("sqlite:db/quran.db");
$quranDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userDB = new PDO("sqlite:db/users.db");
$userDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* =====================
   PARAH TABLE
===================== */
$quranDB->exec("
CREATE TABLE IF NOT EXISTS parah (
    id INTEGER PRIMARY KEY,
    name TEXT
)
");

/* =====================
   INSERT PARAH NAMES (ONCE)
===================== */
$count = $quranDB->query("SELECT COUNT(*) FROM parah")->fetchColumn();
if ($count == 0) {
    $names = [
        'Alif Laam Meem','Sayaqool','Tilkal Rusul','Lan Tana Loo','Wal Mohsanat',
        'La Yuhibbullah','Wa Iza Samiu','Wa Lau Annana','Qad Aflaha',
        'Wa A’lamu','Yatazeroon','Wa Ma Min Daabbah','Wa Ma Ubrioo',
        'Rubama','Subhanallazi','Qal Alam','Iqtarabat','Qadd Aflaha',
        'Wa Qalallazina','Aman Khalaq','Utlu Ma Oohi','Wa Man Yaqnut',
        'Wa Mali','Faman Azlam','Elahe Yuruddo','Ha Meem',
        'Qala Fama Khatbukum','Qad Sami Allah','Tabarakallazi','Amma'
    ];
    $stmt = $quranDB->prepare("INSERT INTO parah VALUES (?,?)");
    foreach ($names as $i => $n) {
        $stmt->execute([$i + 1, $n]);
    }
}

/* =====================
   SAVE LESSON
===================== */
if (isset($_POST['save_lesson'])) {
    $parah_no = intval($_POST['parah_no']);
    $ayah_no  = intval($_POST['ayah_no']);

    $stmt = $userDB->prepare("
        INSERT INTO user_lesson (user_id, parah_no, ayah_no)
        VALUES (?,?,?)
        ON CONFLICT(user_id)
        DO UPDATE SET
            parah_no=excluded.parah_no,
            ayah_no=excluded.ayah_no,
            updated_at=CURRENT_TIMESTAMP
    ");
    $stmt->execute([$user_id, $parah_no, $ayah_no]);

    $msg = "Last lesson saved successfully.";
}

/* =====================
   FETCH LAST LESSON
===================== */
$stmt = $userDB->prepare("SELECT * FROM user_lesson WHERE user_id=?");
$stmt->execute([$user_id]);
$lastLesson = $stmt->fetch(PDO::FETCH_ASSOC);

/* =====================
   FETCH PARAH
===================== */
$parahs = $quranDB->query("SELECT * FROM parah ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Al Qur'an – Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <span class="navbar-brand">📖 Al Qur'an</span>
        <div class="text-white">
            <?= htmlspecialchars($_SESSION['name']) ?>
            <a href="logout.php" class="btn btn-light btn-sm ms-2">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- LAST LESSON -->
    <?php if ($lastLesson): ?>
    <div class="alert alert-info">
        📌 <strong>Last Read:</strong>
        Parah <?= $lastLesson['parah_no'] ?>,
        Ayah <?= $lastLesson['ayah_no'] ?>
        <a href="db/pdf/<?= $lastLesson['parah_no'] ?>.pdf"
           target="_blank" class="btn btn-sm btn-primary ms-2">
            Resume
        </a>
    </div>
    <?php endif; ?>

    <?php if (!empty($msg)): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <!-- SAVE LESSON FORM -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Save Last Lesson</h5>
            <form method="post" class="row g-2">
                <div class="col-md-4">
                    <input type="number" name="parah_no" min="1" max="30"
                           class="form-control" placeholder="Parah No" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="ayah_no"
                           class="form-control" placeholder="Ayah No" required>
                </div>
                <div class="col-md-4">
                    <button name="save_lesson" class="btn btn-success w-100">
                        Save Lesson
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- PARAH LIST -->
    <div class="row">
        <?php foreach ($parahs as $p): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5>Parah <?= $p['id'] ?></h5>
                    <p><?= $p['name'] ?></p>
                    <a href="db/pdf/<?= $p['id'] ?>.pdf"
                       target="_blank" class="btn btn-outline-success btn-sm">
                        Open PDF
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-success text-white text-center py-3 mt-4">
    <div>
        Developed by <strong>Ali Raza</strong> | 
        All content is copyright-free, users can download and use freely.
    </div>
</footer>

</body>
</html>
