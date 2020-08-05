<?php

    require_once("db.php");

    if (isset($_GET)) {
            
            if ($_GET['method'] == 'get_fatture') {
                $id = $_POST['id'];
                $data = [];
                $query = "SELECT * FROM hy_fatture WHERE id_socio = '$id'";

                $result = $conn->query($query);

                foreach($result as $row) {
                    $dateEm = new DateTime($row['data_emissione']);
                    $dateEm = $dateEm->format('d-m-y H:i:s');

                    if ($row['data_pagamento'] != '0000-00-00 00:00:00') {
                        $datePay = new DateTime($row['data_pagamento']);
                        $datePay = $datePay->format('d-m-y H:i:s');
                    } else {
                        $datePay = '';
                    }
                    $data[] = [
                        'id' => $row['id'],
                        'code' => $row['code'],
                        'causale' => $row['causale'],
                        'id_socio' => $row['id_socio'],
                        'stato_pagamento' => $row['stato_pagamento'],
                        'data_emissione' => $dateEm,
                        'data_pagamento' => $datePay,
                        'valore' => $row['valore'],
                        'id_cliente' => $row['id_cliente']
                    ];
                }
                echo json_encode($data);

                
            } else if ($_GET['method'] == 'set_fattura') {
                $id_socio = $_POST['id_socio'];
                $id_cliente = $_POST['id_cliente'];
                $code = $_POST['code'];
                $causale = $_POST['causale'];
                $valore = $_POST['valore'];

                $sql = "INSERT INTO `hy_fatture`(`code`, `causale`, `id_socio`,`valore`, `id_cliente`) VALUES ('$code','$causale','$id_socio','$valore','$id_cliente')";

                if ($conn->query($sql) === TRUE) {
                    echo "Nuova Fattura creata.";
                } else {
                    echo "Qualcosa non ha funzionato";
                }
            }

    }
    
?>