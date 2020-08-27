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
                        <td><?php echo $result['importo'];?></td>
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
                        <td><?php $is_payed = ($result['cod_prestazione'] == 1) ? '<p class="text-success">Pagato</p>' : '<p class="text-danger">Non Pagato</p>'; echo $is_payed;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
       <?php } ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

<?php

    }
?>