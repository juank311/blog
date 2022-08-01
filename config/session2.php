<?php 
if (!isset($_SESSION)) {
    session_start();
    
}

if (!isset($_SESSION['activo'])) {
    header('Location: ../acceder.php');
}
?>