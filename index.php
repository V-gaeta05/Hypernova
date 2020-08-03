<?php

?>
<!doctype html>
<html lang="en">
  <head>
  <link rel="icon"  type="image/ico" href="#">
    <title> Prova</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="Pages/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </head>
  <body>

    <form>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="ddlEmail" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="ddlPassword" placeholder="Password">
    </div>
    
    <div class="form-group">
        <label for="exampleInputEmail1">Nome</label>
        <input type="text" class="form-control" id="ddlNome" aria-describedby="emailHelp" placeholder="Nome">
    </div>
    
    <div class="form-group">
        <label for="exampleInputEmail1">Cognome</label>
        <input type="text" class="form-control" id="ddlCognome" aria-describedby="emailHelp" placeholder="Cognome">
    </div>
    
    <div class="form-group">
        <label for="exampleInputEmail1">Data di Nascita</label>
        <input type="date" class="form-control" id="ddlDate" aria-describedby="emailHelp" placeholder="Data di nascita">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Numero di telefono</label>
        <input type="tel" class="form-control" id="ddlTelefono" placeholder="Numero di telefono">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Partita IVA</label>
        <input type="text" class="form-control" id="ddlPiva" aria-describedby="emailHelp" placeholder="Partita IVA">
    </div>
    
    <div class="form-group">
        <label for="exampleInputEmail1">Codice Fiscale</label>
        <input type="text" class="form-control" id="ddlCf" aria-describedby="emailHelp" placeholder="Codice Fiscale">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Azienda</label>
        <input type="text" class="form-control" id="ddlAzienda" aria-describedby="emailHelp" placeholder="Azienda">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="ddlAdmin">
        <label class="form-check-label" for="exampleCheck1">Check if Admin</label>
    </div>
    
    </form>
    <button onclick="sandData()" type="submit" class="btn btn-primary">Submit</button>


  </body>
</html>

<script type="text/javascript">
    function sandData(){
        var email = $("#ddlEmail").val();
        var password = $("#ddlPassword").val();
        var nome = $("#ddlNome").val();
        var cognome = $("#ddlCognome").val();
        var data = $("#ddlDate").val();
        var telefono = $("#ddlTelefono").val();
        var piva = $("#ddlPiva").val();
        var cf = $("#ddlCf").val();
        var azienda = $("#ddlAzienda").val();
        var chAdmin=0;
        if ($("#ddlAdmin").is(":checked")){
             chAdmin = 1;
        }
        $.ajax({
            type: "POST",
            url: "request.php",
            data: "email="+email+"&password="+password+"&nome="+nome+"&cognome="+cognome+"&data="+data+"&telefono="+telefono+"&piva="+piva+"&cf="+cf+"&azienda="+azienda+"&chadmin="+chAdmin,
            success: function(res) {
                console.log(res);
            },
            error: function() {
                alert("Ahi ahi");
            }
        })
    }
</script>