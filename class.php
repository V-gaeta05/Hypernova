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
        $db = new PDO("mysql:host=localhost;dbname=tennis_club",'root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
        echo $e->getMessage();
        }
        $reg= new aggRegistrazione();
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $email=$_POST['emailreg'];
        $password=$_POST['passwordreg'];
        $tipo_utente=$_POST['check_reg'];
        $nome2= $reg->setName($nome);
        $cognome2=$reg->setSurname($cognome);
        $email2=$reg->setMail($email);
        $password2=$reg->setPsw($password);
        
        $insert = $db->prepare("INSERT INTO tc_utenti SET
        Nome=:Nome,
        Cognome=:Cognome,
        Email=:Email,
        Password=:Password,
        Tipo_utente=:Tipo_utente");
        $insert->execute(array(
            'Nome'=>$nome2,
            'Cognome'=>$cognome2,
            'Email'=>$email2,
            'Password'=>$password2,
            'Tipo_utente'=>$tipo_utente
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
                header('location:../index.php?success');
            }catch(Exception $e){
            echo 'errore';
            }  
        }
}

class aggRegistrazione extends Registrazione{
    private $azienda;
    private $data;
    private $cf;
    private $piva;
    private $tel;

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
    public function setSurname($cognome){
        if(strlen($cognome)==0){
            echo '<span style="color:red;">Compilare il campo Cognome</span>';
        }elseif(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$cognome)){
            echo '<span style="color:red;">Non vanno inseriti caratteri speciali</span>';
        }else{
        $cognome= filter_var($cognome, FILTER_SANITIZE_STRING);
        $this->surname=$cognome;
        return( $this->surname);
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
        //$psw=$reg->setPsw($psw);
        $this->psw=$psw;
        $query="SELECT * FROM hy_soci  WHERE Email="."'".$this->email."'"." AND  Password="."'".$this->psw."'"."";
        $verifica_login =$this->db->query($query)->fetch_array();
        //var_dump( $query);
        if(!empty($verifica_login)){
           global $idu;
           $idu=$verifica_login['Id'];
           return $idu; 

        }else{
           return ('error'); 
            
        }
    }
}