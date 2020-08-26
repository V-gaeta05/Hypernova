<?php

    class SandEmail {

    }

    class Payment {
        private $id_coop;
        private $nome_coop;
        private $id_socio;
        private $cod_cliente_infinity;
        private $nome;
        private $cognome;
        private $cod_prestazione;
        private $prestazione;
        private $importo;
        private $status;
        private $messaggi;

        function __construct($id_coop, $nome_coop, $id_socio, $cod_cliente_infinity, $nome, $cognome, $cod_prestazione, $prestazione, $importo, $status, $messaggi) {
            $this->id_coop = $id_coop;
            $this->nome_coop = $nome_coop;
            $this->id_socio = $id_socio;
            $this->cod_cliente_infinity = $cod_cliente_infinity;
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->cod_prestazione = $cod_prestazione;
            $this->prestazione = $prestazione;
            $this->importo = $importo;
            $this->status = $status;
            $this->messaggi = $messaggi;
        }

        public function dataEmissione() {
            $data = new DateTime();

            return $data->format('Y-m-d H:i:s');
        }

        public function creazioneCodicePagamento() {
            $codeFattura = '';
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charactersLength = strlen($characters);

            $codeFattura .= $this->id_coop.'-'.$this->id_socio.'-';
            $codeFattura .= date('YmdHis').'-';
            for ($i=0; $i<4; $i++) {
                $codeFattura .= $characters[rand(0, $charactersLength-1)];
            }
            return $codeFattura;
        }

        public function generateLink($codepayment) {

            $link = PROJECT_PATH.'/payment.php?method=external_payment&payment_code='.$codepayment;
            return $link;
        }

    }

    class Db {
        private $db;

        function __construct($db) {
            $this->db = $db;
        }

        public function insert($sql) {
            $result = $this->db->query($sql);
            if ($result) {
                $esito = [
                    'risultato' => 1,
                    'last_id'   => $this->db->insert_id,
                ];
            } else {
                $esito = [
                    'risultato' => 0,
                    'last_id'   => '',
                ];
            }
            return $esito;
        }

        public function select($sql) {
            $result = $this->db->query($sql);
            return $result;
        }

        public function update($sql) {
            $result = $this->db->query($sql);
            if($result) {
                $esito = 1;
            } else {
                $esito = 0;
            }
            return $esito;
        }
    }