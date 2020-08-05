<?php
    if (isset($_COOKIE['LOGIN'])) {
        session_start();
        $_SESSION['USER_ID'] = $_COOKIE['LOGIN'];
        $_SESSION['USER_RANK'] = $rank;
    
    } else {
        session_destroy();
    }

    if (isset($_GET['logout'])) {
        setcookie('LOGIN', '', time()-3600);
        session_destroy();
        
    }
    
    if(session_status() == PHP_SESSION_NONE) {
        header("location: login.php");
    }
    


?>