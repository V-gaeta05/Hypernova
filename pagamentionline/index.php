<?php
    require_once('config/config.php');

    $db = new Db($conn);

    $sql = "SELECT * FROM cooperative";

    $result = $db->select($sql);
    
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
  </head>
  <body>
  <button onclick="showCrea()" class="btn btn-primary">Crea Fattura</button>
  <button onclick="showElimina()" class="btn btn-danger">Disattiva Fattura</button>
  <div id="insert_pay" style="display: none;">
    
    <div class="form-group">
      <label for="IDCOOP">Cooperativa:</label>
      <select id="IDCOOP" class="form-control">
      <?php foreach ($result as $row) {
        echo '<option value="'.$row['id_cooperativa'].'">'.$row['nome_cooperativa'].'</option>';
      }
      ?></select>
    </div>
    <div class="form-group">
      <label for="IDSOCIO">ID socio:</label>
      <input type="text" class="form-control" id="IDSOCIO" placeholder="ID socio">
    </div>
    <div class="form-group">
      <label for="CODINFINITY">Codice Cliente Infinity:</label>
      <input type="text" class="form-control" id="CODINFINITY" placeholder="Codice Cliente Infinity">
    </div>
    <div class="form-group">
      <label for="NSERIE">Numero Serie:</label>
      <input type="text" class="form-control" id="NSERIE" placeholder="Numero Serie">
    </div>
    <div class="form-group">
      <label for="NSOCIO">Nome Socio:</label>
      <input type="text" class="form-control" id="NSOCIO" placeholder="Nome Socio">
    </div>
    <div class="form-group">
      <label for="CSOCIO">Cognome Socio:</label>
      <input type="text" class="form-control" id="CSOCIO" placeholder="Cognome Socio">
    </div>
    <div class="form-group">
      <label for="IMPORTO">Importo:</label>
      <input type="number" class="form-control" id="IMPORTO" placeholder="0">
    </div>
    <div class="form-group">
      <label for="PRESTAZIONE">Scopo Prestazione:</label>
      <textarea class="form-control" rows="3" id="PRESTAZIONE" placeholder="Scopo Prestazione"></textarea>
    </div>
    <div class="form-group">
      <label for="CLIENTE">Cliente:</label>
      <input class="form-control" type="text" id="CLIENTE" placeholder="Cliente">
    </div>
    <div class="form-group">
      <label for="EMAIL">Email Cliente:</label>
      <input class="form-control" type="email" id="EMAIL" placeholder="esempio@prova.it">
    </div>
    <div class="form-group">
      <label for="STATUS">Status:</label>
      <input class="form-control" type="text" id="STATUS" placeholder="Status">
    </div>
    <div class="form-group">
      <label for="MESSAGGI">Messaggi:</label>
      <input class="form-control" type="text" id="MESSAGGI" placeholder="Messaggi">
    </div>
    <button class="btn btn-primary" onclick="crea()">Crea Pagamento</button>
  </div>
  <div id="delete_pay" style="display: none;">
    <div class="form-group">
      <label for="NUMERODELETE">Numero Serie:</label>
      <input type="text" class="form-control" id="NUMERODELETE" placeholder="Numero Serie">
    </div>
    <button class="btn btn-danger" onclick="elimina()">Elimina Pagamento</button>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>




<script type="text/javascript">
    function showCrea() {
      $("#delete_pay").hide();
      $("#insert_pay").fadeIn();
    }
    function showElimina() {
      $("#insert_pay").hide();
      $("#delete_pay").fadeIn();
    }
    
    function crea() {
      var id_coop = $("#IDCOOP").val();
      var id_socio = $("#IDSOCIO").val();
      var cod_cliente_infinity = $("#CODINFINITY").val();
      var numero_serie = $("#NSERIE").val();
      var data_fattura = new Date();
      var nome_socio = $("#NSOCIO").val();
      var cognome_socio = $("#CSOCIO").val();
      var prestazione = $("#PRESTAZIONE").val();
      var importo = $("#IMPORTO").val();
      var cliente = $("#CLIENTE").val();
      var email = $("#EMAIL").val();
      var status = $("#STATUS").val();
      var messaggi = $("#MESSAGGI").val();

        var dati = {
          'id_coop' : id_coop,
          'id_socio' : id_socio,
          'cod_cliente_infinity' : cod_cliente_infinity,
          'numero_serie' : numero_serie,
          'data_fattura' : data_fattura,
          'nome_socio' : nome_socio,
          'cognome_socio' : cognome_socio,
          'prestazione' : prestazione,
          'importo' : importo,
          'cliente' : cliente,
          'Email' : email,
          'status' : status,
          'messaggi' : messaggi,
        }
        dati = JSON.stringify(dati);
        $.ajax({
            method: 'POST',
            url: 'action/action_input.php?action=insert',
            data: {mydata:dati},
            success: function(res) {
                console.log(res);
            }
        })
    }
    function elimina() {
      var numero_serie = $("#NUMERODELETE").val();
      var dati = {
        'numero_serie' : numero_serie,
      };
      dati = JSON.stringify(dati);
      $.ajax({
        method: 'POST',
        url: 'action/action_input.php?action=delete',
        data: {mydata:dati},
        success: function(res) {
          console.log(res);
        }
      })
    }
</script>