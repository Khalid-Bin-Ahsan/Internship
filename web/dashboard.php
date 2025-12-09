<?php
require 'helpers.php';
require 'db.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }
session_start();
$uid = current_user_id(); $role = current_user_role(); $name = $_SESSION['user_name'];
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Dashboard</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <div class="header">
    <div><h2>Dashboard</h2><div class="small">Hello, <?=esc($name)?> (<?=esc($role)?>)</div></div>
    <div class="nav">
      <a href="index.php">Home</a>
      <?php if($role==='company'): ?><a href="company_create.php">My Company</a><a href="funding_create.php">Post Funding</a><a href="fundings.php">Find Investors</a><?php else: ?><a href="fundings.php">Find Companies</a><?php endif; ?>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <?php if ($role === 'company'): ?>
    <?php
      $stmt = $pdo->prepare("SELECT * FROM companies WHERE user_id = ? LIMIT 1");
      $stmt->execute([$uid]); $c = $stmt->fetch();
      if (!$c) {
        echo "<p>You don't have a company profile yet. <a href='company_create.php' class='btn'>Create Company</a></p>";
      } else {
        echo "<div class='card'><h3>".esc($c['company_name'])."</h3><p>".nl2br(esc($c['description']))."</p><p>Industry: ".esc($c['industry'])." | Revenue: ".number_format($c['annual_revenue'],2)."</p></div>";
        // show company funding requests
        $stmt = $pdo->prepare("SELECT * FROM funding_requests WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$c['id']]); $frs = $stmt->fetchAll();
        if ($frs) {
          echo "<h3>Your Funding Requests</h3><table class='table'><tr><th>Title</th><th>Amount</th><th>Type</th><th>Status</th></tr>";
          foreach($frs as $fr) {
            echo "<tr><td>".esc($fr['title'])."</td><td>".number_format($fr['amount_requested'],2)."</td><td>".$fr['funding_type']."</td><td>".$fr['status']."</td></tr>";
          }
          echo "</table>";
        } else { echo "<p>No funding requests yet. <a href='funding_create.php' class='btn'>Post Funding</a></p>"; }
      }
    ?>
  <?php else: // investor dashboard ?>
    <?php
      // show investor recent investments
      $stmt = $pdo->prepare("SELECT i.*, fr.title, c.company_name FROM investments i JOIN funding_requests fr ON i.funding_request_id=fr.id JOIN companies c ON i.company_id=c.id WHERE i.investor_id = ? ORDER BY i.created_at DESC LIMIT 10");
      $stmt->execute([$uid]); $inv = $stmt->fetchAll();
      echo "<h3>My Offers</h3>";
      if ($inv) {
        echo "<table class='table'><tr><th>Company</th><th>Funding</th><th>Amount</th><th>Status</th></tr>";
        foreach($inv as $r) {
          echo "<tr><td>".esc($r['company_name'])."</td><td>".esc($r['title'])."</td><td>".number_format($r['amount'],2)."</td><td>".esc($r['status'])."</td></tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No offers yet. Browse funding requests: <a href='fundings.php' class='btn'>Find Companies</a></p>";
      }
    ?>
  <?php endif; ?>
</div>
</body></html>
