<?php
setcookie('user', '', time() - 3600, '/');
// Redirect 
header("Location: login.php");
exit();
?>
