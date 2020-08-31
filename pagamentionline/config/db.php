<?php

    $server = '192.168.111.39';
    $dbUser = 'pw_hypernova';
    $dbPassword = 'pwhyp3n0v4d3f';
    $dbName = 'hypernova_def';

    $conn = new mysqli($server, $dbUser, $dbPassword, $dbName);

    if(!$conn) {
        die("Impossibile eseguire la connessione al database".$conn->connect_error.$conn->connect_errno);
    }
?>