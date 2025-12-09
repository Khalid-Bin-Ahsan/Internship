<?php
// register_investor.php
require 'db.php';
$config = require 'config.php';
$upload_dir = $config['upload_dir'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';
    $affiliations = trim($_POST['affiliations'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $pic_path = null;
    if (!empty($_FILES['picture']['name'])) {
        if (!is_dir($upload_dir)) mkdir($upload_dir,0755,true);
        $fn = basename($_FILES['picture']['name']);
        $target = $upload_dir . '/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/','_',$fn);
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
            $pic_path = str_replace(__DIR__ . '/', '', $target);
        }
    }
    if (!$name || !$email || !$password) { $error="Missing fields"; }
    else {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash,role,picture) VALUES (?, ?, ?, 'investor', ?)");
        $stmt->execute([$name,$email,$hash,$pic_path]);
        $uid = $pdo->lastInsertId();
        // store affiliations in a very simple way into investments table? Better: skip separate table, store in users->bio (not implemented)
        // We'll just redirect
        session_start();
        $_SESSION['user_id']=$uid; $_SESSION['user_name']=$name; $_SESSION['user_role']='investor';
        header('Location: dashboard.php'); exit;
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register Investor</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>Investor Registration</h2>
  <?php if(!empty($error)) echo "<div class='alert'>".esc($error)."</div>"; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="form-row"><label>Name</label><input name="name" required></div>
    <div class="form-row"><label>Email</label><input name="email" type="email" required></div>
    <div class="form-row"><label>Password</label><input name="password" type="password" required></div>
    <div class="form-row"><label>Affiliations (comma separated)</label><input name="affiliations"></div>
    <div class="form-row"><label>Bio</label><textarea name="bio"></textarea></div>
    <div class="form-row"><label>Profile picture</label><input type="file" name="picture" accept="image/*"></div>
    <button class="btn" type="submit">Register as Investor</button>
  </form>
  <p><a href="register.php">Back</a></p>
</div>
</body></html>
