<?php
    require('class.php');
    require('db.php');
    $login=new Login($conn);
    if(isset($_POST['check_log'])){
        $id=$login->logUtente();
        setcookie('LOGIN', $id, time()+7200);
        header('location:index.php');
    }
    if(isset($_POST['check_reg'])){
        $registra= new Registrazione();
        $registra-> RegistrazioneUtente();
    }