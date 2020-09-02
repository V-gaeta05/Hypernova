<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once('../config/config.php');
    $err = new Errori;
    $db = new Db($conn);
    
    // Richiamiamo la tabella delle coop
    $sql = "SELECT * FROM cooperative";
    $coop = $db->select($sql);

    
if (isset($_GET['action'])&&(!empty($_GET['action']))) {
    if ($_GET['action'] == 'insert') {
        // Controllo dei campi ricevuti in $_POST tradotti da JSON
        if( isset($_POST)&&(!empty($_POST)) ) {
            // Ricezione e traduzione dei dati JSON
            $array = json_decode($_POST['mydata']);
            if ( isset($array->id_coop)&&(!empty($array->id_coop)) ) {
                $control = 0;
                foreach($coop as $cpa) {
                    if ($cpa['id_cooperativa'] == $array->id_coop) {
                        $control += 1;
                    } 
                }
                if ($control > 0) {
                    $id_coop = $array->id_coop;
                } else {
                    $err->setError('id_coop', 0, 4);
                }
                
            } else {
                $err->setError('id_coop', 0, 0);
            }

            if ( isset($array->id_socio)&&(!empty($array->id_socio)) ) {
                $id_socio = $array->id_socio;
            } else {
                $err->setError('id_socio', 0, 0);
            }

            if ( isset($array->cod_cliente_infinity)&&(!empty($array->cod_cliente_infinity)) ) {
                if ($err->checkChar($array->cod_cliente_infinity, 255) == 1) {
                    $err->setError('cod_cliente_infinity', 0, 1);
                } else {
                    $cod_cliente_infinity = $array->cod_cliente_infinity;
                }
            } else {
                $err->setError('cod_cliente_infinity', 0, 0);
            }

            if ( isset($array->numero_serie)&&(!empty($array->numero_serie)) ) {
                if ($err->checkChar($array->numero_serie, 255) == 1) {
                    $err->setError('numero_serie', 0, 1);
                } else {
                    $numero_serie = $array->numero_serie;
                }
            } else {
                $err->setError('numero_serie', 0, 0);
            }

            if ( isset($array->nome_socio)&&(!empty($array->nome_socio)) ) {
                if ($err->checkChar($array->nome_socio, 255) == 1) {
                    $err->setError('nome_socio', 0, 1);
                } else {
                    $nome_socio = $array->nome_socio;
                }
            } else {
                $err->setError('nome_socio', 0, 0);
            }

            if ( isset($array->cognome_socio)&&(!empty($array->cognome_socio)) ) {
                if ($err->checkChar($array->cognome_socio, 255) == 1) {
                    $err->setError('cognome_socio', 0, 1);
                } else {
                    $cognome_socio = $array->cognome_socio;
                }
            } else {
                $err->setError('cognome_socio', 0, 0);
            }

            if ( isset($array->data_fattura)&&(!empty($array->data_fattura)) ) {
                $data_fattura = $array->data_fattura;
            } else {
                $err->setError('data_fattura', 0, 0);
            }

            if ( isset($array->importo)&&(!empty($array->importo)) ) {
                if ($err->setImporto($array->importo) == 0) {
                    $importo = $array->importo;
                } else {
                    $err->setError('importo', 0, 3);
                }
                
            } else {
                $err->setError('importo', 0, 0);
            }

            if ( isset($array->prestazione)&&(!empty($array->prestazione)) ) {
                if ($err->checkChar($array->prestazione, 500) == 1) {
                    $err->setError('prestazione', 0, 1);
                } else {
                    $prestazione = $array->prestazione;
                }
            } else {
                $err->setError('prestazione', 0, 0);
            }

            if ( isset($array->status)&&(!empty($array->status)) ) {
                if ($err->checkChar($array->status, 255) == 1) {
                    $err->setError('status', 0, 1);
                } else {
                    $status = $array->status;
                }
            } else {
                $status = '';
            }

            if ( isset($array->messaggi)&&(!empty($array->messaggi)) ) {
                if ($err->checkChar($array->messaggi, 255) == 1) {
                    $err->setError('messaggi', 0, 1);
                } else {
                    $messaggi = $array->messaggi;
                }
            } else {
                $messaggi = '';
            }

            if ( isset($array->Email)&&(!empty($array->Email)) ) {
                if ($err->checkEmail($array->Email, 255) == 1) {
                    $err->setError('Email', 0, 2);
                } else if ($err->checkEmail($array->Email, 255) == 2) {
                    $err->setError('Email', 0, 1);
                    
                } else {
                    $email_cliente = $array->Email;
                }
            } else {
                $err->setError('Email', 0, 0);
            }

            if ( isset($array->cliente)&&(!empty($array->cliente)) ) {
                if ($err->checkChar($array->cliente, 255) == 1) {
                    $err->setError('cliente', 0, 1);
                } else {
                    $cliente = $array->cliente;
                }
            } else {
                $err->setError('cliente', 0, 0);
            }
            $errori = $err->getError();
            if ($err->checkError() == 1) {
                $payment = new Payment($id_coop, $id_socio, $cod_cliente_infinity, $numero_serie, $data_fattura, $nome_socio, $cognome_socio, $prestazione, $importo, $status, $messaggi, $cliente, $email_cliente);
                
                // Settaggio valori da passare al DB
                $id_coop = $payment->getValore('id_coop');
                $id_socio = $payment->getValore('id_socio');
                $cod_cliente_infinity = $payment->getValore('cod_cliente_infinity');
                $numero_serie = $payment->getValore('numero_serie');
                $data_fattura = $payment->getValore('data_fattura');
                $nome_socio = $payment->getValore('nome_socio');
                $cognome_socio = $payment->getValore('cognome_socio');
                $prestazione = $payment->getValore('prestazione');
                $importo = $payment->getValore('importo');
                $status = $payment->getValore('status');
                $messaggi = $payment->getValore('messaggi');
                $codePayment = $payment->creazioneCodicePagamento();
                $email_cliente = $payment->getValore('email_cliente');
                $cliente = $payment->getValore('cliente');

                
                $sql = "INSERT INTO pagamenti (id_coop, id_socio, cod_cliente_infinity, numero_serie, data_emissione, nome_socio, cognome_socio, prestazione, importo, status, messaggi, cliente, email_cliente, cod_link) 
                    VALUES ('$id_coop','$id_socio', '$cod_cliente_infinity', '$numero_serie', '$data_fattura', '$nome_socio', '$cognome_socio', '$prestazione', '$importo', '$status', '$messaggi', '$cliente', '$email_cliente', '$codePayment')";

                $response = $db->insert($sql);

                if( $response['risultato'] == 1) {
                    $paymentLink = $payment->generateLink($codePayment);
                    $mail = new SandEmail();
                    $from = $nome_socio.' '.$cognome_socio;
                    $saluto = $mail->setTime();
                    $subject = 'Emissione Pagamento';
                    $body = '<h5>Emissione Pagamento</h5>'.
                    "$saluto ".$cliente.".<br>E' stato emesso un nuovo pagamento a suo nome da ".$from.'.<br> La causale del pagamento riportata '.chr(232).': <br>'.$prestazione.'. <br><a style="color: green;" href="'.$paymentLink.'"> Vai al pagamento</a>';
                    $mail->sendEmail($email_cliente, $from, $subject, $body);
                    
                } else if ($response['risultato'] == 0) {
                    die("Impossibile inserire il risultato nel database.");
                }
                
                echo json_encode($errori['success']); 
            } else {
                $sendError = [
                    'success' => 0,
                ];
                foreach($errori['error'] as $key=>$errore) {
                    if ($errori['error'][$key]['value'] == 0) {
                        $sendError[$key] = [
                            'value' => 0,
                            'typeError' => $errore['typeError'],
                        ];
                    }
                }
                echo json_encode($sendError);
            }
        
        } else {
            die("Errore nella ricezione dei dati.");
        }
    } else if ($_GET['action'] == 'delete') {
        $array = json_decode($_POST['mydata']);

        $numero_serie = $array->numero_serie;

        $sql = "UPDATE pagamenti SET pagamento_attivo = 0 WHERE numero_serie = '$numero_serie'";

        $result = $db->update($sql);

        if ($result) {
            $success = 1;
            echo json_encode($success);
        } else {
            $success = 0;
            echo json_encode($success);
        }
    }
} else {
    die("Wrong access method to this page.");
}
    
?>