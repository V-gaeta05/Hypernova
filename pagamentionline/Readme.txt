----- API PAGAMENTI : DOCUMENTAZIONE -----

1 - Variabili in ingresso:
    - id_coop [INT 11] (required)
    - nome_coop [VARCHAR 255] (required)
    - id_socio [INT 11] (required)
    - cod_cliente_infinity [VARCHAR 255] (required)
    - nome [VARCHAR 255] (required)
    - cognome [VARCHAR 255] (required)
    - cod_prestazione [VARCHAR 255] (required)
    - prestazione [TEXT 500]
    - importo [FLOAT] (required)
    - status [VARCHAR 255]
    - messaggi [VARCHAR 255]
    - email [VARCHAR 255] (required)

Accetta variabili di tipo POST. Il collegamento avviene sul file /action/action_input.php.

2 - Dati in uscita:

    Array multidimensionale di errori. Segue il modello:

        $error = [
            'id_coop' => [
                'value' => 0,
                'typeError' => '',
            ],
            'nome_coop' => [
                'value' => 0,
                'typeError' => '',
            ],
            'id_socio' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cod_cliente_infinity' => [
                'value' => 0,
                'typeError' => '',
            ],
            'nome' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cognome' => [
                'value' => 0,
                'typeError' => '',
            ],
            'cod_prestazione' => [
                'value' => 0,
                'typeError' => '',
            ],
            'prestazione' => [
                'value' => 0,
                'typeError' => '',
            ],
            'importo' => [
                'value' => 0,
                'typeError' => '',
            ],
            'status' => [
                'value' => 0,
                'typeError' => '',
            ],
            'messaggi' => [
                'value' => 0,
                'typeError' => '',
            ],
            'email' => [
                'value' => 0,
                'typeError' => '',
            ],
        ];
        
    Se il value è settato a 0 non sono presenti errori. Se il value è uguale a 1, il campo è errato e comparirà il tipo di errore nel typeError (string).