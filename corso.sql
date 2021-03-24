-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 24, 2021 alle 20:22
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corso`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `abilitazione`
--

CREATE TABLE `abilitazione` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `abilitazione`
--

INSERT INTO `abilitazione` (`id`, `nome`) VALUES
(1, 'SI'),
(2, 'NO');

-- --------------------------------------------------------

--
-- Struttura della tabella `altriprodotti`
--

CREATE TABLE `altriprodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `altriprodotti`
--

INSERT INTO `altriprodotti` (`id`, `nome`, `codice`, `prezzo`, `foto`) VALUES
(15, 'Tavolo in legno', 'TVLDD', '100.00', 'tavolo.jpg'),
(16, 'Sedia legno', 'SDLGN', '25.00', 'sedia.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_insert` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `data_insert`) VALUES
(1, 'Mouse', NULL, '2021-03-01 08:55:23'),
(2, 'Tastiere', NULL, '2021-03-01 08:55:23'),
(3, 'Monitor', NULL, '2021-03-01 08:55:35');

-- --------------------------------------------------------

--
-- Struttura della tabella `configurazione`
--

CREATE TABLE `configurazione` (
  `id` int(11) NOT NULL,
  `tabella` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `campo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `select_tabella` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `select_chiave` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `select_testo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `configurazione`
--

INSERT INTO `configurazione` (`id`, `tabella`, `campo`, `label`, `tipo`, `select_tabella`, `select_chiave`, `select_testo`) VALUES
(1, 'prodotti', 'id', '', 'hidden', NULL, NULL, NULL),
(2, 'prodotti', 'nome', '', 'text', NULL, NULL, NULL),
(3, 'prodotti', 'codice', '', 'text', NULL, NULL, NULL),
(4, 'prodotti', 'descrizione', '', 'textarea', NULL, NULL, NULL),
(5, 'prodotti', 'categorie_id', '', 'select', 'categorie', 'id', 'nome'),
(6, 'utenti', 'id', '', 'hidden', NULL, NULL, NULL),
(7, 'utenti', 'nome', 'Nome', 'text', NULL, NULL, NULL),
(8, 'utenti', 'cognome', 'Cognome', 'text', NULL, NULL, NULL),
(9, 'utenti', 'email', 'Email', 'email', NULL, NULL, NULL),
(10, 'utenti', 'pass', 'Password', 'password', NULL, NULL, NULL),
(11, 'utenti', 'tipologia_id', 'Tipologia', 'select', 'tipologia', 'id', 'nome'),
(12, 'utenti', 'via_indirizzo', 'Via/Viale/...', 'select', 'via_indirizzo', 'id', 'nome'),
(13, 'utenti', 'indirizzo', 'Indirizzo', 'text', NULL, NULL, NULL),
(14, 'utenti', 'numero_indirizzo', 'Numero civico', 'text', NULL, NULL, NULL),
(15, 'utenti', 'city', 'Citta\'', 'text', NULL, NULL, NULL),
(16, 'utenti', 'data_nascita', 'Data di nascita', 'date', NULL, NULL, NULL),
(17, 'utenti', 'sesso', 'Sesso', 'select', 'sesso', 'id', 'nome'),
(18, 'utenti', 'abilitazione', 'Sei abilitato/a?', 'select', 'abilitazione', 'id', 'nome'),
(19, 'utenti', 'foto', 'Carica la tua immagine', 'file', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `titolo_it` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `titolo_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `titolo_fr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `testo_it` text COLLATE utf8_unicode_ci NOT NULL,
  `testo_en` text COLLATE utf8_unicode_ci NOT NULL,
  `testo_fr` text COLLATE utf8_unicode_ci NOT NULL,
  `data_insert` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `news`
--

INSERT INTO `news` (`id`, `titolo_it`, `titolo_en`, `titolo_fr`, `testo_it`, `testo_en`, `testo_fr`, `data_insert`) VALUES
(1, 'Titolo news it', 'Titolo news eng', 'Titolo news fr', 'Testo it', 'Testo en', 'Testo fr', '2021-03-02');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci NOT NULL,
  `codice` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `disponibile` enum('SI','NO') COLLATE utf8_unicode_ci NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT current_timestamp(),
  `categorie_id` int(11) NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id`, `nome`, `descrizione`, `codice`, `prezzo`, `disponibile`, `data_insert`, `categorie_id`, `foto`) VALUES
(1, 'mouse', 'mouse ottico USB', 'AAFFB', '7.00', 'SI', '2021-02-24 09:44:25', 1, ''),
(5, 'Cuffie', 'Cuffie wireless di ultima generazione. Suono nitido', 'BGTRA', '20.00', 'SI', '2021-02-24 13:03:03', 0, ''),
(8, 'Penna USB', 'Penna USB da 16gb', 'GHKLF', '22.00', 'SI', '2021-02-25 11:11:18', 0, ''),
(9, 'Webcam 3.0', 'Webcam 2.0 HD', 'GHLYR', '35.00', 'NO', '2021-02-25 11:27:43', 0, ''),
(11, 'Monitor', 'Monitor wireless (PROMO mouse incluso)', 'LLGHJ', '30.00', 'NO', '2021-02-25 12:18:18', 3, ''),
(12, 'Monitor 24\'\'', 'Monitor di ultima generazine, 24 pollici', 'MTRGT', '35.00', 'SI', '2021-03-01 10:25:11', 3, ''),
(15, ' Monitor 24\'\' ', '', ' MTRG', '0.00', '', '2021-03-01 11:59:50', 0, ''),
(16, 'mouse', 'mouse ottico USB', 'AAFFB', '7.00', 'SI', '2021-03-03 09:35:58', 0, ''),
(17, 'Cuffie', 'Cuffie wireless di ultima generazione. Suono nitido', 'BGTRA', '20.00', 'SI', '2021-03-03 09:35:59', 0, ''),
(18, 'Penna USB', 'Penna USB da 16gb', 'GHKLF', '22.00', 'SI', '2021-03-03 09:35:59', 0, ''),
(19, 'Webcam 3.0', 'Webcam 2.0 HD', 'GHLYR', '35.00', 'NO', '2021-03-03 09:35:59', 0, ''),
(20, 'Tastiera', 'Tastiera wireless (PROMO mouse incluso)', 'LLGHJ', '30.00', 'NO', '2021-03-03 09:35:59', 0, ''),
(21, 'Monitor 24\'\'', 'Monitor di ultima generazine, 24 pollici', 'MTRGT', '35.00', 'SI', '2021-03-03 09:35:59', 0, ''),
(27, 'Switch usb', 'Descrizione prodotto', 'SWUSB', '23.00', 'SI', '2021-03-04 10:51:23', 0, 'maxresdefault.jpg'),
(31, 'Monitor', 'Monitor 22 pollici Full hd', 'MTRGR', '25.00', 'NO', '2021-03-05 01:32:54', 0, 'immagine.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `sesso`
--

CREATE TABLE `sesso` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `sesso`
--

INSERT INTO `sesso` (`id`, `nome`) VALUES
(1, 'M'),
(2, 'F'),
(3, 'N/A');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

CREATE TABLE `tipologia` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`id`, `nome`) VALUES
(1, 'Studente/essa'),
(2, 'Docente'),
(3, 'Coach'),
(4, 'Tutor');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `via_indirizzo` int(11) NOT NULL,
  `indirizzo` text COLLATE utf8_unicode_ci NOT NULL,
  `numero_indirizzo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascita` date NOT NULL,
  `sesso` int(11) NOT NULL,
  `abilitazione` int(11) NOT NULL,
  `data_insert` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipologia_id` int(11) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `via_indirizzo`, `indirizzo`, `numero_indirizzo`, `city`, `email`, `pass`, `data_nascita`, `sesso`, `abilitazione`, `data_insert`, `tipologia_id`, `foto`) VALUES
(118, 'Clifford', 'Smith', 1, 'Shaolin', '44', 'New York', 'methodman@gmail.com', '$2y$10$3xqSIIY6gI/f/Mg3P8i2m.N0Mou42Oetttz6FB0i0fp5u62mlXryq', '1971-03-02', 1, 1, '2021-03-05 12:42:10', 2, 'methodman.jpg'),
(119, 'Maccio', 'Capatonda', 1, 'della Disperazione', '17', 'Nah', 'maccio@yahoo.com', '$2y$10$MkquOFX1NeugYanbQcaz7.e/miJGAfohjzbzXIkLC/s.OVCJiZCjK', '1999-01-01', 1, 1, '2021-03-05 12:47:38', 1, 'maccio.jpg'),
(120, 'Federico', 'Sarti', 1, 'Ermete Zacconi', '1', 'Bologna', 'fedesarti@gmail.com', '$2y$10$E4EFiJRqxSV.S2LUMQV5lu2y3uo31YgNstU0pvXnzYtb5.24b45Vi', '1995-10-10', 1, 1, '2021-03-05 12:52:58', 1, 'nicodemus.jpg'),
(121, 'Carmela', 'Guida Aquilante', 1, 'Ermete Zacconi', '1', 'Bologna', 'melaniaguida@hotmail.it', '$2y$10$V8BwoE9IRnRAM5JjzOKivOesarynnZ6Idmqh77GaDWD6u5EhEC7WW', '1995-01-23', 2, 1, '2021-03-05 12:55:23', 1, 'wutangclan.jpg'),
(122, 'Giacomo Maria', 'Rossi', 3, 'Vittorio Emanuele', '71', 'Napoli', 'gmaria@yahoo.com', '$2y$10$9ttjTSprLLXwu.n3JArPWOFyw9BmoRL84FEDxz8G5/szrNFxXtrt6', '1987-05-14', 1, 2, '2021-03-05 12:57:09', 3, 'user.png'),
(123, 'Franca', 'Russo', 4, 'Miraglia', '7', 'Roma', 'frusso@gmail.com', '$2y$10$yB0bRnGYwHZ77pfyv9UAx.w5R0Q0JOPd9brTCTfgRJFWgiGGKw64u', '1970-06-15', 2, 1, '2021-03-05 12:59:22', 4, 'fotoprofilo.jpg'),
(124, 'Daria', 'Trottoli', 2, 'Masini', '87', 'Palermo', 'dtrottoli@hotmail.it', '$2y$10$e/UnvNYXaVCT0CmN5Ve8zeyhxefz4uH/V6k2sWy3IXC5dSKG.ia8S', '1956-07-04', 2, 2, '2021-03-05 13:00:40', 3, 'picture.jpg'),
(125, 'Giulia', 'Bianchi', 4, 'Savona', '7', 'Campobasso', 'gbianchi@hotmail.it', '$2y$10$7if6S51pi6LPrW9F4QwC2uCjp9Storwbxy8bwmYGmVMlYJbAnY/D.', '2000-11-05', 2, 2, '2021-03-05 13:04:04', 3, 'bookshop.jpg'),
(133, 'Pluto', 'Plutone', 1, 'Plutone', '15', 'Populonia', 'ppone@yahoo.com', '$2y$10$TEFdyZq6mY6u1zJRbkOeC.sx6i/OSqJJeupwZJDoo2MVQRZSzy.um', '1970-11-01', 3, 1, '2021-03-05 16:34:19', 4, '1304133.jpeg');

-- --------------------------------------------------------

--
-- Struttura della tabella `via_indirizzo`
--

CREATE TABLE `via_indirizzo` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `via_indirizzo`
--

INSERT INTO `via_indirizzo` (`id`, `nome`) VALUES
(1, 'via'),
(2, 'viale'),
(3, 'corso'),
(4, 'piazza'),
(5, '(altro)');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `abilitazione`
--
ALTER TABLE `abilitazione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `altriprodotti`
--
ALTER TABLE `altriprodotti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `configurazione`
--
ALTER TABLE `configurazione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sesso`
--
ALTER TABLE `sesso`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipologia`
--
ALTER TABLE `tipologia`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `via_indirizzo`
--
ALTER TABLE `via_indirizzo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `abilitazione`
--
ALTER TABLE `abilitazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `altriprodotti`
--
ALTER TABLE `altriprodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `configurazione`
--
ALTER TABLE `configurazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT per la tabella `sesso`
--
ALTER TABLE `sesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tipologia`
--
ALTER TABLE `tipologia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT per la tabella `via_indirizzo`
--
ALTER TABLE `via_indirizzo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
