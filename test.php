<?php
die(phpinfo());
include('include/db_conn.php');
include('include/function.php');
// Database dbection

// Start the session
session_start();

// User login logic
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform authentication and retrieve user ID
    $_SESSION['user_id'] = authenticate($db, $username, $password);
    $user_id = $_SESSION['user_id'];
    if ($user_id) {
        // Check if the user is already logged in
        isUserLoggedIn($db, $user_id);
    } else {
        echo "Invalid credentials!";
    }
}

if (isset($_POST['logout'])) {
    $sessionId = session_id();
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM user_sessions WHERE session_id = '$sessionId' AND user_id = '$user_id'";
    $result = pg_query($db, $query);
    session_destroy();
}

// Function to check if a user is already logged in
function isUserLoggedIn($db, $user_id)
{
    $sessionId = session_id();
    // Check for an existing session for the user
    $query = "SELECT session_id FROM user_sessions WHERE user_id = '$user_id' AND last_activity >= NOW() - INTERVAL '30 minutes'";
    $result = pg_query($db, $query);
    $existingSession = pg_fetch_assoc($result);

    if (!empty($existingSession)) {
        // A session already exists for this user
        // You can handle this situation by denying the new login attempt
        die("You are already logged in from another device.");
    } else {
        // Proceed with the login
        // Insert a new session record for the user
        $query = "INSERT INTO user_sessions (session_id, user_id, last_activity) VALUES ('$sessionId', $user_id, NOW())";
        $result = pg_query($db, $query);
        echo "Login success";
        // Continue with the login process
    }

}


// Function to authenticate users (replace with your authentication logic)
function authenticate($db, $username, $password)
{
    // Replace this with your user authentication logic
    // Return the user's ID if authentication is successful, or false otherwise
    // Example:

    $checkval = array($_POST['username'], md5($_POST['password']));
    $result = pg_query_params($db, "SELECT * FROM admin_login WHERE admin_name = $1 AND admin_password=$2", $checkval);
    $row = pg_fetch_row($result);

    if ($row[0] != null) {
        return $row[0]; // User ID
    } else {
        return false;
    }
    return false; // Replace with your authentication logic
}
?>