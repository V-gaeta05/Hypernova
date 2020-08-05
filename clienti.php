<?php
 include('session.php');
?>

<!doctype html>
<html lang="it">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <title>Hello, world!</title>
  </head>
  <body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
       
        <a href="index.php?logout" ><img class="modicon" src="https://img.icons8.com/wired/32/000000/safe-out.png"/>LogOut</a>
        
    </div>

    <!-- Use any element to open the sidenav -->
    <span id="hamburger" onclick="openNav()"><button  class="btn btn"><img src="https://img.icons8.com/ios-filled/35/000000/menu.png"/></button></span>
       
        
   
    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="main">
        <div class="container" style="text-align: center;">
            <form id="form_agg_cliente" action="query.php" method="POST">
                <label for="nome">Nome</label><br>
                <input type="text" name="nome" id="nome" placeholder="Nome"><br><br>
                <label for="pIva">Partita IVA</label><br>
                <input type="text" name="piva" id="pIva" placeholder="Partita IVA"><br><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" placeholder="Email"><br><br>
                <label for="tel">Telefono</label><br>
                <input type="tel" name="tel" id="tel" placeholder="Telefono"><br><br>
                <input type="hidden" name="check_agg_cliente">
                
            </form>
            <button id="btt_agg" class="btn btn-light">Aggiungi</button>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
  </body>
</html>

<script>

function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        
        
    }

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, 
and the background color of body to white */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0%";
        document.getElementById("main").style.marginLeft = "2%";
        
        
    }
    $("#btt_agg").click(function(){
        let email=$("#email");
        let piva= $("#pIva");
        let nome= $("#nome");
        let tel= $("#tel");
        let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        let renome= /^[A-Za-z]/;
        let retel= /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
        let check= 0;
        if(email.val().length<1){
            check += 1;
            $("#errormail1").remove();
            email.css("border-color","red");  
            email.after('<p id="errormail1" style="color:red;">Compilare il campo email</p>');
        }else{
            email.css("border-color","black");
            $("#errormail1").remove();
        } 
        if(!email.val().match(re)){
            check += 1;
            $("#errormail2").remove();
            email.css("border-color","red");  
            email.after('<p id="errormail2" style="color:red;">Inserire una mail valida</p>');
        } else{
            email.css("border-color","black");
            $("#errormail2").remove();
        }
        if(piva.val().lenght <11 || piva.val().lenght >11 ){
            check += 1;
            $("#errorpiva").remove();
            piva.css("border-color","red");
            piva.after('<p id="errorpiva" style="color:red;">Compilare correttamente la partita iva</p>');

        }else{
            piva.css("border-color","black");
            $("#errorpiva").remove();
        } 
        if(!tel.val().match(retel)){
            check += 1;
            $("#errortel").remove();
            tel.css("border-color","red");
            tel.after('<p id="errortel" style="color:red;">Inserire un numero di telefono valido</p>');
        }else{
            tel.css("border-color","black"); 
            $("#errortel").remove(); 

        }
        if(nome.val().length<1){
            check += 1;
            $("#errorname1").remove();
            nome.css("border-color","red");  
            nome.after('<p id="errorname1" style="color:red;">Compilare il campo nome</p>');
        }else{
            nome.css("border-color","black");  
            $("#errorname1").remove();
        }
        if(!nome.val().match(renome)){
            check += 1;
            $("#errorname2").remove();
            nome.css("border-color","red");  
            nome.after('<p id="errorname2" style="color:red;">Sono consentite solo le lettere nel nome</p>');
        }else{
            nome.css("border-color","black");  
            $("#errorname2").remove();
        }
        if(check==0){  
            $("#form_agg_cliente").submit();
      
      }
    })
</script>