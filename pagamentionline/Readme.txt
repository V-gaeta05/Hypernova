----- API PAGAMENTI : DOCUMENTAZIONE -----

1 - Variabili in ingresso:
    - id_coop [INT 11] (required)
    - id_socio [INT 11] (required)
    - cod_cliente_infinity [VARCHAR 255] (required)
    - numero_serie [VARCHAR 255] (required)
    - data_fattura [DATETIME 'Y-m-d H:i:s] (required)
    - nome_socio [VARCHAR 255] (required)
    - cognome_socio [VARCHAR 255] (required)
    - prestazione [TEXT 500] (required)
    - importo [FLOAT] (required)
    - cliente [VARCHAR 255] (required)
    - status [VARCHAR 255]
    - messaggi [VARCHAR 255]
    - Email [VARCHAR 255] (required)

Accetta variabili di tipo POST codificate in JSON con chiave ['mydata']. 
Il collegamento avviene sul file /action/action_input.php?action=insert.

Nel caso si volesse disattivare il pagamento occorre inviare una chiamata POST codificata in JSON con chiave mydata con numero_serie 
della fattura in questione al file /action/action_input.php?action=delete

2 - Dati in uscita:

    Array multidimensionale di errori. Segue il modello:

        $error = [
            'success' => 1,
            'error' => [
                'id_coop' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'id_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cod_cliente_infinity' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'numero_serie' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'data_fattura' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'nome_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cognome_socio' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'prestazione' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'importo' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'cliente' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'status' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'messaggi' => [
                    'value' => 1,
                    'typeError' => '',
                ],
                'Email' => [
                    'value' => 1,
                    'typeError' => '',
                ],
            ],
        ];

    Se il valore del success è settato a 1 non sono presenti errori e verrà ricevuto solo il success. Se il valore del success è uguale a 0, 
    almeno un campo è errato e comparirà il tipo di errore nel typeError (string). Gli indici corretti non verranno mostrati nell'array. 

    Al momento del pagamento effettuato viene inviato un array json del tipo:

            var dati = {
                    'id_coop' : '',
                    'numero_serie' : '',
                    'data_fattura' : "",
                    'cod_cliente_infinity' : "",
                    'status_paypal' : 'COMPLETED',
            }
    .
    
    Nel caso si sia richiesta la disattivazione di una fattura si riceverà in risposta un json con un valore 1 in caso di successo o 0 in
    caso di errore.