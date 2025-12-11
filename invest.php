<?php
require_once 'db.php';
require_once 'helpers.php';
require_once 'ml_call.php';
session_start();
require_login();
if(!is_investor()) redirect('dashboard.php');

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT fr.*, c.company_name FROM funding_requests fr JOIN companies c ON fr.company_id = c.id WHERE fr.id = ? AND fr.status = 'open'");
$stmt->execute([$id]);
$request = $stmt->fetch();

if(!$request) redirect('fundings.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    $type = $_POST['type'];
    $terms = trim($_POST['terms']);

    $tx_hash = generate_blockchain_hash();

    $stmt = $pdo->prepare("INSERT INTO investments (funding_request_id, investor_id, company_id, amount, type, terms, blockchain_tx_hash, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$request['id'], $_SESSION['user_id'], $request['company_id'], $amount, $type, $terms, $tx_hash]);

    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html>
<head><title>Invest • BlockSight</title><link rel="stylesheet" href="style.css"></head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <div class="card">
                <h1>Invest in <?=$request['company_name']?></h1>
                <p>Request: <?=$request['title']?> • Seeking $<?=number_format($request['amount_requested'])?></p>

                <form method="post">
                    <input type="number" name="amount" placeholder="Your Offer Amount (USD)" required step="0.01"><br><br>
                    <select name="type">
                        <option value="equity">Equity</option>
                        <option value="loan">Loan</option>
                    </select><br><br>
                    <textarea name="terms" placeholder="Terms & Conditions (optional)" style="width:100%;height:100px;"></textarea><br><br>
                    <button type="submit" class="btn">Submit Investment Offer</button>
                </form>
                <p style="margin-top:1rem;font-size:0.9rem;color:#666;">
                    Your offer will be recorded on blockchain: <strong><?=generate_blockchain_hash()?></strong>
                </p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>