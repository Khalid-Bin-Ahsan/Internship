<?php
require 'db.php';
require 'helpers.php';
$id = intval($_GET['id'] ?? 0);
if ($id) {
  $stmt = $pdo->prepare("SELECT fr.*, c.company_name, c.id AS company_id FROM funding_requests fr JOIN companies c ON fr.company_id=c.id WHERE fr.id = ?");
  $stmt->execute([$id]); $f = $stmt->fetch();
  if (!$f) die('Not found');
  session_start(); $is_investor = isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'investor';
  ?>
  <!doctype html>
  <html><head><meta charset="utf-8"><title>Funding Detail</title><link rel="stylesheet" href="css/style.css"></head>
  <body><div class="container">
    <h2><?=esc($f['title'])?></h2>
    <p><strong>Company:</strong> <?=esc($f['company_name'])?></p>
    <p><strong>Amount:</strong> <?=number_format($f['amount_requested'],2)?></p>
    <p><strong>Type:</strong> <?=esc($f['funding_type'])?></p>
    <?php if ($is_investor): ?>
      <form method="post" action="invest.php">
        <input type="hidden" name="funding_request_id" value="<?=$f['id']?>">
        <div class="form-row"><label>Amount to invest</label><input name="amount" required></div>
        <div class="form-row"><label>Type</label><select name="type"><option value="equity">Equity</option><option value="loan">Loan</option></select></div>
        <button class="btn" type="submit">Make Offer</button>
      </form>
    <?php else: ?>
      <p><a href="login.php">Login as investor to make an offer</a></p>
    <?php endif; ?>
    <p><a href="fundings.php">Back</a></p>
  </div></body></html>
  <?php exit;
}
// list
$stmt = $pdo->query("SELECT fr.*, c.company_name FROM funding_requests fr JOIN companies c ON fr.company_id=c.id WHERE fr.status='open' ORDER BY fr.id DESC LIMIT 200");
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Open Fundings</title><link rel="stylesheet" href="css/style.css"></head>
<body><div class="container">
  <h2>Open Funding Requests</h2>
  <?php if (!$rows) echo "<p>No open requests.</p>"; else { echo "<table class='table'><tr><th>Title</th><th>Company</th><th>Amount</th><th></th></tr>"; foreach($rows as $r) { echo "<tr><td>".esc($r['title'])."</td><td>".esc($r['company_name'])."</td><td>".number_format($r['amount_requested'],2)."</td><td><a href='fundings.php?id=".$r['id']."'>View</a></td></tr>"; } echo "</table>"; } ?>
</div></body></html>
