<?php
// login.php
session_start();
header('Content-Type: application/json');

$username = trim($_POST['username'] ?? '');
if ($username === '') {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Username required']);
  exit;
}

// (optional but good practice) prevent session fixation by regenerating the ID on login
session_regenerate_id(true);

// Create server-side session state
$_SESSION['username'] = $username;

// Optional helper cookie to "remember" the name for 7 days (NOT needed for session)
$remember = isset($_POST['remember']) && $_POST['remember'] === '1';
if ($remember) {
  // secure=false for local dev; set to true when using HTTPS in production
  setcookie('remember_name', $username, [
    'expires'  => time() + 7*24*60*60,
    'path'     => '/',
    'secure'   => false,
    'httponly' => true,
    'samesite' => 'Lax',
  ]);
}

echo json_encode(['ok' => true, 'username' => $username]);
