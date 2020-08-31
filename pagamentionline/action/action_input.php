<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once('../config/config.php');
    $err = new Errori;
    $db = new Db($conn);
    
    // Richiamiamo la tabella delle coop
    $sql = "SELECT * FROM cooperative";
    $coop = $db->select($sql);

    // Controllo dei campi ricevuti in $_POST
    if( isset($_POST)&&(!empty($_POST)) ) {
        if ( isset($_POST['id_coop'])&&(!empty($_POST['id_coop'])) ) {
            $control = 0;
            foreach($coop as $cpa) {
                if ($cpa['id_cooperativa'] == $_POST['id_coop']) {
                    $control += 1;
                } 
            }
            if ($control > 0) {
                $id_coop = $_POST['id_coop'];
            } else {
                $err->setError('id_coop', 1, 4);
            }
            
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
            foreach($coop as $cpa) {
                if($cpa['id_cooperativa'] == $id_coop) {
                    $nome_coop = $cpa['nome_cooperativa'];
                }
            }
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
            if ($err->setImporto($_POST['importo']) == 0) {
                $importo = $_POST['importo'];
            } else {
                $err->setError('importo', 1, 3);
            }
            
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
        $errori = $err->getError();
        if ($err->checkError() == 0) {
            $payment = new Payment($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi, $email);
            
            // Settaggio valori da passare al DB
            $id_coop = $payment->getValore('id_coop');
            $nome_coop = $payment->getValore('nome_coop');
            $id_socio = $payment->getValore('id_socio');
            $cod_cliente_infinity = $payment->getValore('cod_cliente_infinity');
            $nome = $payment->getValore('nome');
            $cognome = $payment->getValore('cognome');
            $cod_prestazione = $payment->getValore('cod_prestazione');
            $prestazione = $payment->getValore('prestazione');
            $importo = $payment->getValore('importo');
            $status = $payment->getValore('status');
            $messaggi = $payment->getValore('messaggi');
            $data = $payment->dataEmissione();
            $codePayment = $payment->creazioneCodicePagamento();
            $email = $payment->getValore('email');

            
            $sql = "INSERT INTO pagamenti (id_coop, nome_coop, id_socio, cod_cliente_infinity, nome, cognome, cod_prestazione, prestazione, importo, status, messaggi, data_emissione, cod_pagamento, email) 
                VALUES ('$id_coop', '$nome_coop', '$id_socio', '$cod_cliente_infinity', '$nome', '$cognome', '$cod_prestazione', '$prestazione', '$importo', '$status', '$messaggi', '$data', '$codePayment', '$email')";

            $response = $db->insert($sql);

            if( $response['risultato'] == 1) {
                $paymentLink = $payment->generateLink($codePayment);
                $mail = new SandEmail();
                $from = $nome.' '.$cognome;
                $subject = 'Emissione Pagamento';
                $body = '<h5>Emissione Pagamento</h5>'.
                "E' stato emesso un nuovo pagamento a suo nome da ".$from.'. <br><a style="color: green;" href="'.$paymentLink.'"> Vai al pagamento</a>';
                $mail->sendEmail($email, $from, $subject, $body);
                
            } else if ($response['risultato'] == 0) {
                die("Impossibile inserire il risultato nel database.");
            }
            
            echo json_encode($errori['success']); 
        } else {
            $sendError = [
                'success' => 1,
            ];
            foreach($errori['error'] as $key=>$errore) {
                if ($errori['error'][$key]['value'] == 1) {
                    $sendError[$key] = [
                        'value' => 1,
                        'typeError' => $errore['typeError'],
                    ];
                }
            }
            echo json_encode($sendError);
        }
      
    } else {
        die("Errore nella ricezione dei dati.");
    }
    
?>