<?php
include('include/db_conn.php');
session_unset();
session_destroy();
session_start();
// Set the session timeout to 30 minutes (1800 seconds)
ini_set('session.gc_maxlifetime', 1800);
// Get the session expiration time
$sessionExpiration = ini_get('session.gc_maxlifetime');

echo "Session will expire in $sessionExpiration seconds.";
?>