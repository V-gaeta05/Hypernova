<?php
    require_once("db.php");
    if (isset($_GET)) {
        if ($_GET['method'] == 'dettagli') {
            
            $code = $_GET['id'];

            $query = "SELECT * FROM hy_fatture WHERE code = $code";

            $result = $conn->query($query)->fetch_all();

            echo $result['core'];
        }


    }