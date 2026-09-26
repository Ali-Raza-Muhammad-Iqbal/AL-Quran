<?php
session_start();

/* =====================
   DATABASE (SQLite)
===================== */
$db = new PDO("sqlite:db/users.db");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* =====================
   CREATE TABLE (once)
===================== */
$db->exec("
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    email TEXT UNIQUE,
    password TEXT
)
");

/* =====================
   REGISTER
===================== */
$msg = "";
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->execute([$name, $email, $pass]);
        $msg = "<div class='alert alert-success'>Registration successful. Please login.</div>";
    } catch (PDOException $e) {
        $msg = "<div class='alert alert-danger'>Email already exists.</div>";
    }
}

/* =====================
   LOGIN
===================== */
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: MainPage.php");
        exit;
    } else {
        $msg = "<div class='alert alert-danger'>Invalid login credentials</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">

                    <h4 class="text-center mb-3">🔐 Login</h4>
                    <?= $msg ?>

                    <form method="post">
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                        <button name="login" class="btn btn-primary w-100">Login</button>
                    </form>

                    <hr>

                    <h5 class="text-center">📝 Register</h5>
                    <form method="post">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                        <button name="register" class="btn btn-success w-100">Register</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
