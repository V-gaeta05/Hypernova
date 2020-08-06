<?php 
require('db.php');
 if(isset($_GET['code'])){
    
      $code = $_GET['code'];
      $query= "SELECT * FROM `hy_fatture` WHERE `code`="."'".$code."'"."";
      $select = $conn->query($query)->fetch_array();

      if ($_GET['method'] == 'pagamento_riuscito') {
        $code = $_GET['code'];
        $name = $_GET['pagamento_da'];
        $now = date('y-m-d H:i:s');
        if ($_GET['stato'] == 'COMPLETED') {
          $sql = "UPDATE `hy_fatture` SET `stato_pagamento`= 1,`data_pagamento`= '$now' WHERE code = '$code'";

          if ($conn->query($sql) === TRUE ) {

          } else {
            die("Ahi ahi toppai!");
          }
        } else {
          die("Pagamento non riuscito.");
        }
      }
      $id_socio = $select['id_socio'];
      $sql = "SELECT Nome, Cognome FROM hy_soci WHERE id = $id_socio";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $nomeSocio = $row['Nome'].' '.$row['Cognome'];
        }
      }
 }
?>
<!doctype html>
<html lang="it">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
        <?php if ($_GET['method'] == 'pagamento_visual') { ?>
        <h3>Importo: <?php echo $select['valore']; ?></h3><br>
        <h3>Data Emissione: <?php echo $select['data_emissione']; ?></h3><br>
        <h3>Causale: <?php echo $select['causale']; ?></h3><br>
<?php     if ($select['stato_pagamento'] == 0) {?><div id="paypal-button-container"></div><?php 
          } else { ?>
            <h3>Data Pagamento Effettuato:</h3> <p><?php echo $select['data_pagamento'];?></p>
          <?php }

        } else if($_GET['method'] == 'pagamento_riuscito') { ?>
          
        <h1>Il pagamento risulta <?php echo $_GET['stato']; ?></h1>
        <p>Grazie mille <?php echo $name; ?> per il tuo pagamento.</p>
        
        <?php }?>
        
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
    src="https://www.paypal.com/sdk/js?client-id=AW2t8HdbPQ17rEBOimuBMQKKIei1xXIiR3cSEBDybdy0gdMksYx40KMtM1RO6WytiH8yYnhAxZRHlTb4
"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: <?php echo $select['valore']; ?>,
            currency: 'EUR'
          },
          description: '<?php echo $select['causale']; ?>'+'(Pagamento corrisposto a '+'<?php echo $nomeSocio; ?>'+')'
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.

        window.location = "pagamenti.php?code=<?php echo $code; ?>&method=pagamento_riuscito&pagamento_da="+details.payer.name.given_name+'&stato='+details.status;
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>
