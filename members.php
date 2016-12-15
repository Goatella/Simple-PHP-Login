<?php
// Connects to your Database
require_once 'route.php';

// if not logged redirect to the sign in page
if(FALSE === array_key_exists('is_logged', $_SESSION))
{
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Area</title>
</head>
<body>

    <h1>Admin Area</h1>
    <p>Hello <strong><?php echo $username; ?></strong> | <a href="logout.php">log out</a></p>

</body>
</html>