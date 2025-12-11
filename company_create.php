<?php require_once 'db.php'; require_once 'helpers.php'; session_start(); require_login(); if(!is_company()) redirect('dashboard.php'); ?>
<?php
$config = require 'config.php';
$upload_dir = $config['upload_dir'];
$error = $success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'company_name' => trim($_POST['company_name']),
        'registration_number' => trim($_POST['registration_number']),
        'industry' => trim($_POST['industry']),
        'location' => trim($_POST['location']),
        'annual_revenue' => floatval($_POST['annual_revenue']),
        'net_profit' => floatval($_POST['net_profit']),
        'revenue_growth_yoy' => floatval($_POST['revenue_growth_yoy']),
        'profit_margin' => floatval($_POST['profit_margin']),
        'description' => trim($_POST['description']),
    ];

    if(!$data['company_name']) {
        $error = "Company name required.";
    } else {
        $pdf = null;
        if(!empty($_FILES['document_pdf']['name'])) {
            $target = $upload_dir . '/' . time() . '_doc.pdf';
            move_uploaded_file($_FILES['document_pdf']['tmp_name'], $target);
            $pdf = 'uploads/' . basename($target);
        }

        $stmt = $pdo->prepare("INSERT INTO companies (user_id, company_name, registration_number, industry, location, annual_revenue, net_profit, revenue_growth_yoy, profit_margin, description, document_pdf, documents_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], ...array_values($data), $pdf, $pdf ? 1 : 0]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Company • BlockSight</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <div class="card">
                <h1>Create Company Profile</h1>
                <?php if($error): ?><div style="background:#fee;color:#991b1b;padding:1rem;border-radius:12px;"><?=$error?></div><?php endif; ?>
                <?php if($success): ?>
                    <div style="background:#dcfce7;color:#166534;padding:2rem;border-radius:20px;text-align:center;">
                        Success! <a href="dashboard.php">Go to Dashboard</a>
                    </div>
                <?php else: ?>
                <form method="post" enctype="multipart/form-data">
                    <!-- All fields from your SQL -->
                    <input type="text" name="company_name" placeholder="Company Name *" required><br><br>
                    <input type="text" name="registration_number" placeholder="Registration Number"><br><br>
                    <input type="text" name="industry" placeholder="Industry"><br><br>
                    <input type="text" name="location" placeholder="Location"><br><br>
                    <input type="number" name="annual_revenue" step="0.01" placeholder="Annual Revenue (USD)"><br><br>
                    <input type="number" name="net_profit" step="0.01" placeholder="Net Profit"><br><br>
                    <input type="number" name="revenue_growth_yoy" step="0.01" placeholder="Revenue Growth YoY (e.g. 0.45)"><br><br>
                    <input type="number" name="profit_margin" step="0.01" placeholder="Profit Margin (e.g. 0.18)"><br><br>
                    <textarea name="description" placeholder="Company Description"></textarea><br><br>
                    <input type="file" name="document_pdf" accept=".pdf"><br><br>
                    <button type="submit" class="btn">Create Company</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>