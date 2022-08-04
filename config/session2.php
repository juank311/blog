<?php 
if (!isset($_SESSION)) {
    session_start();
    
}

if (!isset($_SESSION['activo']) ||  $_SESSION['data_employee']->rol_id == 1) {
    header('Location: ../acceder.php');
}
?>