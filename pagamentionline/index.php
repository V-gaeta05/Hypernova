
<?php
    require_once('config/config.php');
   
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
  <button onclick="vaiii()">Via</button>
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur sint dicta deleniti laborum vitae a sed nam ratione autem velit aut accusantium impedit corporis iure accusamus, nobis ut doloremque? Quam?
  <a href="C:\xampp\htdocs\Hypernova\pagamentionline/payment.php?method=external_payment&payment_code=1-2-20200826151755-4zXb">link</a>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>




<script type="text/javascript">
    function vaiii() {
        var id_coop = '1';
        var nome_coop = '1';
        var id_socio = '2';
        var cod_cliente_infinity = 'ID954';
        var nome = 'Francesco';
        var cognome = 'Dicandia';
        var cod_prestazione = '3433543';
        var importo = '15000';
        var email = 'dioclo@gmail.com';
        $.ajax({
            method: 'POST',
            url: 'action/action_input.php',
            data: 'id_coop='+id_coop+'&nome_coop='+nome_coop+'&id_socio='+id_socio+'&cod_cliente_infinity='+cod_cliente_infinity+'&nome='+nome+'&cognome='+cognome+'&cod_prestazione='+cod_prestazione+'&importo='+importo+'&email='+email,
            success: function(res) {
                console.log(res);
            }
        })
    }
</script>