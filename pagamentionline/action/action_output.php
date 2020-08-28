<?php 

require_once('../config/config.php');

if( isset($_GET['method']) && $_GET['method'] == 'pagamento_riuscito' ){
    
    $code = $_GET['code'];
    $date = new DateTime();

    $data = $date->format("Y-m-d H:i:s");
    $db = new Db($conn);
    
    $sql="UPDATE pagamenti SET stato_pagamento='1', data_pagamento= '$data'  WHERE cod_pagamento='$code'";
    $result = $db->update($sql);

    if($result == 1){
        echo json_encode($_GET['stato']);
    }

} else{
    die('Ciao mondo');
}
?>
