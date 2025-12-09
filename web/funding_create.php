<?php
require 'helpers.php';
require 'db.php';
$config = require 'config.php';
if (!is_logged_in() || current_user_role() !== 'company') { header('Location: login.php'); exit; }
session_start();
$uid = current_user_id();

// find company id
$stmt = $pdo->prepare("SELECT id FROM companies WHERE user_id = ? LIMIT 1"); $stmt->execute([$uid]); $c = $stmt->fetch();
if (!$c) { die('Create a company profile first'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $amount = floatval($_POST['amount_requested'] ?? 0);
    $type = $_POST['funding_type'] ?? 'equity';
    $equity = floatval($_POST['equity_offer_percent'] ?? 0);
    $term = intval($_POST['loan_term_months'] ?? 0);
    $interest = floatval($_POST['loan_interest_rate'] ?? 0);
    $stmt = $pdo->prepare("INSERT INTO funding_requests (company_id,title,amount_requested,funding_type,equity_offer_percent,loan_term_months,loan_interest_rate) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$c['id'],$title,$amount,$type,$equity,$term,$interest]);
    $funding_id = $pdo->lastInsertId();

    // optional: call ML to precompute risk for investors (asynchronous in real app; here we call a sync PHP helper)
    header("Location: company_view.php?id=".$c['id']); exit;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Post Funding</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>Post Funding Request</h2>
  <form method="post">
    <div class="form-row"><label>Title</label><input name="title" required></div>
    <div class="form-row"><label>Amount Requested</label><input name="amount_requested" required></div>
    <div class="form-row"><label>Funding Type</label><select name="funding_type"><option value="equity">Equity</option><option value="loan">Loan</option></select></div>
    <div class="form-row"><label>Equity Offer %</label><input name="equity_offer_percent"></div>
    <div class="form-row"><label>Loan Term (months)</label><input name="loan_term_months"></div>
    <div class="form-row"><label>Loan Interest Rate %</label><input name="loan_interest_rate"></div>
    <button class="btn" type="submit">Post</button>
  </form>
</div>
</body></html>
