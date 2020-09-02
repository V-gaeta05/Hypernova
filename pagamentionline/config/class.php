<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class SandEmail {
        public function setTime() {
            $time = new DateTime();
            $t = $time->format('H');
            if (($t>=8)&&($t <= 15)) {
                $message = 'Buongiorno';
            } else {
                $message = "Buonasera";
            }
            return $message;
        }

        public function sendEmail($email_cliente, $from, $subject, $body){
            require '../vendor/autoload.php';
            $mail = new PHPMailer(true);
            $eM_Host     = "smtp.libero.it";		
            $eM_Port     = 465;
            $eM_Auth     = true;
            $eM_Secure   = "ssl";
            $eM_username = "pippobaudo1992_2021@libero.it";
            $eM_password = "123456@Az";
            

            $mail->SMTPDebug = 3;			// attiva log dell'invio, ELIMINARE quando si mette in "produzione"
            $mail->Debugoutput = "error_log";	// scrive messaggi di errore nel log di PHP, si può lasciare sempre
        
            // impostazione del servizio
            $mail->IsSMTP();
            
            $mail->CharSet = 'UTF-8';
            $mail->Host       = $eM_Host;
            $mail->Port       = $eM_Port;
            $mail->SMTPAuth   = $eM_Auth;
            $mail->SMTPSecure = $eM_Secure;
            $mail->Username   = $eM_username;	// mittente
            $mail->Password   = $eM_password;
        
          
            $mail->From =  $mail->Username;
            $mail->FromName = $from;
            $mail->addAddress($email_cliente);     // Add a recipient
            $mail->isHTML(true);
            $mail->Subject= $subject;
            $mail->Body= $body;
            try{
                $mail->send();
                
            }catch(Exception $e){
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        }


    }

    class Errori {
        private $error = [
            'success' => 1,
            'error' => [
                'id_coop' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'id_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cod_cliente_infinity' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'numero_serie' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'data_fattura' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'nome_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cognome_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'prestazione' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'importo' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cliente' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'status' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'messaggi' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'Email' => [
                    'value' => 1,
                    'typeError' => '',
                ],
            ],
        ];
        private $typeError = [
            '0' => "Il campo risulta vuoto",
            '1' => 'Il campo non rispetta i parametri prestabiliti',
            '2' => 'Email non valida',
            '3' => "L'importo deve essere maggiore di zero",
            '4' => "L'id della cooperativa non esiste"
        ];

        public function setError($indice, $errore = 1, $type = '') {
            $this->error['error'][$indice]['value'] = $errore;
            $this->error['error'][$indice]['typeError'] = $this->typeError[$type];
        }

        public function setImporto($importo) {
            if ($importo > 0 ) {
                return 0;
            } else {
                return 1;
            }
        }

        public function checkChar($string, $length) {
            if (strlen($string) > $length) {
                return 1;
            } else {
                return 0;
            }
        }

        public function checkEmail($email, $length) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)||!filter_var($email, FILTER_VALIDATE_DOMAIN)) {
                return 1;
            } else if (strlen($email) > $length) {
                return 2;
            } else {
                return 0;
            }

            
        }

        public function checkError() {
            
            foreach($this->error['error'] as $key=>$a) {
                if ($this->error['error'][$key]['value'] == 0) {
                    $this->error['success'] = 0;
                }
            }

            if ($this->error['success'] == 0) {
                return 0;
            } else {
                return 1;
            }
        }

        public function getError() {
            return $this->error;
        }

    }

    class Payment {
        private $id_coop;
        private $id_socio;
        private $cod_cliente_infinity;
        private $numero_serie;
        private $data_fattura;
        private $nome_socio;
        private $cognome_socio;
        private $prestazione;
        private $importo;
        private $status;
        private $messaggi;
        private $cliente;
        private $email_cliente;


        function __construct($id_coop, $id_socio, $cod_cliente_infinity, $numero_serie, $data_fattura, $nome_socio, $cognome_socio, $prestazione, $importo, $status, $messaggi, $cliente, $email_cliente) {
            $this->id_coop = h($id_coop);
            $this->id_socio = h($id_socio);
            $this->cod_cliente_infinity = h($cod_cliente_infinity);
            $this->numero_serie = h($numero_serie);
            $this->data_fattura = h($this->setRightData($data_fattura));
            $this->nome_socio = $this->setName($nome_socio);
            $this->cognome_socio = $this->setName($cognome_socio);
            $this->prestazione = h($prestazione);
            $this->importo = $this->setAmmount($importo);
            $this->status = h($status);
            $this->messaggi = h($messaggi);
            $this->cliente = $this->setName($cliente);
            $this->email_cliente = h($email_cliente);
        }

        public function setRightData($data) {
            $d = new DateTime($data);
            $date = $d->format("Y-m-d H:i:s");
            return $date;
        }

        public function setName($str){
            $str = h(ucwords($str));
            return $str;
        }

        public function setAmmount($importo){
            $importo = (float) $importo;
            $importo = $importo*1.04;
            return $importo;
        }

        public function dataEmissione() {
            $data = new DateTime();

            return $data->format('Y-m-d H:i:s');
        }

        public function creazioneCodicePagamento() {
            $codeFattura = '';
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charactersLength = strlen($characters);

            $codeFattura .= $this->id_coop.'-'.$this->id_socio.'-';
            $codeFattura .= date('YmdHis').'-';
            for ($i=0; $i<6; $i++) {
                $codeFattura .= $characters[rand(0, $charactersLength-1)];
            }
            return $codeFattura;
        }

        public function getValore($indice) {
            return $this->$indice;
        }

        public function generateLink($codepayment) {

            $link = PROJECT_PATH.'/payment.php?method=external_payment&code='.$codepayment;
            return $link;
        }

    }

    class Db {
        private $db;

        function __construct($db) {
            $this->db = $db;
        }

        public function insert($sql) {
            $result = $this->db->query($sql);
            if ($result) {
                $esito = [
                    'risultato' => 1,
                    'last_id'   => $this->db->insert_id,
                ];
            } else {
                $esito = [
                    'risultato' => 0,
                    'last_id'   => '',
                ];
            }
            return $esito;
        }

        public function select($sql) {
            $result = $this->db->query($sql);
            return $result;
        }

        public function update($sql) {
            $result = $this->db->query($sql);
            if($result) {
                $esito = 1;
            } else {
                $esito = 0;
            }
            return $esito;
        }
    }

    function h($string){
        return htmlspecialchars($string);
    }