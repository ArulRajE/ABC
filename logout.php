<?php
session_start();
include('include/db_conn.php');
$admin_name = $_SESSION['login_email'];
$query = "DELETE FROM user_sessions WHERE admin_name = '$admin_name'";
$result = pg_query($db, $query);
session_destroy();
echo "<script language='javascript'>location.href='login';</script>";
?>