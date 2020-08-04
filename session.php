<?php
    session_start();
    
    $_SESSION['id']=$_GET['id'];
    if(session_status() == PHP_SESSION_NONE) {
        header("location: login.php");
    }


?>