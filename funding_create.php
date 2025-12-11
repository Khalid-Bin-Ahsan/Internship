<?php
require_once 'db.php';
require_once 'helpers.php';
require_once 'ml_call.php';
session_start();
require_login();
if(!is_company()) redirect('dashboard.php');

$error = $success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $amount = floatval($_POST['amount_requested']);
    $type = $_POST['funding_type'];
    $equity = $type === 'equity' ? floatval($_POST['equity_offer_percent']) : 0;

    if(!$title || $amount <= 0) {
        $error = "Valid title and amount required.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM companies WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $company = $stmt->fetch();

        $stmt = $pdo->prepare("INSERT INTO funding_requests (company_id, title, amount_requested, funding_type, equity_offer_percent, status) VALUES (?, ?, ?, ?, ?, 'open')");
        $stmt->execute([$company['id'], $title, $amount, $type, $equity]);

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Raise Capital • BlockSight</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="container">
            <div class="card">
                <h1 style="font-size:2.8rem;text-align:center;">Raise Capital</h1>
                <p style="text-align:center;opacity:0.8;">Your ML Risk Score will be shown to investors</p>

                <?php if($error): ?>
                    <div style="background:#fee;color:#991b1b;padding:1rem;border-radius:12px;margin:1rem 0;"><?=$error?></div>
                <?php endif; ?>

                <?php if($success): ?>
                    <div style="background:#dcfce7;color:#166534;padding:2rem;border-radius:20px;text-align:center;">
                        Funding request created! <a href="fundings.php">View All</a>
                    </div>
                <?php else: ?>
                <form method="post">
                    <input type="text" name="title" placeholder="Funding Round Title (e.g. Seed Round)" required style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;border:1px solid #ccc;"><br>
                    <input type="number" name="amount_requested" placeholder="Amount in USD" required step="0.01" style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;border:1px solid #ccc;"><br>

                    <select name="funding_type" onchange="toggleEquity(this.value)" style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;">
                        <option value="equity">Equity</option>
                        <option value="loan">Loan</option>
                        <option value="either">Either</option>
                    </select>

                    <div id="equity_field" style="display:block;">
                        <input type="number" name="equity_offer_percent" placeholder="Equity Offered (%)" step="0.01" style="width:100%;padding:1rem;margin:1rem 0;border-radius:12px;">
                    </div>

                    <button type="submit" class="btn" style="width:100%;margin-top:1rem;">Create Funding Request</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        function toggleEquity(val) {
            document.getElementById('equity_field').style.display = (val === 'equity') ? 'block' : 'none';
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>