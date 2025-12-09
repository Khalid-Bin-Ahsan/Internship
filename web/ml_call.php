<?php
// ml_call.php
require 'db.php';
$config = require 'config.php';
$ml_url = $config['ml_service_url'];

$company_id = intval($_GET['company_id'] ?? 0);
if (!$company_id) {
    header('Content-Type: application/json'); echo json_encode(['error'=>'no company_id']); exit;
}
$stmt = $pdo->prepare("SELECT * FROM companies WHERE id = ? LIMIT 1");
$stmt->execute([$company_id]); $c = $stmt->fetch();
if (!$c) { header('Content-Type: application/json'); echo json_encode(['error'=>'not found']); exit; }

// Build payload matching the features used by the pure-Python model
$payload = [
  "annual_revenue" => floatval($c['annual_revenue']),
  "revenue_growth_yoy" => floatval($c['revenue_growth_yoy']),
  "net_profit" => floatval($c['net_profit']),
  "profit_margin" => floatval($c['profit_margin']),
  "current_ratio" => floatval($c['current_ratio'] ?? 0),
  "debt_equity_ratio" => floatval($c['debt_equity_ratio'] ?? 0),
  "cash_balance" => floatval($c['cash_balance'] ?? 0),
  "burn_rate_monthly" => floatval($c['burn_rate_monthly'] ?? 0),
  "runway_months" => floatval($c['runway_months'] ?? 0),
  "previous_rounds" => intval($c['previous_rounds'] ?? 0),
  "total_raised" => floatval($c['total_raised'] ?? 0),
  "founder_experience_years" => floatval($c['founder_experience_years'] ?? 5),
  "num_founders" => intval($c['num_founders'] ?? 1),
  "has_audited_financials" => intval($c['has_audited_financials'] ?? 0),
  "monthly_active_users" => intval($c['monthly_active_users'] ?? 0),
  "customer_count" => intval($c['customer_count'] ?? 0),
  "churn_rate" => floatval($c['churn_rate'] ?? 0),
  "market_growth_pct" => floatval($c['market_growth_pct'] ?? 0),
  "competition_index" => floatval($c['competition_index'] ?? 0),
  "country_risk_score" => floatval($c['country_risk_score'] ?? 0),
  "onchain_event_count" => intval($c['onchain_event_count'] ?? 0),
  "documents_uploaded_count" => intval($c['documents_count'] ?? 0),
  "kyc_verified" => intval($c['kyc_verified'] ?? 0),
  "investor_interest_score" => floatval($c['investor_interest_score'] ?? 0)
];

$options = [
  'http' => [
    'header'  => "Content-Type: application/json\r\n",
    'method'  => 'POST',
    'content' => json_encode($payload),
    'timeout' => 3
  ]
];
$context  = stream_context_create($options);
$result = @file_get_contents($ml_url, false, $context);
if ($result === FALSE) {
  header('Content-Type: application/json');
  echo json_encode(['error'=>'ml_service_unreachable']);
} else {
  header('Content-Type: application/json');
  echo $result;
}
