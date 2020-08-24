<?php
function SMTPservice($service) {
  global $eM_Host,$eM_Port,$eM_Auth,$eM_Secure,$eM_username,$eM_password;

  switch ($service) {

    case 0:
    default:
      $eM_Host     = "smtp.example.com";	// SMTP servizio mail
      $eM_Port     = 587;			// 25, 465, 587
      $eM_Auth     = true;			// false (25) true (465, 587)
      $eM_Secure   = "tls";			// "" (25) "ssl" (465) "tls" (587)
      $eM_username = "name@example.com";	// utente conosciuto dal servizio mail usato
      $eM_password = "password";		// password dell'utente
      break;

    case 1:
      $eM_Host     = "out.alice.it";		// ok mail
      $eM_Port     = "25";
      $eM_Auth     = false;
      $eM_Secure   = "";
      $eM_username = "CAMBIAMI@alice.it";
      $eM_password = "CAMBIAMI";
      break;

    case 2:
      $eM_Host     = "smtp.gmail.com";		// ok PHPmailer
      $eM_Port     = 465;
      $eM_Auth     = true;
      $eM_Secure   = "ssl";
      $eM_username = "";
      $eM_password = "";
      break;

    case 3:
      $eM_Host     = "smtp.web.de";		// ok PHPmailer
      $eM_Port     = 587;
      $eM_Auth     = true;
      $eM_Secure   = "tls";
      $eM_username = "CAMBIAMI@web.de";
      $eM_password = "CAMBIAMI";
      break;

    case 4:
      $eM_Host     = "mail.tin.it";		// ok mail
      $eM_Port     = 587;
      $eM_Auth     = true;
      $eM_Secure   = "";
      $eM_username = "CAMBIAMI@tin.it";
      $eM_password = "CAMBIAMI";
      break;

    case 5:
      $eM_Host     = "smtp.live.com";		// ok PHPmailer
      $eM_Port     = 587;
      $eM_Auth     = true;
      $eM_Secure   = "tls";
      $eM_username = "CAMBIAMI@hotmail.com";
      $eM_password = "CAMBIAMI";
      break;

    case 6:
      $eM_Host     = "smtp.libero.it";		// ok PHPmailer
      $eM_Port     = 465;
      $eM_Auth     = true;
      $eM_Secure   = "ssl";
      $eM_username = "CAMBIAMI@libero.it";
      $eM_password = "CAMBIAMI";
      break;

    case 81:
      $eM_Host     = "smtp.tiscali.it";		// NON PROVATO
      $eM_Port     = 465;
      $eM_Auth     = true;
      $eM_Secure   = "ssl";
      $eM_username = "name@example.com";
      $eM_password = "password";
      break;

    case 91:
      $eM_Host     = "smtp.aruba.it";		// ok mail
      $eM_Port     = 25;
      $eM_Auth     = false;
      $eM_Secure   = "";
      $eM_username = "CAMBIAMI@MIOSITO.it";
      $eM_password = "CAMBIAMI";
      break;

    case 92:
      $eM_Host     = "smtps.aruba.it";        // ok PHPmailer SMTP aruba con SSL
      $eM_Port     = 465;
      $eM_Auth     = true;
      $eM_Secure   = "ssl";
      $eM_username = "CAMBIAMI@MIOSITO.it";
      $eM_password = "CAMBIAMI";
      break;
  }
  return;
}

?>
