<?php

    require_once("db.php");

    $email = $_POST['email'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data = $_POST['data'];
    $telefono = $_POST['telefono'];
    $cf = $_POST['cf'];
    $piva = $_POST['piva'];
    $azienda = $_POST['azienda'];
    $admin = $_POST['chadmin'];
    $query= "INSERT INTO `hy_soci`( `Email`, `Password`, `Nome`, `Cognome`, `Numero_telefono`, `Partita_iva`, `Codice_fiscale`, `Azienda`, `Data_di_nascita`, `Admin`) VALUES (?,?,?,?,?,?,?,?,?,?)";
    if($result= $conn->prepare($query)){
        $result->bind_param('ssssssssss',$email,$password,$nome,$cognome,$telefono,$piva,$cf,$azienda,$data,$admin);
        if($result->execute()){
            echo(json_encode("ciao"));

        }
    }
    
?>