-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 02, 2020 alle 15:18
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hypernova_def`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cooperative`
--

CREATE TABLE `cooperative` (
  `id` int(11) NOT NULL,
  `id_cooperativa` int(11) NOT NULL,
  `nome_cooperativa` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `cooperative`
--

INSERT INTO `cooperative` (`id`, `id_cooperativa`, `nome_cooperativa`, `client_id`) VALUES
(2, 1, 'DocServizi', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(5, 4, 'DocEducational', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(7, 5, 'TestRilascio', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(8, 8, 'DocCreativity', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(9, 9, 'HyperNova', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(10, 10, 'TestPubblico', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(11, 13, 'DocLive', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(12, 14, 'STEA', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(13, 50, 'TestCreativity', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu'),
(14, 51, 'TestHypernova', 'AYt9x2siGV5sG19Mrvjnm4JtcZtUO2PJSelK0_ldCOqAyiXgevHopK3nspCUW1AYYzgt6ALx_l8Y3bRu');

-- --------------------------------------------------------

--
-- Struttura della tabella `pagamenti`
--

CREATE TABLE `pagamenti` (
  `id` int(11) NOT NULL,
  `id_coop` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `nome_socio` varchar(255) NOT NULL,
  `cognome_socio` varchar(255) NOT NULL,
  `cod_cliente_infinity` varchar(255) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `numero_serie` varchar(255) NOT NULL,
  `data_emissione` datetime NOT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `importo` float NOT NULL,
  `prestazione` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `messaggi` varchar(255) DEFAULT NULL,
  `cod_link` varchar(255) NOT NULL,
  `status_pagamento` tinyint(1) NOT NULL DEFAULT 0,
  `pagamento_attivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `pagamenti`
--

INSERT INTO `pagamenti` (`id`, `id_coop`, `id_socio`, `nome_socio`, `cognome_socio`, `cod_cliente_infinity`, `cliente`, `email_cliente`, `numero_serie`, `data_emissione`, `data_pagamento`, `importo`, `prestazione`, `status`, `messaggi`, `cod_link`, `status_pagamento`, `pagamento_attivo`) VALUES
(10, 1, 2, 'Francesco', 'Dicandia', 'ID954', 'Stefano Prato', 'dioclo@hotmail.it', '349438jhj9384', '2020-09-02 19:42:11', NULL, 3.12, 'Rifornimento carburante per tutta la azienda piu prestazioni varie ed eventuali su ogni tracciato del circuito', '', '', '1-2-20200902145154-u32Pah', 0, 0),
(11, 1, 2, 'Francesco', 'Dicandia', 'ID954', 'Stefano Prato', 'dioclo@hotmail.it', '349438jhj9384', '2020-09-02 19:42:11', NULL, 3.12, 'Rifornimento carburante per tutta la azienda piu prestazioni varie ed eventuali su ogni tracciato del circuito', '', '', '1-2-20200902151308-lvfKGO', 0, 0),
(12, 1, 2, 'Francesco', 'Dicandia', 'ID954', 'Stefano Prato', 'dioclo@hotmail.it', '349438jhj9384', '2020-09-02 19:42:11', '2020-09-02 15:16:10', 3.12, 'Rifornimento carburante per tutta la azienda piu prestazioni varie ed eventuali su ogni tracciato del circuito', '', '', '1-2-20200902151520-o16qcx', 1, 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cooperative`
--
ALTER TABLE `cooperative`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `pagamenti`
--
ALTER TABLE `pagamenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cooperative`
--
ALTER TABLE `cooperative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `pagamenti`
--
ALTER TABLE `pagamenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
