<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Registrazione{
    private $name;
    private $surname;
    private $mail;
    private $psw;

    public function setName($nome){
        $nome= filter_var($nome,FILTER_SANITIZE_STRING);
        $this->name=$nome;
    }
    public function setSurname($cognome){
        $cognome= filter_var($cognome, FILTER_SANITIZE_STRING);
        $this->surname=$cognome;
    }
    public function setMail($email){
        $email= filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->mail= $email;
    }
    public function setPsw($password){
        $password= filter_var($password,FILTER_SANITIZE_STRING);
        $this->psw=$password;
        $this->psw=sha1($this->psw);
    }
    public function RegistrazioneUtente(){
        
        try{
        $db = new PDO("mysql:host=localhost;dbname=hypernova",'root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
        echo $e->getMessage();
        }
        $reg= new aggRegistrazione();
        $cf=$_POST['cf'];
        $data=$_POST['data'];
        $piva=$_POST['pIva'];
        $tel=$_POST['nTel'];
        $azienda=$_POST['azienda'];
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $email=$_POST['emailreg'];
        $password=$_POST['passwordreg'];
        $tipo_utente=$_POST['check_reg'];
        $nome= $reg->setName($nome);
        $cognome=$reg->setName($cognome);
        $azienda=$reg->setName($azienda);
        $cf=$reg->setCf($cf);
        $data=$reg->setData($data);
        $piva=$reg->setPiva($piva);
        $tel=$reg->setTel($tel);
        $email=$reg->setMail($email);
        $password=$reg->setPsw($password);
        
        $insert = $db->prepare("INSERT INTO hy_soci SET
        Email=:Email,
        Password=:Password,
        Nome=:Nome,
        Cognome=:Cognome,
        Numero_telefono=:Numero_telefono,
        Partita_iva=:Partita_iva,
        Codice_fiscale=:Codice_fiscale,
        Azienda=:Azienda,
        Data_di_nascita=:Data_di_nascita,
        Rank=:Rank");
        $insert->execute(array(
            'Email'=>$email,
            'Password'=>$password,
            'Nome'=>$nome,
            'Cognome'=>$cognome,
            'Numero_telefono'=>$tel,
            'Partita_iva'=>$piva,
            'Codice_fiscale'=>$cf,
            'Azienda'=>$azienda,
            'Data_di_nascita'=>$data,
            'Rank'=>$tipo_utente
        ));
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);
            try{
                require_once 'Config_MAIL.php';
                SMTPservice(2);			                    
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
                $mail->Subject= 'Conferma Email';
                $mail->Body= 'Attiva il tuo account:
                <a href="localhost/Gestionale_tennis2.0/index.php"> Attiva</a>';
                $mail->send();
                header('location:login.php?success');
            }catch(Exception $e){
            echo 'errore';
            }  
        }
}

class aggRegistrazione extends Registrazione{
    private $data;
    private $cf;
    private $piva;
    private $tel;
    public function setCf($cf){
        if(strlen($cf)==0){
            echo '<span style="color:red;">Compilare il campo Codice Fiscale</span>';
        }elseif(!preg_match('/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/',$cf)){
            echo '<span style="color:red;">Compilare correttamente il campo Codice Fiscale</span>';
        }else{
            $cf= filter_var($cf,FILTER_SANITIZE_STRING);
            $cf= strtoupper($cf);
            $this->cf=$cf;
            return $this->cf;
        }
    }
    
    public function setData($data){
        if(strlen($data)== 10) {
            $this->data=$data;
            return $this->data;
        }else{
            echo '<span style="color:red;">Compilare correttamente il campo Data di Nascita</span>';
        }
    }
    
    public function setPiva($piva){
        if(strlen($piva)==0){
            echo '<span style="color:red;">Compilare il campo Partita Iva</span>';
        }else{
            $piva= filter_var($piva,FILTER_SANITIZE_STRING);
            $this->piva=$piva;
            return $this->piva; 
        }
    }

    public function setTel($tel){
        if(!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/',$tel)){
            echo '<span style="color:red;">Compilare correttamente il campo N.Telefono</span>';
        }else{
            $tel= filter_var($tel,FILTER_SANITIZE_NUMBER_INT);
            $this->tel=$tel;
            return $this->tel; 
        }
    }

    public function setName($nome){
        if(strlen($nome)==0){
        echo '<span style="color:red;">Compilare il campo Nome</span>';
        }elseif(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$nome)){
            echo '<span style="color:red;">Non vanno inseriti caratteri speciali</span>';
        }else{
            $nome= filter_var($nome,FILTER_SANITIZE_STRING);
            $this->name=$nome;
            return( $this->name);
        }
    }

    public function setMail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo '<span style="color:red;">Compilare correttamente il campo Email</span>';
        }elseif(!filter_var($email, FILTER_VALIDATE_DOMAIN)){
            echo '<span style="color:red;">Compilare correttamente il campo Email</span>';
        }else{
        $email= filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->mail= $email;
        return( $this->mail);
        }
    }
    public function setPsw($password){
        if(strlen($password)==0){
            echo '<span style="color:red;">Compilare il campo Password</span>';
        }elseif(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $password)){
            echo '<span style="color:red;">La password deve avere almeno una lettera minuscola, una lettera maiuscola, un numero, un carattere speciale ed essere compresa fra 8 e 20 caratteri</span>';
        }else{
        $password= filter_var($password,FILTER_SANITIZE_STRING);
        $password=sha1($password);
        $this->psw=$password;
        return( $this->psw);
        }
    }
}
class Login{
    private $email;
    private $psw;
    private $db;
    function __construct($db){
        $this->db=$db;
    }
    public function logUtente(){
        $reg= new aggRegistrazione();
        $this->email=$_POST['emaillog'];
        $psw=$_POST['passwordlog'];
        $psw=$reg->setPsw($psw);
        $this->psw=$psw;
        $query="SELECT * FROM hy_soci  WHERE Email="."'".$this->email."'"." AND  Password="."'".$this->psw."'"."";
        $verifica_login =$this->db->query($query)->fetch_array();
        if(!empty($verifica_login)){
           global $idu;
           $idu=$verifica_login['Id'];
           return $idu; 

        }else{
           return ('error'); 
            
        }
    }
}