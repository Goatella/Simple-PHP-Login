<?php
// Connects to your Database and start a session
require_once 'route.php';

// if logged go away from this page
if(array_key_exists('is_logged', $_SESSION))
{
    header('Location: members.php');
    exit;
}

// This code runs if the form has been submitted
if($_POST && isset($_POST['submit']))
{
    /**
     * Sanitize the input
     */
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
    $passconf = trim(filter_input(INPUT_POST, 'passconf', FILTER_SANITIZE_STRING));

    /**
     * Bitwise operators are not meant to evaluate if an array key is set
     * user logical operators instead.
     *
     * @see http://php.net/manual/en/language.operators.bitwise.php
     * @see http://php.net/manual/en/language.operators.logical.php
     */
    if(FALSE === _is_valid($username) || FALSE === _is_valid($password) || FALSE === _is_valid($passconf))
        _log_die('You did not complete all of the required fields');

    // this makes sure both passwords entered match
    if($password != $passconf)
        _log_die('Your passwords did not match.');

    // checks if the username is in use
    $stmt = $db->prepare('SELECT `username` FROM `users` WHERE `username` = :username LIMIT 1');
    $stmt->execute(array(':username' => $username));
    $stmt->closeCursor();

    /**
     * MySQL only
     */
    $num = $db->query('SELECT FOUND_ROWS()')->fetchColumn();

    if($num > 0)
        _log_die("Sorry, the username {$username} is already in use.");

    try {
        /**
         * Instead of MD5 or SHA-1, which are unsafe, use
         * password_hash()
         *
         * @see  http://php.net/manual/en/function.password-hash.php
         * @see  https://www.owasp.org/index.php/Guide_to_Cryptography#How_to_determine_if_you_are_vulnerable
         */
        $stmt = $db->prepare('INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)');
        $stmt->execute(array(':username' => $username
                           , ':password' => password_hash($password, PASSWORD_DEFAULT)));
        $stmt->closeCursor();

    } catch (PDOException $e) {
        $stmt->closeCursor();
        error_log('Database insert query failed: ' . $e->getMessage());
    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
    }
?>

    <h1>Registered</h1>
    <p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>

<?php
}

else
{
   ?>

   <form method="post">

        <table border="0">

            <tr><td>Username:</td><td>
                <input type="text" name="username" maxlength="60">
            </td></tr>

            <tr><td>Password:</td><td>
                <input type="password" name="password" maxlength="20">
            </td></tr>

            <tr><td>Confirm Password:</td><td>
                <input type="password" name="passconf" maxlength="20">
            </td></tr>

            <tr><th colspan=2>
                <input type="submit" name="submit" value="Register">
            </th></tr>

        </table>

    </form>
<?php
}
?>
