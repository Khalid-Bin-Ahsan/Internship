<?php
// helpers.php
function esc($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function is_logged_in() {
  session_start();
  return isset($_SESSION['user_id']);
}

function current_user_id() {
  return $_SESSION['user_id'] ?? null;
}

function current_user_role() {
  return $_SESSION['user_role'] ?? null;
}
