<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
function sendData(){
    $.ajax({
        url: '',
        method: 'POST',
        data:'stato='+<?php echo $_GET['stato']; ?>,
        success: function(res){

        } 
    })
}
</script>



<?php 

require_once('../config/config.php');

if( isset($_GET['method']) && $_GET['method'] == 'pagamento_riuscito' ){
    
    $code = $_GET['code'];
    $date = new DateTime();

    $db = new Db($conn);
    
    $sql="UPDATE pagamenti SET stato_pagamento=1, data_pagamento=$data  WHERE cod_pagamento=$code";
    $result = $db->update($sql);

    if($result == 1){
        echo(json_encode($_GET['stato']));
?>
    <script> sendData();</script>
<?php
    }


}else{
    die();
}

?>
