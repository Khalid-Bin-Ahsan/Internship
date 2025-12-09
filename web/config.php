<?php
// config.php
return [
  'db' => [
    'host' => '127.0.0.1',
    'dbname' => 'blocksight',
    'user' => 'root',
    'pass' => ''   // change if you use a password
  ],
  // ML service URL (pure-Python Flask server)
  'ml_service_url' => 'http://127.0.0.1:5001/predict',
  // Upload directory relative to this folder
  'upload_dir' => __DIR__ . '/uploads'
];
