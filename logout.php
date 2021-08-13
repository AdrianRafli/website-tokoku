<?php
session_start();
session_unset();
session_destroy();

setcookie('aidi', '', time() - 3600);
setcookie('yusername', '', time() - 3600);


header("location:login.php");
exit;
?>