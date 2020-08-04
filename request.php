<?php

    require_once("db.php");

    if (isset($_GET)) {
            $data = [];
            if ($_GET['method'] == 'get_fatture') {

                $query = "SELECT * FROM hy_fatture ";

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
                        'id_socio' => $row['id_socio'],
                        'nome_cliente' => $row['nome_cliente'],
                        'stato_pagamento' => $row['stato_pagamento'],
                        'data_emissione' => $dateEm,
                        'data_pagamento' => $datePay,
                        'valore' => $row['valore'],
                        'id_cliente' => $row['id_cliente']
                    ];
                }
                echo json_encode($data);

                
            }

    }
    
?>