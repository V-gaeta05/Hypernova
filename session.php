<?php
    if(isset($_GET['id'])){
        session_start();
        
        $_SESSION['id']=$_GET['id'];
    }
    if(isset($_GET['logout'])){
        session_destroy();
    }
    if(session_status() == PHP_SESSION_NONE) {
        header("location: login.php");
    }
    


?>