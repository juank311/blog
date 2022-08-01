<?php
session_start();
session_destroy();
header('Location:acceder.php');
?>