<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class SandEmail {
        public function sendEmail(){
            require 'vendor/autoload.php';
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
            
              
                $mail->Setfrom($eM_username, "Lavoro");
                $mail->addAddress($email2);     // Add a recipient
                $mail->isHTML(true);
                $mail->Subject= '';
                $mail->Body= 'Attiva il tuo account:
                <a href="localhost/Gestionale_tennis2.0/index.php"> Attiva</a>';
                $mail->send();
                header('location:login.php?success');
            }catch(Exception $e){
            echo 'errore';
            }
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
        private $msgError = [
            'nome_coop'            => 0,
            'cod_cliente_infinity' => 0,
            'nome'                 => 0,
            'cognome'              => 0,
            'cod_prestazione'      => 0,
            'prestazione'          => 0,
            'status'               => 0,
            'messaggi'             => 0,
        ];

        function __construct($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi) {
            $this->id_coop = $this->setId($id_coop);
            $this->nome_coop = $this->setChar($nome_coop,'nome_coop', 255);
            $this->id_socio = $this->setId($id_socio);
            $this->cod_cliente_infinity = $this->setChar($cod_cliente_infinity,'cod_cliente_infinity', 255);
            $this->nome = $this->setName($nome,'nome', 255);
            $this->cognome = $this->setName($cognome,'cognome', 255);
            $this->cod_prestazione = $this->setChar($cod_prestazione,'cod_prestazione', 255);
            $this->prestazione = $this->setChar($prestazione,'prestazione', 500);
            $this->importo = $this->setAmmount($importo);
            $this->status = $this->setChar($status,'status', 255);
            $this->messaggi = $this->setChar($messaggi,'messaggi', 255);
        }

        public function getError(){
            return $this->msgError;
        }

        public function setId($id_coop){
            return h($id_coop);
        }

        public function setChar($str, $index , $lenght){
            $str = h($str);
            if (strlen($str) > $lenght){
                $this->msgError = [
                    $index => 1,
                ];
                return $this->msgError; 
            } else {
                return $str;
            }
        }

        public function setName($str, $index , $lenght){
            $str = h($str);
            if (strlen($str) > $lenght){
                $this->msgError = [
                    $index => 1,
                ];
                return $this->msgError; 
            } else {
                $str = ucwords($str); 
                return $str;
            }
        }

        public function setAmmount($importo){
            $importo = $importo * 104 / 100;
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