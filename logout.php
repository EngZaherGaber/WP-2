<?php
// Unset the user cookie by setting its expiration date to a past date
setcookie('user', '', time() - 3600, '/');

// Redirect to the login page or home page
header("Location: login.php");
exit();
?>
