<?php
require 'helpers.php';
require 'db.php';
require 'config.php';
if (!is_logged_in() || current_user_role() !== 'investor') { header('Location: login.php'); exit; }
session_start();
$uid = current_user_id();

$funding_request_id = intval($_POST['funding_request_id'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$type = $_POST['type'] ?? 'equity';
if (!$funding_request_id || $amount <= 0) { die('Invalid input'); }

$stmt = $pdo->prepare("SELECT * FROM funding_requests WHERE id = ?");
$stmt->execute([$funding_request_id]);
$fr = $stmt->fetch();
if (!$fr) die('Funding not found');

$company_id = $fr['company_id'];
$stmt = $pdo->prepare("INSERT INTO investments (funding_request_id, investor_id, company_id, amount, type, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->execute([$funding_request_id, $uid, $company_id, $amount, $type]);
$investment_id = $pdo->lastInsertId();

// call ML: get risk percentage for this company (ml_call.php wraps the Flask endpoint)
$ml_result = null;
try {
    // ml_call.php expects company_id as param; it will fetch company features and call the ML service
    $url = "ml_call.php?company_id=" . urlencode($company_id);
    $ml_result = @file_get_contents($url);
} catch(Exception $e) {
    // ignore
}

header('Location: dashboard.php');
exit;
