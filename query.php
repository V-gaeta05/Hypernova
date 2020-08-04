<?php
    require('class.php');
    require('db.php');
    $login=new Login($conn);
    if(isset($_POST['check_log'])){
        $id=$login->logUtente();
        header('location:index.php?id='.$id);
    }