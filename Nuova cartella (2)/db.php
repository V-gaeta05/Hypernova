<?php

    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "hypernova";

    $conn = new mysqli($server, $user, $password, $dbname);

    if (!$conn) {
        die("Connessione non riuscita ".$conn->errno);
    }
?>