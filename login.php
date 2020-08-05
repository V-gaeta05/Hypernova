<!doctype html>
<html lang="en">
  <head>
    <link rel="icon"  type="image/ico" href="Immagini/palla_tennis.png">
    <title>  Hypernova</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </head>
        <body>
            <div class="container" style="margin-top:12%;">
                <div class="row row-col-5">
                    <div class="col" >
                    </div>
                    <div class="col" >
                    </div>
                    <div class="col" style=" padding-top:2%;padding-bottom:2%;" >
                        <div id="div_log" style="text-align:center;">  
                         <?php if(isset($_GET['error2'])){
                             echo '<span style="color:red;">Email o Password ERRATI</span>';}
                             if(isset($_GET['success'])){
                                echo '<span style="color:green;">Registrazione effettuata con successo</span>';}
                                if(isset($_GET['errorlog'])){
                                  echo '<span style="color:red;">effettuare nuovamente il login</span>';
                                }
                         ?>

                            <form id="form_log" action="query.php" method="POST">
                                <label for="">Email</label><br>
                                <input type="email" id="email_log" name="emaillog"> <br><br>
                                <label for="">Password</label><br>
                                <input type="password" id="password_log" name="passwordlog"> <br><br>
                                <input type="hidden" name="check_log">
                                <button class="btn btn-light" id="btt_log">Accedi</button><br>
                            </form>
                            <button class="btn btn" >Password dimenticata?!</button><br>
                            <button class="btn btn" id="btt_go_reg">Non sei ancora registrato? Registrati!</button>
                        </div> 
                        <div id="div_reg" style="display:none;">
                            <form id="form_reg" action="query.php" method="POST">
                                <div id="div_reg_1">
                                    <label for="">Email</label><br>
                                    <input type="email" id="email_reg" name="emailreg"> <br><br>
                                    <label for="">Conferma Email</label><br>
                                    <input type="email" id="email_ceck"> <br><br>
                                    <label for="">Password</label><br>
                                    <input type="password" id="password_reg" name="passwordreg"> <br><br>
                                    <label for="">Conferma Password</label><br>
                                    <input type="password" id="password_ceck" > <br><br>
                                    
                                </div>
                                <div id="div_reg_2" style="display: none;">
                                    <label for="">Nome</label><br>
                                    <input type="text" name="nome" id="nome"><br><br>
                                    <label for="">Cognome</label><br>
                                    <input type="text" name="cognome" id="cognome"><br><br>
                                    <label for="">Data di Nascita</label><br>
                                    <input type="date" name="data" id="data"><br><br>
                                    <label for="">Codice Fiscale</label><br>
                                    <input type="text" name="cf" id="cf"><br><br>
                                    <label for="">Partita IVA</label><br>
                                    <input type="text" name="pIva" id="pIva"><br><br>
                                    <label for="">N.Telefono</label><br>
                                    <input type="tel" name="nTel" id="nTel"><br><br>
                                    <label for="">Azienda</label><br>
                                    <input type="text" name="azienda" id="azienda"><br><br>
                                </div>
                                    <input type="hidden" id="check_reg" name="check_reg" value=" ">
                            </form>
                           
                            <div id="div_btt_cont_reg" style="text-align:center;">
                                <button class="btn btn-light" id="btt_cont_reg">Continua</button>
                            </div>
                            <div id="div_btt_reg" style="display: none;text-align:center;">
                                <button class="btn btn-light" id="btt_reg" >Registrati</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col" >
                    </div>
                    <div class="col" >
                    </div>

                </div>

            </div>
        </body>
</html>
<script type="text/javascript">
    $("#btt_go_reg").click(function(){
        $("#div_log").hide();
        $("#div_reg").fadeIn();
    });
    $("#btt_cont_reg").click(function(){
        let email= $("#email_reg");
        let conf_email= $("#email_ceck");
        let psw= $("#password_reg");
        let conf_psw= $("#password_ceck");
        let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        let paswd=  /^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/;
        let check = 0;
      if(email.val().length<1){
        check +=1;
        $("#errormail1").remove();
        email.css("border-color","red");  
        email.after('<p id="errormail1" style="color:red;">Compilare il campo email</p>');
      }else{
        email.css("border-color","black");
        $("#errormail1").remove();
      } 
      if(!email.val().match(re)){
        check +=1;
        $("#errormail2").remove();
        email.css("border-color","red");  
        email.after('<p id="errormail2" style="color:red;">Inserire una mail valida</p>');
      } else{
        email.css("border-color","black");
        $("#errormail2").remove();
      } 
      if(email.val() !== conf_email.val() || email.val().length<1){
        check +=1;
        $("#errormail3").remove();
        conf_email.css("border-color","red");  
        conf_email.after('<p id="errormail3" style="color:red;">I campi email e conferma email devono corrispondere</p>');
      }else{
        conf_email.css("border-color","black");  
        $("#errormail3").remove();
      }
       if(!psw.val().match(paswd)){
        check +=1;
        $("#errorpsw1").remove();
        psw.css("border-color","red");  
        psw.after('<p id="errorpsw1" style="color:red;">La password deve avere almeno 8 caratteri un carattere speciale una lettera maiuscola una lettera minuscola ed un numero</p>');
      }else{
        psw.css("border-color","black"); 
        $("#errorpsw1").remove(); 
      }
       if(psw.val() !== conf_psw.val() || !psw.val().match(paswd)){
        check +=1;
        $("#errorpsw2").remove();
        conf_psw.css("border-color","red");  
        conf_psw.after('<p id="errorpsw2" style="color:red;">I campi password e conferma password devono corrispondere</p>');
      }else{
        conf_psw.css("border-color","black");  
        $("#errorpsw2").remove();
      }
      if(check==0){
        $("#div_reg_1").hide();
        $("#div_btt_cont_reg").hide();
        $("#div_btt_reg").fadeIn();
        $("#div_reg_2").fadeIn();
      }
    });
    $("#btt_reg").click(function(){
      let nome= $("#nome");
      let cognome= $("#cognome");
      let tel=$("#nTel");
      let piva=$("#pIva");
      let cf=$("#cf");
      let data=$("#data");
      let azienda=$("#azienda");
      let re= /^[A-Za-z]/;
      let retel= /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
      let recf=	/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i;
      let check2=0;
      if(!cf.val().match(recf)){
        check2+=1;
        $("#errorcf").remove();
        cf.css("border-color","red");
        cf.after('<p id="errorcf" style="color:red;">Compilare correttamente il cf</p>');
      }else{
        cf.css("border-color","black");
        $("#errorcf").remove();  
      }
      if(piva.val().length <11 || piva.val().length >11 ){
        check2+=1;
        $("#errorpiva").remove();
        piva.css("border-color","red");
        piva.after('<p id="errorpiva" style="color:red;">Compilare correttamente la partita iva</p>');

      }else{
        piva.css("border-color","black");
        $("#errorpiva").remove();
      }
      if(data.val().length<10){
        check2+=1;
        $("#errordata").remove();
        data.css("border-color","red");
        data.after('<p id="errordata" style="color:red;">Compilare correttamente il cf</p>');
      }else{
        data.css("border-color","black");
        $("#errordata").remove();
      }
      if(nome.val().length<1){
        check2+=1;
        $("#errorname1").remove();
        nome.css("border-color","red");  
        nome.after('<p id="errorname1" style="color:red;">Compilare il campo nome</p>');
      }else{
        nome.css("border-color","black");  
        $("#errorname1").remove();
      }
       if(!nome.val().match(re)){
        check2+=1;
        $("#errorname2").remove();
        nome.css("border-color","red");  
        nome.after('<p id="errorname2" style="color:red;">Sono consentite solo le lettere nel nome</p>');
      }else{
        nome.css("border-color","black");  
        $("#errorname2").remove();
      }
       if(cognome.val().length<1){
        check2+=1;
        $("#errorsurname1").remove();
        cognome.css("border-color","red");  
        cognome.after('<p id="errorsurname1" style="color:red;">Compilare il campo cognome</p>');
      }else{
        cognome.css("border-color","black");  
        $("#errorsurname1").remove();
      }
       if(!cognome.val().match(re)){
        check2+=1;
        $("#errorsurname2").remove();
        cognome.css("border-color","red");  
        cognome.after('<p id="errorsurname2" style="color:red;">Sono consentite solo le lettere nel cognome</p>');
      }else{
        cognome.css("border-color","black");  
        $("#errorsurname2").remove();
      }
       if(azienda.val().length<1){
        check2+=1;
        $("#errorazienda1").remove();
        azienda.css("border-color","red");  
        azienda.after('<p id="errorazienda1" style="color:red;">Compilare il campo azienda</p>');
      }else{
        azienda.css("border-color","black");  
        $("#errorazienda1").remove();
      }
       if(!azienda.val().match(re)){
        check2+=1;
        $("#errorazienda2").remove();
        azienda.css("border-color","red");  
        azienda.after('<p id="errorazienda2" style="color:red;">Sono consentite solo le lettere per l`azienda</p>');
      }else{
        azienda.css("border-color","black");  
        $("#errorazienda2").remove();
      }
      if(!tel.val().match(retel)){
        check2+=1;
        $("#errortel").remove();
        tel.css("border-color","red");
        tel.after('<p id="errortel" style="color:red;">Inserire un numero di telefono valido</p>');
      }else{
        tel.css("border-color","black"); 
        $("#errortel").remove(); 

      }
      if(check2==0){  
        let check= prompt();
       if(check == 'Dipendente'){
           $("#check_reg").val('0');
           $("#form_reg ").submit();
           
       }else if(check == 'Admin'){
            $("#check_reg").val('1');
            $("#form_reg ").submit();
       }else{
           alert('Inserire il codice corretto');
       }
      
      }
    })
     

</script>