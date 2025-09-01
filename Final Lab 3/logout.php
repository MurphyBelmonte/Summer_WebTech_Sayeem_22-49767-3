<?php
// logout.php
session_start();

// Clear all session variables
$_SESSION = [];

// If session uses cookies, clear the session cookie on the client
if (ini_get('session.use_cookies')) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

// Destroy session data on the server
session_destroy();

// Also clear the optional helper cookie, if any
setcookie('remember_name', '', time() - 3600, '/');

header('Content-Type: application/json');
echo json_encode(['ok' => true]);
