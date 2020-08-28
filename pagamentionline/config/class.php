<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class SandEmail {
        public function sendEmail($link, $email_cliente, $nome){
            require '../vendor/autoload.php';
            $mail = new PHPMailer(true);
            try{
                $eM_Host     = "smtp.web.de";		
                $eM_Port     = 587;
                $eM_Auth     = true;
                $eM_Secure   = "tls";
                $eM_username = "CAMBIAMI@web.de";
                $eM_password = "CAMBIAMI";

                $mail = new PHPMailer();

                $mail->SMTPDebug = 4;			// attiva log dell'invio, ELIMINARE quando si mette in "produzione"
                $mail->Debugoutput = "error_log";	// scrive messaggi di errore nel log di PHP, si può lasciare sempre
            
                // impostazione del servizio
                $mail->IsSMTP();
            
                $mail->Host       = $eM_Host;
                $mail->Port       = $eM_Port;
                $mail->SMTPAuth   = $eM_Auth;
                $mail->SMTPSecure = $eM_Secure;
                $mail->Username   = $eM_username;	// mittente
                $mail->Password   = $eM_password;
            
              
                $mail->Setfrom($eM_username, $nome);
                $mail->addAddress($email_cliente);     // Add a recipient
                $mail->isHTML(true);
                $mail->Subject= 'Emissione Pagamento';
                $mail->Body= '<h5>Emissione Pagamento</h5>'.
                "E' stato emesso un nuovo pagamento a suo nome da".$nome.'. <br><a href="'.$link.'"> Vai al pagamento</a>';
                $mail->send();
                
            }catch(Exception $e){
            echo 'errore';
            }
        }


    }

    class Errori {
        private $error = [
            'id_coop' => [
                'value' => 0,
                'typeError' => '',
            ],
            'nome_coop' => [
                'value' => 0,
                'typeError' => '',
            ],
            'id_socio' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cod_cliente_infinity' => [
                'value' => 0,
                'typeError' => '',
            ],
            'nome' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cognome' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cod_prestazione' => [
                'value' => 0,
                'typeError' => '',
            ],
            'prestazione' => [
                'value' => 0,
                'typeError' => '',
            ],
            'importo' => [
                'value' => 0,
                'typeError' => '',
            ],
            'status' => [
                'value' => 0,
                'typeError' => '',
            ],
            'messaggi' => [
                'value' => 0,
                'typeError' => '',
            ],
            'email' => [
                'value' => 0,
                'typeError' => '',
            ],
        ];
        private $typeError = [
            '0' => "E' vuoto",
            '1' => 'Non rispetta i parametri',
            '2' => 'Email non valida',
        ];

        public function setError($indice, $errore = 0, $type = '') {
            $this->error[$indice]['value'] = $errore;
            $this->error[$indice]['typeError'] = $this->typeError[$type];
        }

        public function checkChar($string, $length) {
            if (strlen($string) > $length) {
                return 1;
            } else {
                return 0;
            }
        }

        public function checkEmail($email, $length) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)&&!filter_var($email, FILTER_VALIDATE_DOMAIN)) {
                return 1;
            } else if ($email > $length) {
                return 2;
            } else {
                return 0;
            }

            
        }

        public function checkError() {
            $chekErrore = 0;
            foreach($this->error as $key=>$errore) {
                if ($this->error[$key]['value'] == 1) {
                    $chekErrore += 1;
                }
            }

            if ($chekErrore > 0) {
                return 1;
            } else {
                return 0;
            }
        }

        public function getError() {
            return $this->error;
        }

    }

    class Payment {
        private $id_coop;
        private $nome_coop;
        private $id_socio;
        private $cod_cliente_infinity;
        private $nome;
        private $cognome;
        private $cod_prestazione;
        private $prestazione;
        private $importo;
        private $status;
        private $messaggi;
        private $email;

        function __construct($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi, $email) {
            $this->id_coop = h($id_coop);
            $this->nome_coop = h($nome_coop);
            $this->id_socio = h($id_socio);
            $this->cod_cliente_infinity = h($cod_cliente_infinity);
            $this->nome = $this->setName($nome);
            $this->cognome = $this->setName($cognome);
            $this->cod_prestazione = h($cod_prestazione);
            $this->prestazione = h($prestazione);
            $this->importo = $this->setAmmount($importo);
            $this->status = h($status);
            $this->messaggi = h($messaggi);
            $this->email = h($email);
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
            for ($i=0; $i<4; $i++) {
                $codeFattura .= $characters[rand(0, $charactersLength-1)];
            }
            return $codeFattura;
        }

        public function getValore($indice) {
            return $this->$indice;
        }

        public function generateLink($codepayment) {

            $link = PROJECT_PATH.'/payment.php?method=external_payment&payment_code='.$codepayment;
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