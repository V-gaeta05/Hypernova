<?php
    require_once("db.php");
    if (isset($_GET)) {
        if ($_GET['method'] == 'dettagli') {
            
            $code = $_GET['id'];

            $query = "SELECT * FROM hy_fatture WHERE code = '$code'";

            $result = $conn->query($query);

            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $id = $row['id'];
            $code = $row['code'];
            $id_socio = $row['id_socio'];
            $stato_pagamento = $row['stato_pagamento'];
            $data_emissione = $row['data_emissione'];
            $data_pagamento = $row['data_pagamento'];
            $valore = $row['valore'];
            $id_cliente = $row['id_cliente'];
        }


    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col" colspan="2">Informazioni Fattura</th>
                <th scope="col" colspan="2">Informazioni Soci</th>
                <th scope="col" colspan="2">Informazioni Cliente</th>
            </tr>
            <tr>
                <th scope="col">ID Fattura</th>
                <th scope="col">Codice univoco</th>
                <th scope="col">ID socio</th>
                <th scope="col">Nome Socio</th>
                <th scope="col">ID cliente</th>
                <th scope="col">Nome cliente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="col" ><?php echo $id; ?></td>
                <td scope="col"><?php echo $code; ?></td>
                <td scope="col" ><?php echo $id_socio; ?></td>
                <td scope="col" >NOME_SOCIO</td>
                <td scope="col" ><?php echo $id_cliente; ?></td>
                <td scope="col" >NOME_CLIENTE</td>
            </tr>
            <tr>
                <th scope="col">Data Emissione</th>
                <th scope="col">Data Pagamento</th>
            </tr>
            <tr>
                <td scope="col" ><?php echo $data_emissione; ?></td>
                <td scope="col"><?php echo $data_pagamento; ?></td>
            </tr>
            <tr>
                <th scope="col" colspan="2">Stato Pagamento</th>
            </tr>
            <tr>
                <td scope="col" colspan="2"><?php echo $stato_pagamento;?></td>
            </tr>
        </tbody>
    </table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>