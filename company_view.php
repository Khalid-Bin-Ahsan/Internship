<?php
require_once 'db.php';
require_once 'ml_call.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT c.*, u.name as founder FROM companies c JOIN users u ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$id]);
$company = $stmt->fetch();
if(!$company) die("Not found");
$risk = calculate_risk_score($company);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$company['company_name']?> • BlockSight</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <div class="card" style="text-align:center;">
                <h1><?=$company['company_name']?></h1>
                <p>Founded by <?=$company['founder']?></p>
                <div style="font-size:4rem;color:<?=$risk['color']?>;margin:2rem 0;">
                    <?=$risk['score']?> <small style="font-size:1rem;">/ 100</small>
                </div>
                <h2 style="color:<?=$risk['color']?>"><?=$risk['level']?></h2>
                <p><strong>Blockchain Verified • Immutable Audit Trail</strong></p>
                <p><?=esc($company['description'] ?: 'Innovative startup from Bangladesh')?></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>