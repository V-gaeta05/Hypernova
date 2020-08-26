<?php

    $server = 'localhost';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'hypernova_def';

    $conn = new mysqli($server, $dbUser, $dbPassword, $dbName);

    if(!$conn) {
        die("Impossibile eseguire la connessione al database".$conn->connect_error.$conn->connect_errno);
    }
?>