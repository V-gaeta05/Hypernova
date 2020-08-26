<?php
    if (isset($_COOKIE['LOGIN'])) {
        session_start();
        $_SESSION['USER_ID'] = $_COOKIE['LOGIN'];
        $_SESSION['USER_RANK'] = $_COOKIE['RANK'];
        if (time() - $_COOKIE['TIME'] > 7200) {
            setcookie('LOGIN', '', time()-3600);
            setcookie('RANK', '', time()-3600);
            setcookie('TIME','', time()-3600);
            session_destroy();
        } else {
            setcookie('TIME', time());
        }
        
    
    } else {
        session_destroy();
    }

    if (isset($_GET['logout'])) {
        setcookie('LOGIN', '', time()-3600);
        setcookie('RANK', '', time()-3600);
        setcookie('TIME','', time()-3600);
        session_destroy();
        
    }
    
    if(session_status() == PHP_SESSION_NONE) {
        header("location: login.php");
    }
    


?>