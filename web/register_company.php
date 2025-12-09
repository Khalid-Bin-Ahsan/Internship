<?php
// register_company.php
require 'db.php';
$config = require 'config.php';
$upload_dir = $config['upload_dir'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';
    $company_name = trim($_POST['company_name']);
    // other company fields
    $regno = $_POST['registration_number'] ?? '';
    $industry = $_POST['industry'] ?? '';
    $location = $_POST['location'] ?? '';
    $annual_revenue = floatval($_POST['annual_revenue'] ?? 0);
    $net_profit = floatval($_POST['net_profit'] ?? 0);
    $revenue_growth_yoy = floatval($_POST['revenue_growth_yoy'] ?? 0);
    $profit_margin = floatval($_POST['profit_margin'] ?? 0);
    // file upload: company PDF
    $pdf_path = null;
    if (!empty($_FILES['company_pdf']['name'])) {
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        $fn = basename($_FILES['company_pdf']['name']);
        $target = $upload_dir . '/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/','_', $fn);
        if (move_uploaded_file($_FILES['company_pdf']['tmp_name'], $target)) {
            $pdf_path = str_replace(__DIR__ . '/', '', $target); // store relative
        }
    }
    // simple checks
    if (!$name || !$email || !$password) { $error = "Missing required fields"; }
    else {
        // create user
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash,role) VALUES (?, ?, ?, 'company')");
        $stmt->execute([$name,$email,$hash]);
        $uid = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO companies (user_id,company_name,registration_number,industry,location,annual_revenue,net_profit,revenue_growth_yoy,profit_margin,document_pdf,documents_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$uid,$company_name,$regno,$industry,$location,$annual_revenue,$net_profit,$revenue_growth_yoy,$profit_margin,$pdf_path, ($pdf_path?1:0)]);
        session_start();
        $_SESSION['user_id']=$uid; $_SESSION['user_name']=$name; $_SESSION['user_role']='company';
        header('Location: dashboard.php'); exit;
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register Company</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>Company Registration</h2>
  <?php if(!empty($error)) echo "<div class='alert'>".esc($error)."</div>"; ?>
  <form method="post" enctype="multipart/form-data">
    <h3>Account</h3>
    <div class="form-row"><label>Name</label><input name="name" required></div>
    <div class="form-row"><label>Email</label><input name="email" type="email" required></div>
    <div class="form-row"><label>Password</label><input name="password" type="password" required></div>

    <h3>Company Details</h3>
    <div class="form-row"><label>Company name</label><input name="company_name" required></div>
    <div class="form-row"><label>Registration Number</label><input name="registration_number"></div>
    <div class="form-row"><label>Industry</label><input name="industry"></div>
    <div class="form-row"><label>Location</label><input name="location"></div>
    <div class="form-row"><label>Annual Revenue</label><input name="annual_revenue" type="text"></div>
    <div class="form-row"><label>Net Profit</label><input name="net_profit" type="text"></div>
    <div class="form-row"><label>Revenue growth YoY (0.12 for 12%)</label><input name="revenue_growth_yoy" type="text"></div>
    <div class="form-row"><label>Profit margin (0.05)</label><input name="profit_margin" type="text"></div>

    <div class="form-row"><label>Upload company PDF (financials)</label><input type="file" name="company_pdf" accept="application/pdf"></div>

    <button class="btn" type="submit">Register & Create Company</button>
  </form>
  <p><a href="register.php">Back</a></p>
</div>
</body></html>
