<?php
session_start();
if (isset($_SESSION['admin'])) { header("Location: dashboard.php"); exit(); }

include '../config/database.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['username'];
            header("Location: dashboard.php"); exit();
        }
    }
    $error = "Username atau password salah.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Ucii Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #FFC107;
            --dark-bg: #0a0c14;
            --card-bg: #111527;
            --border: rgba(255,255,255,0.08);
            --muted: rgba(232,233,239,0.4);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--dark-bg);
            font-family: 'DM Sans', sans-serif;
            color: #e8e9ef;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-box {
            width: 100%;
            max-width: 380px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-brand {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 6px;
        }
        .brand-dot {
            width: 8px; height: 8px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--gold);
        }
        .login-sub {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: 0.5px;
        }
        .login-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 32px 28px;
        }
        .login-card h5 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }
        .field-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }
        .op-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: #e8e9ef;
            outline: none;
            transition: border-color 0.2s;
            margin-bottom: 16px;
        }
        .op-input:focus { border-color: rgba(255,193,7,0.5); }
        .op-input::placeholder { color: rgba(232,233,239,0.2); }
        .error-box {
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.25);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #f87171;
            margin-bottom: 16px;
        }
        .btn-login {
            width: 100%;
            padding: 13px;
            background: var(--gold);
            border: none;
            border-radius: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #0a0c14;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 4px;
        }
        .btn-login:hover { background: #e6b000; }
        .login-hint {
            text-align: center;
            font-size: 11px;
            color: rgba(232,233,239,0.2);
            margin-top: 16px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-header">
        <div class="login-brand">
            <div class="brand-dot"></div>
            UCII STORE
        </div>
        <div class="login-sub">Admin Panel</div>
    </div>
    <div class="login-card">
        <h5>Masuk ke Dashboard</h5>
        <?php if ($error): ?>
        <div class="error-box"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="field-label">Username</div>
            <input type="text" class="op-input" name="username"
                   placeholder="Masukkan username" required autocomplete="username">
            <div class="field-label">Password</div>
            <input type="password" class="op-input" name="password"
                   placeholder="Masukkan password" required autocomplete="current-password">
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        <div class="login-hint">Default: admin / admin123</div>
    </div>
</div>
</body>
</html>