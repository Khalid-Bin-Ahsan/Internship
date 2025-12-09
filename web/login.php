<?php
// login.php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$email || !$password) { $error="Missing fields"; }
    else {
        $stmt = $pdo->prepare("SELECT id,name,password_hash,role FROM users WHERE email = ?");
        $stmt->execute([$email]); $u = $stmt->fetch();
        if ($u && password_verify($password, $u['password_hash'])) {
            session_start();
            $_SESSION['user_id']=$u['id']; $_SESSION['user_name']=$u['name']; $_SESSION['user_role']=$u['role'];
            header('Location: dashboard.php'); exit;
        } else { $error="Invalid credentials"; }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>Login</h2>
  <?php if(!empty($error)) echo "<div class='alert'>".esc($error)."</div>"; ?>
  <form method="post">
    <div class="form-row"><label>Email</label><input name="email" type="email" required></div>
    <div class="form-row"><label>Password</label><input name="password" type="password" required></div>
    <button class="btn" type="submit">Login</button>
  </form>
  <p><a href="register.php">Register</a></p>
</div>
</body></html>
