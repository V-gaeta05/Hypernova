<?php

    require_once('config/config.php');
    if( isset($_GET)&&!empty($_GET) ) {
        if ($_GET['method'] == 'internal_payment') {

        } else if ($_GET['method'] == 'external_payment') {
            $db = new Db($conn);
            $code = $_GET['code'];

            $sql = "SELECT * FROM pagamenti WHERE cod_pagamento = '$code'";

            $result = $db->select($sql)->fetch_array();

            $data = new DateTime($result['data_emissione']);
            $data_emissione = $data->format("d-m-Y H:i:s");
            $data = new DateTime($result['data_pagamento']);
            $data_pagamento = ($result['data_pagamento'] == '') ? '' : $data->format("d-m-Y H:i:s");

            $id_coop = $result['id_coop'];
            $sql = "SELECT * FROM cooperative WHERE id_cooperativa = '$id_coop'";

            $result2 = $db->select($sql)->fetch_array();

            

        }
    

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Pagamenti</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <?php
        if ($_GET['method'] == 'external_payment') { ?>
        <div class="m-4">
            <table class="table">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th scope="col" colspan="3">Pagamento</th>
                        
                    </tr>
                    
                </thead>
                <tbody>
                    <tr class="bg-warning">
                        <th scope="col">Codice Pagamento</th>
                        <th scope="col">Importo</th>
                        <th scope="col">Cooperativa</th>
                    </tr>
                    <tr class="bg-light">
                        <th scope="row"><?php echo $result['cod_prestazione'];?></th>
                        <td><?php echo $result['importo'];?> €</td>
                        <td><?php echo $result['nome_coop'];?></td>
                    </tr>
                    <tr class="bg-warning">
                        <th scope="col">Socio</th>
                        <th scope="col">Causale</th>
                        <th scope="col">Messaggio</th>
                    </tr>
                    <tr class="bg-light">
                        <td><?php echo $result['nome'].' '.$result['cognome'];?></td>
                        <td><?php echo $result['prestazione'];?></td>
                        <td><?php echo $result['messaggi'];?></td>
                    </tr>
                    <tr class="bg-warning">
                        <th scope="col">Data emissione</th>
                        <th scope="col">Data pagamento</th>
                        <th scope="col">Stato pagamento</th>
                    </tr>
                    <tr class="bg-light">
                        <td><?php echo $data_emissione;?></td>
                        <td><?php echo $data_pagamento;?></td>
                        <td><?php $is_payed = ($result['stato_pagamento'] == 1) ? '<p class="text-success">Pagato</p>' : '<p class="text-danger">Non Pagato</p>'; echo $is_payed;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php if ( $result['stato_pagamento'] == 0 ) {

        ?>

            <div class='text-center'><div id="paypal-button-container"></div><div>
        <?php 
                }  
        
            } else if ( $_GET['method'] == 'pagamento_riuscito'){ ?>
            <span class="text-center"><h1 class="bg-success text-white"> Grazie <?php echo $_GET['pagamento_da']; ?> per aver effettuato il pagamento </h1></span>
        <?php } ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $result2['client_id'];?>&currency=EUR"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<script>
    function sendData(res){
        /*$.ajax({
            url: '',
            method: 'POST',
            data:'stato='+res,
            success: function(res){
                console.log(res);
                
                
            } 
        });*/
    }
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $result['importo']; ?>,
            currency: 'EUR'
          },
          description: '<?php echo $result['prestazione'].' Codice prestazione: '.$result['cod_prestazione'].' '; ?>'+'(Pagamento corrisposto a '+'<?php echo $result['nome'].' '.$result['cognome'].'('.$result['id_socio'].')'; ?>'+') ('+'<?php echo $result['cod_cliente_infinity']; ?>'+')'
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.
        $.ajax({
            url: "action/action_output.php?code=<?php echo $code; ?>&method=pagamento_riuscito&stato="+details.status,
            success: function(res){
                res = JSON.parse(res);
                if (res == 'COMPLETED'){
                    sendData(res);
                    window.location = "payment.php?code=<?php echo $code; ?>&method=pagamento_riuscito&pagamento_da="+details.payer.name.given_name+"&stato="+details.status;
                    
                }
            }

        });
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>

<?php

    }
?>