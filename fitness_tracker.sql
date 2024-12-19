-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 09:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `carico`
--

CREATE TABLE `carico` (
  `id_carico` int(11) NOT NULL,
  `id_scheda` int(11) NOT NULL,
  `id_esercizio` int(11) NOT NULL,
  `carico_iniziale` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carico`
--

INSERT INTO `carico` (`id_carico`, `id_scheda`, `id_esercizio`, `carico_iniziale`) VALUES
(1, 2, 3, 10),
(2, 2, 2, 30);

-- --------------------------------------------------------

--
-- Table structure for table `consigli`
--

CREATE TABLE `consigli` (
  `id_consigli` int(11) NOT NULL,
  `descrizione` text NOT NULL,
  `id_scheda` int(11) NOT NULL,
  `id_pt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consigli`
--

INSERT INTO `consigli` (`id_consigli`, `descrizione`, `id_scheda`, `id_pt`) VALUES
(1, 'Posizione di partenza:\r\n\r\nStai in piedi con i piedi alla larghezza delle spalle e le ginocchia leggermente flesse.\r\nTieni un manubrio in ciascuna mano, con i palmi rivolti verso il corpo (presa neutra) e le braccia distese lungo i fianchi.\r\nEsecuzione:\r\n\r\nFletti i gomiti, sollevando i manubri verso le spalle mentre ruoti i polsi fino a portare i palmi verso l\'alto (supinazione).\r\nMantieni i gomiti fermi e vicini al corpo durante tutto il movimento.\r\nRaggiunta la massima contrazione, contrai i bicipiti e mantieni la posizione per un momento.\r\nAbbassa lentamente i manubri, estendendo completamente le braccia e tornando alla posizione iniziale.\r\nRespirazione:\r\n\r\nInspira durante la fase di discesa (eccentrica).\r\nEspira durante la fase di salita (concentrica).', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `esercizi_descrizione`
--

CREATE TABLE `esercizi_descrizione` (
  `id_descrizione` int(11) NOT NULL,
  `nome_esercizio` text NOT NULL,
  `descrizione_esecuzione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `esercizi_descrizione`
--

INSERT INTO `esercizi_descrizione` (`id_descrizione`, `nome_esercizio`, `descrizione_esecuzione`) VALUES
(3, 'Pectoral machine', 'Seduti con il dorso alla macchina, la schiena ben aderente, afferrare le impugnature e addurre i gomiti davanti a se. La seduta deve essere regolata in modo tale che la linea immaginaria che passa per i gomiti sia parallela al suolo, e all\'altezza dei pettorali.'),
(4, 'Curl manubri', 'L\'esecuzione consiste nel flettere i gomiti e supinare ciascun avambraccio, avendo cura di non modificare la posizione del resto del corpo. Il movimento termina al massimo livello di flessione dei gomiti con gli avambracci in supinazione.');

-- --------------------------------------------------------

--
-- Table structure for table `esercizo`
--

CREATE TABLE `esercizo` (
  `id_esercizio` int(11) NOT NULL,
  `nome` text NOT NULL,
  `descrizione` text NOT NULL,
  `serie_predefinite` int(11) NOT NULL,
  `ripetizioni_predefinite` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_descrizionee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `esercizo`
--

INSERT INTO `esercizo` (`id_esercizio`, `nome`, `descrizione`, `serie_predefinite`, `ripetizioni_predefinite`, `id_tipo`, `id_descrizionee`) VALUES
(2, 'Pectoral machine', 'esercizio per il petto', 3, 14, 1, 3),
(3, 'Curl bilancere', 'Curl bilancere su panca a 45 gradi', 3, 12, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `personal_trainer`
--

CREATE TABLE `personal_trainer` (
  `id_pt` int(11) NOT NULL,
  `nome` varchar(127) NOT NULL,
  `cognome` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_trainer`
--

INSERT INTO `personal_trainer` (`id_pt`, `nome`, `cognome`) VALUES
(1, 'Ludovico', 'Mariani');

-- --------------------------------------------------------

--
-- Table structure for table `scheda`
--

CREATE TABLE `scheda` (
  `id_scheda` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `titolo` text NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheda`
--

INSERT INTO `scheda` (`id_scheda`, `id_utente`, `titolo`, `descrizione`) VALUES
(2, 1, 'Petto e braccia', 'Allenamenento ideale per petto e braccia');

-- --------------------------------------------------------

--
-- Table structure for table `storico_esercizi`
--

CREATE TABLE `storico_esercizi` (
  `id_storico` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_esercizio` int(11) NOT NULL,
  `id_scheda` int(11) NOT NULL,
  `data_esecuzione` date NOT NULL,
  `carico_utilizzato` float NOT NULL,
  `ripetizioni_eseguite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storico_esercizi`
--

INSERT INTO `storico_esercizi` (`id_storico`, `id_utente`, `id_esercizio`, `id_scheda`, `data_esecuzione`, `carico_utilizzato`, `ripetizioni_eseguite`) VALUES
(1, 1, 3, 2, '2024-12-19', 22, 14),
(2, 1, 2, 2, '2024-12-19', 15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_esercizio`
--

CREATE TABLE `tipo_esercizio` (
  `id_tipo` int(11) NOT NULL,
  `nome_tipo` text NOT NULL,
  `descrizione_tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_esercizio`
--

INSERT INTO `tipo_esercizio` (`id_tipo`, `nome_tipo`, `descrizione_tipo`) VALUES
(1, 'petto', 'Esercizi per il petto'),
(2, 'Braccia', 'Esercizi ideali per allenare le braccia');

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `Id_utente` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(127) NOT NULL,
  `premium` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`Id_utente`, `username`, `password`, `premium`) VALUES
(1, '88kevin88', 'password', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carico`
--
ALTER TABLE `carico`
  ADD PRIMARY KEY (`id_carico`),
  ADD KEY `carico-scheda` (`id_scheda`),
  ADD KEY `carico-esercizio` (`id_esercizio`);

--
-- Indexes for table `consigli`
--
ALTER TABLE `consigli`
  ADD PRIMARY KEY (`id_consigli`),
  ADD KEY `consigli-pt` (`id_pt`),
  ADD KEY `consigli-scheda` (`id_scheda`);

--
-- Indexes for table `esercizi_descrizione`
--
ALTER TABLE `esercizi_descrizione`
  ADD PRIMARY KEY (`id_descrizione`);

--
-- Indexes for table `esercizo`
--
ALTER TABLE `esercizo`
  ADD PRIMARY KEY (`id_esercizio`),
  ADD KEY `esercizio-tipo` (`id_tipo`),
  ADD KEY `esercizio-descrizione` (`id_descrizionee`);

--
-- Indexes for table `personal_trainer`
--
ALTER TABLE `personal_trainer`
  ADD PRIMARY KEY (`id_pt`);

--
-- Indexes for table `scheda`
--
ALTER TABLE `scheda`
  ADD PRIMARY KEY (`id_scheda`),
  ADD KEY `sheda-utente` (`id_utente`);

--
-- Indexes for table `storico_esercizi`
--
ALTER TABLE `storico_esercizi`
  ADD PRIMARY KEY (`id_storico`),
  ADD KEY `storico-utente` (`id_utente`),
  ADD KEY `storico-esercizio` (`id_esercizio`),
  ADD KEY `storico-scheda` (`id_scheda`);

--
-- Indexes for table `tipo_esercizio`
--
ALTER TABLE `tipo_esercizio`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Id_utente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carico`
--
ALTER TABLE `carico`
  MODIFY `id_carico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `consigli`
--
ALTER TABLE `consigli`
  MODIFY `id_consigli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `esercizi_descrizione`
--
ALTER TABLE `esercizi_descrizione`
  MODIFY `id_descrizione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `esercizo`
--
ALTER TABLE `esercizo`
  MODIFY `id_esercizio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_trainer`
--
ALTER TABLE `personal_trainer`
  MODIFY `id_pt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scheda`
--
ALTER TABLE `scheda`
  MODIFY `id_scheda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `storico_esercizi`
--
ALTER TABLE `storico_esercizi`
  MODIFY `id_storico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipo_esercizio`
--
ALTER TABLE `tipo_esercizio`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
  MODIFY `Id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carico`
--
ALTER TABLE `carico`
  ADD CONSTRAINT `carico-esercizio` FOREIGN KEY (`id_esercizio`) REFERENCES `esercizo` (`id_esercizio`),
  ADD CONSTRAINT `carico-scheda` FOREIGN KEY (`id_scheda`) REFERENCES `scheda` (`id_scheda`);

--
-- Constraints for table `consigli`
--
ALTER TABLE `consigli`
  ADD CONSTRAINT `consigli-pt` FOREIGN KEY (`id_pt`) REFERENCES `personal_trainer` (`id_pt`),
  ADD CONSTRAINT `consigli-scheda` FOREIGN KEY (`id_scheda`) REFERENCES `scheda` (`id_scheda`);

--
-- Constraints for table `esercizo`
--
ALTER TABLE `esercizo`
  ADD CONSTRAINT `esercizio-descrizione` FOREIGN KEY (`id_descrizionee`) REFERENCES `esercizi_descrizione` (`id_descrizione`),
  ADD CONSTRAINT `esercizio-tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_esercizio` (`id_tipo`);

--
-- Constraints for table `scheda`
--
ALTER TABLE `scheda`
  ADD CONSTRAINT `sheda-utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`Id_utente`);

--
-- Constraints for table `storico_esercizi`
--
ALTER TABLE `storico_esercizi`
  ADD CONSTRAINT `storico-esercizio` FOREIGN KEY (`id_esercizio`) REFERENCES `esercizo` (`id_esercizio`),
  ADD CONSTRAINT `storico-scheda` FOREIGN KEY (`id_scheda`) REFERENCES `scheda` (`id_scheda`),
  ADD CONSTRAINT `storico-utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`Id_utente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
