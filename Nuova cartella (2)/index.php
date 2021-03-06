<?php
  require_once("session.php");
  if (isset($_SESSION)) {
    $id = $_SESSION['USER_ID'];
  }
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
    <div id="mySidenav"  class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php">Home</a>
        <a href="clienti.php">Aggiungi Cliente</a>
        <a href="index.php?logout" ><img class="modicon" src="https://img.icons8.com/wired/32/000000/safe-out.png"/>LogOut</a>
        
    </div>

    <!-- Use any element to open the sidenav -->
    <span id="hamburger" style="position: fixed; z-index: 1; top: 0;overflow-x: hidden;" onclick="openNav()"><button  class="btn btn"><img src="https://img.icons8.com/ios-filled/35/000000/menu.png"/></button></span>
       
        
   
    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="main">
           
    

    <table class="table" id="main_table">
  <thead>
    <tr>
      <th scope="col">Codice Fattura</th>
      <th scope="col">Stato pagamento</th>
      <th scope="col">Data emissione</th>
      <th scope="col">Data pagamento</th>
      <th scope="col">Valore</th>
      <th scope="col">Cliente</th>
      <th scope="col">Dettagli</th>
    </tr>
  </thead>
  <tbody id="main_table_body">
    
  </tbody>
        </table>
  
  <button class="btn btn-light" id="createFatturaButton">Crea Nuova Fattura</button>
    </div>
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
  </body>
</html>

<script>
$(document).ready( function () {
    get_fatture();
   
} );
    function get_fatture() {
        var id = <?php echo $id; ?>;
        $.ajax({
            method: 'POST',
            url: 'request.php?method=get_fatture',
            data: 'id='+id,
            success: function(res) {
                var data = JSON.parse(res);
                create_table(data);
                $('#main_table').DataTable();
            },
            error: function() {
                alert('Something going wrong!');
            }
        })
    }

    function create_table(data) {
        if (data.length>0) {
            var table_body = '';
            var stato = '';
            
            for (i=0; i< data.length; i++) {
                if (data[i]['stato_pagamento'] ==  1) {
                  stato = '<p class="text-success">Pagato</p>';
                } else if(data[i]['stato_pagamento'] == 0) {
                  stato = '<p class="text-danger">Non pagato</p>';
                }
                var num = parseFloat(data[i]['valore']).toFixed(2);
                
                table_body += '<tr>'+
                            '<td scope="col">'+data[i]['code']+'</td>'+
                            '<td scope="col">'+stato+'</td>'+
                            '<td scope="col">'+data[i]['data_emissione']+'</td>'+
                            '<td scope="col">'+data[i]['data_pagamento']+'</td>'+
                            '<td scope="col">'+num+' €</td>'+
                            '<td scope="col">'+data[i]['id_cliente']+'</td>'+
                            '<td><a href="fatture.php?id='+data[i]['code']+'&method=dettagli">dettagli</a></td>'+
                            '</tr>';
            }
        }
        
        $('#main_table_body').html(table_body);
    }


    function openNav() {
        $("#hamburger").hide();
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        
        
    }

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, 
and the background color of body to white */
    function closeNav() {
        $("#hamburger").fadeIn('slow');
        document.getElementById("mySidenav").style.width = "0%";
        document.getElementById("main").style.marginLeft = "3%";
        
        
    }

    $('#createFatturaButton').click(function() {
        window.location = "fatture.php?method=create";
    });
</script>