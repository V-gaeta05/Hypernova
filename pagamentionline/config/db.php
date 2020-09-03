<?php

    $dsn = "mysql:host=localhost;dbname=hypernova_def";
    $server = 'localhost';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'hypernova_def';

    $conn = new PDO($dsn, $dbUser,$dbPassword);

    if(!$conn) {
        die("Impossibile eseguire la connessione al database".$conn->connect_error.$conn->connect_errno);
    }
?>