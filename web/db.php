<?php
// db.php
$config = require __DIR__ . '/config.php';
$dbcfg = $config['db'];
$dsn = "mysql:host={$dbcfg['host']};dbname={$dbcfg['dbname']};charset=utf8mb4";
try {
  $pdo = new PDO($dsn, $dbcfg['user'], $dbcfg['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
} catch (Exception $e) {
  die('DB connection error: ' . $e->getMessage());
}
