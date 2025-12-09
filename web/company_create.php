<?php
require 'helpers.php';
require 'db.php';
if (!is_logged_in()) { header('Location: login.php'); exit; }
session_start();
if ($_SESSION['user_role'] !== 'company') { die('Access denied'); }
$uid = $_SESSION['user_id'];
$config = require 'config.php';
$upload_dir = $config['upload_dir'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $industry = $_POST['industry'] ?? '';
    $location = $_POST['location'] ?? '';
    $annual_revenue = floatval($_POST['annual_revenue'] ?? 0);
    $net_profit = floatval($_POST['net_profit'] ?? 0);
    $revenue_growth_yoy = floatval($_POST['revenue_growth_yoy'] ?? 0);
    $profit_margin = floatval($_POST['profit_margin'] ?? 0);
    $pdf_path = null;
    if (!empty($_FILES['company_pdf']['name'])) {
        if (!is_dir($upload_dir)) mkdir($upload_dir,0755,true);
        $fn = basename($_FILES['company_pdf']['name']);
        $target = $upload_dir . '/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/','_',$fn);
        if (move_uploaded_file($_FILES['company_pdf']['tmp_name'], $target)) {
            $pdf_path = str_replace(__DIR__ . '/', '', $target);
        }
    }
    // check if company exists
    $stmt = $pdo->prepare("SELECT id FROM companies WHERE user_id = ?");
    $stmt->execute([$uid]); $c = $stmt->fetch();
    if ($c) {
        $stmt = $pdo->prepare("UPDATE companies SET company_name=?, description=?, industry=?, location=?, annual_revenue=?, net_profit=?, revenue_growth_yoy=?, profit_margin=?, documents_count = GREATEST(documents_count, ?), document_pdf = COALESCE(?, document_pdf) WHERE user_id = ?");
        $stmt->execute([$company_name,$description,$industry,$location,$annual_revenue,$net_profit,$revenue_growth_yoy,$profit_margin, ($pdf_path?1:0), $pdf_path, $uid]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO companies (user_id,company_name,description,industry,location,annual_revenue,net_profit,revenue_growth_yoy,profit_margin,document_pdf,documents_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$uid,$company_name,$description,$industry,$location,$annual_revenue,$net_profit,$revenue_growth_yoy,$profit_margin,$pdf_path,($pdf_path?1:0)]);
    }
    header('Location: dashboard.php'); exit;
}
// load existing
$stmt = $pdo->prepare("SELECT * FROM companies WHERE user_id = ? LIMIT 1"); $stmt->execute([$uid]); $company = $stmt->fetch();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>My Company</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>My Company</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="form-row"><label>Company name</label><input name="company_name" value="<?=esc($company['company_name'] ?? '')?>"></div>
    <div class="form-row"><label>Description</label><textarea name="description"><?=esc($company['description'] ?? '')?></textarea></div>
    <div class="form-row"><label>Industry</label><input name="industry" value="<?=esc($company['industry'] ?? '')?>"></div>
    <div class="form-row"><label>Location</label><input name="location" value="<?=esc($company['location'] ?? '')?>"></div>
    <div class="form-row"><label>Annual revenue</label><input name="annual_revenue" value="<?=esc($company['annual_revenue'] ?? '')?>"></div>
    <div class="form-row"><label>Net profit</label><input name="net_profit" value="<?=esc($company['net_profit'] ?? '')?>"></div>
    <div class="form-row"><label>Revenue growth YoY</label><input name="revenue_growth_yoy" value="<?=esc($company['revenue_growth_yoy'] ?? '')?>"></div>
    <div class="form-row"><label>Profit margin</label><input name="profit_margin" value="<?=esc($company['profit_margin'] ?? '')?>"></div>
    <div class="form-row"><label>Upload PDF (financials)</label><input type="file" name="company_pdf" accept="application/pdf"></div>
    <?php if(!empty($company['document_pdf'])): ?><div class="form-row"><a href="<?=esc($company['document_pdf'])?>" target="_blank">View uploaded PDF</a></div><?php endif;?>
    <button class="btn" type="submit">Save</button>
  </form>
</div>
</body></html>
