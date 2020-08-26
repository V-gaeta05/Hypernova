<?php

    require_once('config/config.php');

    if( isset($_POST)&&(!empty($_POST)) ) {
        if ( isset($_POST['id_coop'])&&(!empty($_POST['id_coop'])) ) {
            $id_coop = $_POST['id_coop'];
        } else {
            die("Nessun id_coop inserito");
        }

        if ( isset($_POST['nome_coop'])&&(!empty($_POST['nome_coop'])) ) {
            $nome_coop = $_POST['nome_coop'];
        } else {
            die("Nessun nome_coop inserito");
        }

        if ( isset($_POST['id_socio'])&&(!empty($_POST['id_socio'])) ) {
            $id_socio = $_POST['id_socio'];
        } else {
            die("Nessun id_socio inserito");
        }

        if ( isset($_POST['cod_cliente_infinity'])&&(!empty($_POST['cod_cliente_infinity'])) ) {
            $cod_cliente_infinity = $_POST['cod_cliente_infinity'];
        } else {
            die("Nessun cod_cliente_infinity inserito");
        }

        if ( isset($_POST['nome'])&&(!empty($_POST['nome'])) ) {
            $nome = $_POST['nome'];
        } else {
            die("Nessun nome inserito");
        }

        if ( isset($_POST['cognome'])&&(!empty($_POST['cognome'])) ) {
            $cognome = $_POST['cognome'];
        } else {
            die("Nessun cognome inserito");
        }

        if ( isset($_POST['cod_prestazione'])&&(!empty($_POST['cod_prestazione'])) ) {
            $cod_prestazione = $_POST['cod_prestazione'];
        } else {
            die("Nessun cod_prestazione inserito");
        }

        if ( isset($_POST['importo'])&&(!empty($_POST['importo'])) ) {
            $importo = $_POST['importo'];
        } else {
            die("Nessun importo inserito");
        }

        if ( isset($_POST['prestazione'])&&(!empty($_POST['prestazione'])) ) {
            $prestazione = $_POST['prestazione'];
        } else {
            $prestazione = '';
        }

        if ( isset($_POST['status'])&&(!empty($_POST['status'])) ) {
            $status = $_POST['status'];
        } else {
            $status = '';
        }

        if ( isset($_POST['messaggi'])&&(!empty($_POST['messaggi'])) ) {
            $messaggi = $_POST['messaggi'];
        } else {
            $messaggi = '';
        }

        $payment = new Payment($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi);
        $data = $payment->dataEmissione();
        $codePayment = $payment->creazioneCodicePagamento();

        $db = new Db($conn);

        $sql = "INSERT INTO pagamenti (id_coop, nome_coop, id_socio, cod_cliente_infinity, nome, cognome, cod_prestazione, prestazione, importo, status, messaggi, data_emissione, cod_pagamento) 
        VALUES ('$id_coop', '$nome_coop', '$id_socio', '$cod_cliente_infinity', '$nome', '$cognome', '$cod_prestazione', '$prestazione', '$importo', '$status', '$messaggi', '$data', '$codePayment')";

        $response = $db->insert($sql);

        if( $response['risultato'] == 1) {
            $paymentLink = $payment->generateLink($codePayment);

        } else if ($response['risultato'] == 0) {
            die("Impossibile inserire il risultato nel database.");
        }

        echo $paymentLink;
    } else {
        die("Errore nella ricezione dei dati.");
    }
    
?>