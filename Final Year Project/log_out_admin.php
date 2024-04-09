<?php
session_start();
unset($_SESSION['id_Admin']);
session_destroy();
header("Location: sign_in__Admin.php");
exit;
?>