<?php
require_once 'helpers.php';
session_start();
$user = $_SESSION['user_name'] ?? null;
$role = $_SESSION['user_role'] ?? null;
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>BlockSight</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <div class="header">
    <div>
      <h1>BlockSight</h1>
      <div class="small">Connect companies and investors with auditable investment trails & ML-driven risk.</div>
    </div>
    <div class="nav">
      <a href="index.php">Home</a>
      <?php if($user): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout (<?=esc($user)?>)</a>
      <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </div>
  </div>

  <hr/>
  <p>Welcome to BlockSight — a minimal LAMP + ML PoC. Register as a <strong>company</strong> or <strong>investor</strong> to get started.</p>
  <p class="small">Company: create profile with financials + upload company PDF. Investor: register with photo and affiliations.</p>
</div>
</body>
</html>
