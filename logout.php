<?php
// Session hardening
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

session_start();

// Hapus semua session data
$_SESSION = array();

// Hapus session cookie jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>