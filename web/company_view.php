<?php
require 'db.php';
require 'helpers.php';
$id = intval($_GET['id'] ?? 0);
if (!$id) die('Missing id');
$stmt = $pdo->prepare("SELECT c.*, u.name AS owner FROM companies c JOIN users u ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$id]); $company = $stmt->fetch();
if (!$company) die('Not found');

// call ml_call to get risk. We can call local php file that returns JSON
$ml_json = @file_get_contents("ml_call.php?company_id=" . urlencode($id));
$ml_data = $ml_json ? json_decode($ml_json, true) : null;
$risk_pct = $ml_data['probability_default'] ?? null;
?>
<!doctype html>
<html><head><meta charset="utf-8"><title><?=esc($company['company_name'])?></title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2><?=esc($company['company_name'])?></h2>
  <p><strong>Owner:</strong> <?=esc($company['owner'])?> | <strong>Industry:</strong> <?=esc($company['industry'])?></p>
  <p><?=nl2br(esc($company['description']))?></p>

  <h3>Financial snapshot</h3>
  <table class="table">
    <tr><th>Annual revenue</th><td><?=number_format($company['annual_revenue'],2)?></td></tr>
    <tr><th>Net profit</th><td><?=number_format($company['net_profit'],2)?></td></tr>
    <tr><th>Revenue growth YoY</th><td><?=esc($company['revenue_growth_yoy'])?></td></tr>
    <tr><th>Profit margin</th><td><?=esc($company['profit_margin'])?></td></tr>
  </table>

  <h3>Risk analysis</h3>
  <?php if ($risk_pct !== null): ?>
    <div class="card"><strong>Estimated probability of default:</strong> <?=round($risk_pct*100,2)?>%</div>
  <?php else: ?>
    <div class="alert">Risk score not available currently.</div>
  <?php endif; ?>

  <?php if (!empty($company['document_pdf'])): ?>
    <h3>Documents</h3>
    <p><a href="<?=esc($company['document_pdf'])?>" target="_blank">View uploaded PDF</a></p>
  <?php endif; ?>

  <p><a href="fundings.php">Back</a></p>
</div>
</body></html>
