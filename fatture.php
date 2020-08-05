<?php
    require_once("db.php");
    require_once("session.php");
    
    if (isset($_GET)&&(!empty($_GET))) {

        
        if ($_GET['method'] == 'dettagli') {

            // code for show element
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

        } else if($_GET['method'] == 'create') {
            // code for create element
            $id = $_SESSION['USER_ID'];
            $codeFattura = '';
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charactersLength = strlen($characters);

            $codeFattura .= '000'.$_SESSION['USER_ID'].'-';
            $codeFattura .= sha1(time()).'-';
            for ($i=0; $i<4; $i++) {
                $codeFattura .= $characters[rand(0, $charactersLength-1)];
            }

            $sql = "SELECT Id, Nome FROM hy_clienti WHERE id_socio = '$id' ORDER BY Nome";

            $query = $conn->query($sql);

        }


    } else {
        die("Wrong access method!");
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

<!-- HTML FOR SHOW ELEMENT -->
  <?php if ($_GET['method'] == 'dettagli') { ?>
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

<!-- HTML FOR SHOW CREATE FORM -->
  <?php } else if ($_GET['method'] == 'create') { ?>
    <form>
        <div id="form">
            <div class="form-group">
                <label for="codiceFattura">Codice Fattura</label>
                <input type="text" class="form-control" id="codiceFattura"  value="<?php echo $codeFattura; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="causaleFattura">Causale</label>
                <textarea class="form-control" id="causaleFattura" placeholder="Causale"></textarea>
            </div>
            <div class="form-group">
                <label for="valoreFattura">Valore Fattura</label>
                <input type="number" class="form-control" id="valoreFattura" min="1" step="any" placeholder="1">
            </div>
            <div class="form-group">
                <label for="clienteFattura">Cliente</label>
                <select id="clienteFattura" class="form-control">
                    <option selected value=""></option>
                    <?php
                    $option = '';
                    foreach ($query as $cliente) {
                        $option .= '<option value="'.$cliente['Id'].'">'.$cliente['Nome'].'</option>';
                    }
                    echo $option;
                    ?>
                </select>
            </div>
        </div>
    </form>
    <button type="submit" class="btn btn-primary" onclick="crea_fattura()">Submit</button>
  <?php } ?>
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

<script>
    function crea_fattura() {
        var id_socio = <?php echo $id;?>;
        var code = $("#codiceFattura").val();
        var causale = $("#causaleFattura").val();
        var valore = $("#valoreFattura").val();
        var id_utente = $("#clienteFattura").val();

        $.ajax({
            method: 'POST',
            url: 'request.php?method=set_fattura',
            data: 'id_socio='+id_socio+'&id_cliente='+id_utente+'&code='+code+'&causale='+causale+'&valore='+valore,
            success: function(res) {
                console.log(res);
            },
            error: function() {
                alert("Something going wrong");
            }
        })
    }
</script>