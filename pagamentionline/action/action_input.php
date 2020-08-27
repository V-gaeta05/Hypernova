<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once('../config/config.php');
    $err = new Errori;
    if( isset($_POST)&&(!empty($_POST)) ) {
        if ( isset($_POST['id_coop'])&&(!empty($_POST['id_coop'])) ) {
            $id_coop = $_POST['id_coop'];
        } else {
            $err->setError('id_coop', 1, 0);
        }

        if ( isset($_POST['nome_coop'])&&(!empty($_POST['nome_coop'])) ) {
            if ($err->checkChar($_POST['nome_coop'], 255) == 1) {
                $err->setError('nome_coop', 1, 1);
            } else {
                $nome_coop = $_POST['nome_coop'];
            }
        } else {
            $err->setError('nome_coop', 1, 0);
        }

        if ( isset($_POST['id_socio'])&&(!empty($_POST['id_socio'])) ) {
            $id_socio = $_POST['id_socio'];
        } else {
            $err->setError('id_socio', 1, 0);
        }

        if ( isset($_POST['cod_cliente_infinity'])&&(!empty($_POST['cod_cliente_infinity'])) ) {
            if ($err->checkChar($_POST['cod_cliente_infinity'], 255) == 1) {
                $err->setError('cod_cliente_infinity', 1, 1);
            } else {
                $cod_cliente_infinity = $_POST['cod_cliente_infinity'];
            }
        } else {
            $err->setError('cod_cliente_infinity', 1, 0);
        }

        if ( isset($_POST['nome'])&&(!empty($_POST['nome'])) ) {
            if ($err->checkChar($_POST['nome'], 255) == 1) {
                $err->setError('nome', 1, 1);
            } else {
                $nome = $_POST['nome'];
            }
        } else {
            $err->setError('nome', 1, 0);
        }

        if ( isset($_POST['cognome'])&&(!empty($_POST['cognome'])) ) {
            if ($err->checkChar($_POST['cognome'], 255) == 1) {
                $err->setError('cognome', 1, 1);
            } else {
                $cognome = $_POST['cognome'];
            }
        } else {
            $err->setError('cognome', 1, 0);
        }

        if ( isset($_POST['cod_prestazione'])&&(!empty($_POST['cod_prestazione'])) ) {
            if ($err->checkChar($_POST['cod_prestazione'], 255) == 1) {
                $err->setError('cod_prestazione', 1, 1);
            } else {
                $cod_prestazione = $_POST['cod_prestazione'];
            }
        } else {
            $err->setError('cod_prestazione', 1, 0);
        }

        if ( isset($_POST['importo'])&&(!empty($_POST['importo'])) ) {
            $importo = $_POST['importo'];
        } else {
            $err->setError('importo', 1, 0);
        }

        if ( isset($_POST['prestazione'])&&(!empty($_POST['prestazione'])) ) {
            if ($err->checkChar($_POST['prestazione'], 500) == 1) {
                $err->setError('prestazione', 1, 1);
            } else {
                $prestazione = $_POST['prestazione'];
            }
        } else {
            $prestazione = '';
        }

        if ( isset($_POST['status'])&&(!empty($_POST['status'])) ) {
            if ($err->checkChar($_POST['status'], 255) == 1) {
                $err->setError('status', 1, 1);
            } else {
                $status = $_POST['status'];
            }
        } else {
            $status = '';
        }

        if ( isset($_POST['messaggi'])&&(!empty($_POST['messaggi'])) ) {
            if ($err->checkChar($_POST['messaggi'], 255) == 1) {
                $err->setError('messaggi', 1, 1);
            } else {
                $messaggi = $_POST['messaggi'];
            }
        } else {
            $messaggi = '';
        }

        if ( isset($_POST['email'])&&(!empty($_POST['email'])) ) {
            if ($err->checkEmail($_POST['email'], 255) == 1) {
                $err->setError('email', 1, 2);
            } else if ($err->checkEmail($_POST['email'], 255) == 2) {
                $err->setError('email', 1, 1);
                
            } else {
                $email = $_POST['email'];
            }
        } else {
            $err->setError('email', 1, 0);
        }

        if ($err->checkError() == 0) {
            $payment = new Payment($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi, $email);
            
            $data = $payment->dataEmissione();
            $codePayment = $payment->creazioneCodicePagamento();

            $db = new Db($conn);

            $sql = "INSERT INTO pagamenti (id_coop, nome_coop, id_socio, cod_cliente_infinity, nome, cognome, cod_prestazione, prestazione, importo, status, messaggi, data_emissione, cod_pagamento, email) 
                VALUES ('$id_coop', '$nome_coop', '$id_socio', '$cod_cliente_infinity', '$nome', '$cognome', '$cod_prestazione', '$prestazione', '$importo', '$status', '$messaggi', '$data', '$codePayment', '$email')";

            $response = $db->insert($sql);

            if( $response['risultato'] == 1) {
                $paymentLink = $payment->generateLink($codePayment);
                $mail = new SandEmail();
                $mail->sendEmail($paymentLink, $email);

            } else if ($response['risultato'] == 0) {
                die("Impossibile inserire il risultato nel database.");
            }
            
            echo json_encode($err->getError()); 
        } else {
            echo json_encode($err->getError());
        }
      
    } else {
        die("Errore nella ricezione dei dati.");
    }
    
?>