-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 10, 2025 alle 20:49
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dreamcity`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Buildings`
--

CREATE TABLE `Buildings` (
  `id` int(11) NOT NULL,
  `Brole_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(15) NOT NULL,
  `width` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  `happiness` int(5) NOT NULL,
  `cost` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Buildings`
--

INSERT INTO `Buildings` (`id`, `Brole_id`, `name`, `color`, `width`, `height`, `happiness`, `cost`) VALUES
(1, 1, 'TOWNHALL', '#000000', 160, 160, 100, 0),
(2, 2, 'ROAD', '#7F7F7F', 75, 15, 1, 10),
(3, 2, 'ROUNDABOUT', '#AAAAAA', 80, 80, 2, 15),
(4, 3, 'FACTORY', '#FF6600', 340, 135, 25, 200),
(5, 6, 'HOUSE', '#FFFF00', 150, 60, 8, 50),
(6, 6, 'HUT', '#996600', 40, 40, 4, 20),
(7, 2, 'WATER', '#00BFFF', 30, 30, 1, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `Departments`
--

CREATE TABLE `Departments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Dmap_id` int(11) NOT NULL,
  `Drole_id` int(11) DEFAULT NULL,
  `budget` int(10) NOT NULL DEFAULT 10000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Departments`
--

INSERT INTO `Departments` (`id`, `user_id`, `Dmap_id`, `Drole_id`, `budget`) VALUES
(1, 1, 1, 1, 11048),
(2, 3, 1, 2, 10120),
(5, 4, 1, 6, 9950),
(12, 6, 1, 5, 11832),
(13, 5, 1, 3, 10000);

-- --------------------------------------------------------

--
-- Struttura della tabella `MapBuildings`
--

CREATE TABLE `MapBuildings` (
  `id` int(11) NOT NULL,
  `MBmap_id` int(11) NOT NULL,
  `MBbuilding_id` int(11) NOT NULL,
  `x_coordinate` int(11) NOT NULL,
  `y_coordinate` int(11) NOT NULL,
  `rotated` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `MapBuildings`
--

INSERT INTO `MapBuildings` (`id`, `MBmap_id`, `MBbuilding_id`, `x_coordinate`, `y_coordinate`, `rotated`) VALUES
(488, 1, 4, 271, 142, 'no'),
(489, 1, 4, 110, 322, 'no'),
(490, 1, 4, 619, 360, 'no'),
(669, 1, 1, 1211, 106, 'no'),
(680, 1, 5, 744, 85, 'no'),
(690, 1, 1, 81, 81, 'no');

-- --------------------------------------------------------

--
-- Struttura della tabella `MapClicks`
--

CREATE TABLE `MapClicks` (
  `id` int(11) NOT NULL,
  `Cmap_id` int(11) NOT NULL,
  `Cuser_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `MapClicks`
--

INSERT INTO `MapClicks` (`id`, `Cmap_id`, `Cuser_id`) VALUES
(19, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `Maps`
--

CREATE TABLE `Maps` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `happiness` int(10) NOT NULL,
  `citizens` int(11) NOT NULL DEFAULT 0,
  `lastLogin` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Maps`
--

INSERT INTO `Maps` (`id`, `name`, `description`, `image`, `happiness`, `citizens`, `lastLogin`) VALUES
(1, 'Mappa 1', 'Questa è la mappa 1', 'fff&text=1.png', 283, 8, '2025-01-10 20:48:59');

-- --------------------------------------------------------

--
-- Struttura della tabella `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `type` enum('Message','Invite','ChangeRole') NOT NULL DEFAULT 'Message',
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `Mmap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Messages`
--

INSERT INTO `Messages` (`id`, `title`, `content`, `type`, `sender_id`, `receiver_id`, `Mmap_id`) VALUES
(19, 'Messaggio', 'Questo è un messaggio da admin2. Verrà visualizzato solo da admin nella casella dei messaggi.', 'Message', 3, 1, 1),
(20, 'Invito', 'Questo è un invito da admin2 alla Mappa 1. Se admin si trova in una mappa diversa e accetta l invito, verrà reindirizzato alla Mappa 1. Verrà visualizzato solo da admin nella casella dei messaggi.', 'Invite', 3, 1, 1),
(23, 'Cambio Ruolo', 'Questo è un cambio ruolo da admin2 nella Mappa 1. admin2 ha il ruolo Gestione delle strade mentre admin ha il ruolo Riscossione delle tasse... i ruoli verranno invertiti. Se si accetta l invito, si viene inoltre reindirizzati alla mappa dell invito per vedere gli aggiornamenti. Verrà visualizzato solo da admin nella casella dei messaggi.', 'ChangeRole', 3, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Roles`
--

CREATE TABLE `Roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `department_desc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Roles`
--

INSERT INTO `Roles` (`id`, `name`, `department_desc`) VALUES
(1, 'Riscossione delle tasse e ripartizione degli introiti', 'Sarà l\'utente che riscuote le tasse e suddivide gli introiti ai vari ruoli'),
(2, 'Gestione delle strade', 'Sarà l\'utente che si occupa di costruire le strade, i fiumi e i laghi in tutta la mappa'),
(3, 'Attività commerciali', 'Sarà l\'utente che si occupa di costruire le attività commerciali'),
(4, 'Spettacoli', 'Sarà l\'utente che si occupa di costruire i musei, teatri e cinema'),
(5, 'Sport', 'Sarà l\'utente che si occupa di costruire i centri sportivi'),
(6, 'Edilizia', 'Sarà l\'utente che si occupa di costruire le case');

-- --------------------------------------------------------

--
-- Struttura della tabella `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`, `avatar`) VALUES
(1, 'admin', '$argon2i$v=19$m=65536,t=4,p=1$cTVHZmJzUGptR0N5TkNrTQ$Pp6mq9mHJN0jrK12RDb1lNuULC0mW2JxkPFcQXdTE60', '47a06d16744b3eb077ae731ab07839fb.png'),
(3, 'admin2', '$argon2i$v=19$m=65536,t=4,p=1$T2hxbVYyZjFZSDZVbjdZNQ$VEHrumb7o1JR+h0gy/cb0MpWCFhdahppwnyAXhlgit4', '537c930a990f7194758453527a966a45.png'),
(4, 'admin3', '$argon2i$v=19$m=65536,t=4,p=1$LjNMQks2N095VlBJek1FcA$2dxLI00+658XZ8mNoZkGK369D4QYvD01fbLfn5Ow5lE', 'admin3_1735152574.jpeg'),
(5, 'admin4', '$argon2i$v=19$m=65536,t=4,p=1$aFMxeU9ySVoxb0M2bkhBdQ$Q8s3uvs6BJ2BZPqmfDCvCgacHmAhPG/jy1YMOpNANQc', 'admin4_1735213690.jpg'),
(6, 'Endri', '$argon2i$v=19$m=65536,t=4,p=1$R09aSlE1TGh0dDJVaWk2TA$uSrVwnv4cdMUrJgAfubtXtyEFWqZjjVQdGxbIp/9pDA', 'Endri_1735378845.jpeg');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Buildings`
--
ALTER TABLE `Buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Brole_id_fk` (`Brole_id`);

--
-- Indici per le tabelle `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Dmap_id_fk` (`Dmap_id`),
  ADD KEY `Duser_id_fk` (`user_id`),
  ADD KEY `Drole_id_fk` (`Drole_id`);

--
-- Indici per le tabelle `MapBuildings`
--
ALTER TABLE `MapBuildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `MBbuilding_id_fk` (`MBbuilding_id`),
  ADD KEY `MBmap_id_fk` (`MBmap_id`);

--
-- Indici per le tabelle `MapClicks`
--
ALTER TABLE `MapClicks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Cmap_id` (`Cmap_id`,`Cuser_id`),
  ADD KEY `Cuser_id_fk` (`Cuser_id`);

--
-- Indici per le tabelle `Maps`
--
ALTER TABLE `Maps`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id_fk` (`sender_id`),
  ADD KEY `receiver_id_fk` (`receiver_id`),
  ADD KEY `Mmap_id_fk` (`Mmap_id`);

--
-- Indici per le tabelle `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_role` (`name`);

--
-- Indici per le tabelle `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Buildings`
--
ALTER TABLE `Buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `Departments`
--
ALTER TABLE `Departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `MapBuildings`
--
ALTER TABLE `MapBuildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=740;

--
-- AUTO_INCREMENT per la tabella `MapClicks`
--
ALTER TABLE `MapClicks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT per la tabella `Maps`
--
ALTER TABLE `Maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Buildings`
--
ALTER TABLE `Buildings`
  ADD CONSTRAINT `Brole_id_fk` FOREIGN KEY (`Brole_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Departments`
--
ALTER TABLE `Departments`
  ADD CONSTRAINT `Dmap_id_fk` FOREIGN KEY (`Dmap_id`) REFERENCES `Maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Drole_id_fk` FOREIGN KEY (`Drole_id`) REFERENCES `Roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Duser_id_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `MapBuildings`
--
ALTER TABLE `MapBuildings`
  ADD CONSTRAINT `MBbuilding_id_fk` FOREIGN KEY (`MBbuilding_id`) REFERENCES `Buildings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MBmap_id_fk` FOREIGN KEY (`MBmap_id`) REFERENCES `Maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `MapClicks`
--
ALTER TABLE `MapClicks`
  ADD CONSTRAINT `Cmap_id_fk` FOREIGN KEY (`Cmap_id`) REFERENCES `Maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Cuser_id_fk` FOREIGN KEY (`Cuser_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Mmap_id_fk` FOREIGN KEY (`Mmap_id`) REFERENCES `Maps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receiver_id_fk` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender_id_fk` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
