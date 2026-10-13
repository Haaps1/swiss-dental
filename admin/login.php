<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $admin_username = 'admin';
    $admin_password = 'SwissDental@2026';

    if ($username === $admin_username && $password === $admin_password) {

        session_regenerate_id(true);

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_username;

        header('Location: index.php');
        exit;

    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Swiss Dental</title>

<style>
*{box-sizing:border-box;}

body{
    margin:0;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#080808;
    color:#fff;
    font-family:Arial,sans-serif;
}

.login-box{
    width:100%;
    max-width:420px;
    padding:40px;
    background:#111;
    border:1px solid #292929;
    border-radius:14px;
}

.logo{text-align:center;margin-bottom:30px;}
.logo h1{margin:0 0 8px;font-size:28px;}
.logo p{margin:0;color:#999;font-size:14px;}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
}

input{
    width:100%;
    padding:13px 14px;
    margin-bottom:20px;
    border:1px solid #333;
    border-radius:8px;
    background:#080808;
    color:#fff;
    font-size:15px;
}

input:focus{
    outline:none;
    border-color:#ffde00;
}

button{
    width:100%;
    padding:14px;
    border:0;
    border-radius:8px;
    background:#ffde00;
    color:#000;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
}

.error{
    margin-bottom:20px;
    padding:12px;
    border-radius:8px;
    background:#2a1111;
    color:#ff8d8d;
    font-size:14px;
}
</style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        <h1>Swiss Dental</h1>
        <p>Blog Admin Panel</p>
    </div>

    <?php if ($error): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label for="username">Username</label>

        <input
            type="text"
            id="username"
            name="username"
            required
            autocomplete="username"
        >

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            required
            autocomplete="current-password"
        >

        <button type="submit">Login</button>

    </form>

</div>

</body>
</html>