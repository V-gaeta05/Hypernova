<?php
    require('class.php');
    require('db.php');
    include('session.php');
    $login=new Login($conn);
    if(isset($_POST['check_log'])){
        $id=$login->logUtente();
        $rank = $login->getRank();
        setcookie('LOGIN', $id, time()+7200);
        setcookie('RANK', $rank, time()+7200);
        header('location:index.php');
    }
    if(isset($_POST['check_reg'])){
        $registra= new Registrazione();
        $registra-> RegistrazioneUtente();
    }
    if(isset($_POST['check_agg_cliente'])){
        $aggiungi= new AggCliente($conn);
        $aggiungi->aggCliente();

    }