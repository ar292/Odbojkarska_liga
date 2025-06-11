-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: sql210.infinityfree.com
-- Čas nastanka: 11. jun 2025 ob 08.00
-- Različica strežnika: 10.6.19-MariaDB
-- Različica PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `if0_39117122_odbojkarskaliga`
--

-- --------------------------------------------------------

--
-- Struktura tabele `city`
--

CREATE TABLE `city` (
  `id_ci` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `clubs`
--

CREATE TABLE `clubs` (
  `id_c` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_establishent` date NOT NULL,
  `owner` varchar(100) NOT NULL,
  `id_ci` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `clubs`
--

INSERT INTO `clubs` (`id_c`, `name`, `date_of_establishent`, `owner`, `id_ci`, `image`) VALUES
(15, 'ACH Volley Ljubljana', '1946-01-01', 'Privatni lastniki', NULL, 'ach.jfif'),
(16, 'Lube Civitanova', '1990-03-06', 'Lube Banca Marche', NULL, 'Lube Civitanova.jpg'),
(17, 'Sir Safety Susa Perugia', '2000-04-02', 'Sir Safety', NULL, 'Sir Safety Susa Perugia.png'),
(18, 'Trentino Volley', '2000-12-03', 'Trentino S.p.A.', NULL, 'assasasa.png'),
(19, 'Ziraat BankasÄ± Ankara', '2018-05-09', 'Ziraat BankasÄ±', NULL, 'Ziraat BankasÄ± Ankara.png'),
(20, 'Zenit Kazan', '2000-12-02', 'Tatneft ', NULL, 'Zenit Kazan.png');

-- --------------------------------------------------------

--
-- Struktura tabele `comments`
--

CREATE TABLE `comments` (
  `id_com` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_of_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_u` int(11) DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `comments`
--

INSERT INTO `comments` (`id_com`, `content`, `date_of_creation`, `id_u`, `id_p`) VALUES
(16, 'OdliÄen igralec in zelo zanesljiv kapetan', '2025-06-10 20:01:49', 14, 27),
(17, 'ðŸ‘', '2025-06-10 20:28:58', 18, 21),
(18, 'âŒâŒâŒ', '2025-06-10 20:29:34', 18, 23),
(19, 'SLAB KO KURAC', '2025-06-11 10:30:42', 21, 26);

-- --------------------------------------------------------

--
-- Struktura tabele `players`
--

CREATE TABLE `players` (
  `id_pl` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(20) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `max_spike_reach` int(11) DEFAULT NULL,
  `max_block_reach` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `id_ci` int(11) DEFAULT NULL,
  `id_c` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `players`
--

INSERT INTO `players` (`id_pl`, `name`, `position`, `height`, `max_spike_reach`, `max_block_reach`, `weight`, `image`, `id_ci`, `id_c`) VALUES
(21, 'Jan Kozamernik', 'Srednji bloker', 203, 345, 330, 92, 'kozamernik.jpg', NULL, 15),
(22, 'Nikola Gjorgiev', 'Sprejemalec', 197, 350, 335, 88, 'Nikola Gjorgiev.jpg', NULL, 15),
(23, 'Osmany Juantorena', 'Korektor', 199, 375, 360, 98, 'Osmany Juantorena.jpg', NULL, 16),
(24, 'Robertlandy SimÃ³n', 'Srednji bloker', 208, 375, 360, 98, 'Robertlandy SimÃ³n.jpg', NULL, 16),
(25, 'Wilfredo LeÃ³n', 'Sprejemalec', 203, 380, 360, 95, 'Wilfredo LeÃ³n.jpg', NULL, 17),
(26, 'Sebastian SolÃ©', 'Srednji bloker', 202, 355, 340, 89, 'Sebastian SolÃ©.jfif', NULL, 17),
(27, 'Alessandro Michieletto', 'Sprejemalec', 211, 355, 340, 90, 'Alessandro Michieletto.jfif', NULL, 18),
(28, 'Marko PodraÅ¡Äanin', 'Srednji bloker', 204, 360, 345, 94, 'Marko PodraÅ¡Äanin.jfif', NULL, 18),
(29, 'Adis LagumdÅ¾ija', 'Korektor', 207, 365, 345, 97, 'Adis LagumdÅ¾ija.jfif', NULL, 19),
(30, 'Arslan EkÅŸi ', 'Podajalec', 198, 330, 315, 86, 'Arslan EkÅŸi.jpg', NULL, 19),
(31, 'Maxim Mikhaylov', 'Korektor', 202, 360, 340, 103, 'Maxim Mikhaylov.png', NULL, 20),
(32, 'Artem Volvich', 'Srednji bloker', 208, 350, 335, 96, 'Artem Volvich.jfif', NULL, 20);

-- --------------------------------------------------------

--
-- Struktura tabele `rating`
--

CREATE TABLE `rating` (
  `id_r` int(11) NOT NULL,
  `value` int(5) DEFAULT NULL,
  `id_u` int(11) DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `rating`
--

INSERT INTO `rating` (`id_r`, `value`, `id_u`, `id_p`) VALUES
(13, 5, 14, 27),
(14, 5, 18, 21),
(15, 1, 18, 23),
(16, 4, 21, 26);

-- --------------------------------------------------------

--
-- Struktura tabele `stats`
--

CREATE TABLE `stats` (
  `id_s` int(11) NOT NULL,
  `aces` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `passing_errors` int(11) DEFAULT NULL,
  `hitting_errors` int(11) DEFAULT NULL,
  `assists` int(11) DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `stats`
--

INSERT INTO `stats` (`id_s`, `aces`, `points`, `passing_errors`, `hitting_errors`, `assists`, `id_p`) VALUES
(5, 232, 4344, 1233, 1233, NULL, 21),
(6, 213, 3123, 324, 412, NULL, 29),
(7, 453, 5354, 334, 534, NULL, 27),
(8, 234, 4234, 233, 432, NULL, 30),
(9, 234, 3553, 233, 523, NULL, 32),
(10, 456, 6757, 678, 665, NULL, 28),
(11, 525, 5325, 512, 577, NULL, 31),
(12, 234, 3255, 454, 755, NULL, 22),
(13, 352, 5745, 454, 878, NULL, 23),
(14, 657, 5675, 677, 889, NULL, 24),
(15, 565, 7775, 576, 987, NULL, 26),
(16, 1023, 8798, 976, 1536, NULL, 25);

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `id_u` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `u_type_id` int(11) DEFAULT NULL,
  `id_ci` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`id_u`, `username`, `email`, `password`, `u_type_id`, `id_ci`) VALUES
(3, 'Amar', 'redzicamar8@gmail.com', '$2y$10$s2462LtP/IPf1esjrcvY6OefRyv36.7k7tWUnBHAjzrEfGIZwMBku', 1, NULL),
(4, 'aamar.017', 'amar.rre208@gmail.com', '$2y$10$ghTCfiIakJKT31.aazKWoetvqZHOzETPUoHMunmkdUXhbHfkH9saG', 1, NULL),
(5, 'licht.boy', 'redzicamar8@gmail.com', '$2y$10$dwlbValElDekotNHEUg1SONdGhzEMHArh/fWcmVfZr.ddzth34AFa', 1, NULL),
(6, 'ar', 'amar.redzic007@gmail.com', '$2y$10$fzGYTPBzHNqN8jtR5FqxwuS76hUj/EdX89TQboQXs2xnqKFt6ILUO', 2, NULL),
(7, 'ae', 'amar.redzic@scv.si', '$2y$10$1fw8WdDqsKDyex/4KurBuuXHiCjCZD5yXUUiyrBlY/qlWj.R/W6vu', 2, NULL),
(9, 'b', 'redzicamar8@gmail.com', '$2y$10$wzAnldjU58gmmI4D7E4qeOCrSr47Cke.4kpawSXwm40rqyyOxwc5y', 2, NULL),
(10, 'asc', 'redzicamar8@gmail.com', '$2y$10$VGKJEXDuSKBZHLS22s1VF.8rmNwyaXQ4UcdwyEFVzKRsVf6rlL6ae', 2, NULL),
(11, 'c', 'redzicamar8@gmail.com', '$2y$10$cWQJwkPpD.ua2PeS8/j7JurviWiHc9S2GUDmEr0yU2Fgd6eL2LinS', 2, NULL),
(12, 'o', 'redzicamar8@gmail.com', '$2y$10$KwJ9wQAwQ6sN8LYxis.GDesPHiKE3JVyq5xCeVPwU1s2980vI3r4m', 2, NULL),
(13, 'axy', 'redzicamar8@gmail.com', '$2y$10$GhlwDyikkLGN0Vf//rLIXOjDmHPcfm6.m/mfPstwFl5l4xBOZ8XDa', 2, NULL),
(14, 'ax', 'amar.redzic@scv.si', '$2y$10$Z8WtAYsob4wfSlb4wmgbE.4e6NP5uNfdXNU8G8DTo5n2NP/BSo/Ri', 2, NULL),
(15, 'm.zevnik', 'miran.zevnik@scv.si', '$2y$10$2dM7RsC2pl8qaJNwuA/uYeorhnt1m89l3w5DUaLhWVZkYh3R58y0i', 1, NULL),
(16, 'M', 'redzicsmajil7@gmail.com', '$2y$10$Y2E5aaXZSvlxAuA.lPHvce54Anac7x1zFFSe3sAPufVhYD3BLwMjm', 2, NULL),
(17, 'mark ', 'mark.hrastnik@gmail.com', '$2y$10$mO4XLEdzExjJtufhA7.LauE1Eb07cU5GBlUFeoAL4fqng27A1t06G', 2, NULL),
(18, 'blaz', 'boskicpodrzavnikblaz@gmail.com', '$2y$10$SmxQJNU.rTeqqenhiejq9ujmvo5ZBwwBIQMXlH.hoqADCTJtS.hpu', 2, NULL),
(19, '123', '123@gmail.com', '$2y$10$RRvVS5EK4We44q9Eb1nxzOvFX7hIAp.ipaexnjzjeKc3A/JzQ.usG', 2, NULL),
(20, 'Martin', 'martin.tuk@scv.si', '$2y$10$s7dsAIeMCoD5JKaNZgIGW.vNFBindbkI8ZEjdguxzfR4zvtgjSpMm', 2, NULL),
(21, 'X', 'amar.redzic@scv.si', '$2y$10$1WOyl3XtudZqPGQjGwE3ReD8TzjIvgyR74mQwEW8c4IWAYvzUrzay', 2, NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `user_type`
--

CREATE TABLE `user_type` (
  `u_type_id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `rights` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Odloži podatke za tabelo `user_type`
--

INSERT INTO `user_type` (`u_type_id`, `role`, `rights`) VALUES
(1, 'admin', ''),
(2, 'user', '');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_ci`);

--
-- Indeksi tabele `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id_c`),
  ADD KEY `IX_Relationship7` (`id_ci`);

--
-- Indeksi tabele `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_com`),
  ADD KEY `IX_Relationship4` (`id_u`),
  ADD KEY `IX_Relationship12` (`id_p`);

--
-- Indeksi tabele `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id_pl`),
  ADD KEY `IX_Relationship8` (`id_ci`),
  ADD KEY `IX_Relationship10` (`id_c`);

--
-- Indeksi tabele `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_r`),
  ADD KEY `IX_Relationship5` (`id_u`),
  ADD KEY `IX_Relationship11` (`id_p`);

--
-- Indeksi tabele `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id_s`),
  ADD KEY `IX_Relationship6` (`id_p`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`),
  ADD KEY `IX_Relationship2` (`u_type_id`),
  ADD KEY `IX_Relationship9` (`id_ci`);

--
-- Indeksi tabele `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`u_type_id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `city`
--
ALTER TABLE `city`
  MODIFY `id_ci` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT tabele `comments`
--
ALTER TABLE `comments`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT tabele `players`
--
ALTER TABLE `players`
  MODIFY `id_pl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT tabele `rating`
--
ALTER TABLE `rating`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT tabele `stats`
--
ALTER TABLE `stats`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT tabele `user_type`
--
ALTER TABLE `user_type`
  MODIFY `u_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `clubs`
--
ALTER TABLE `clubs`
  ADD CONSTRAINT `Relationship7` FOREIGN KEY (`id_ci`) REFERENCES `city` (`id_ci`);

--
-- Omejitve za tabelo `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Relationship12` FOREIGN KEY (`id_p`) REFERENCES `players` (`id_pl`),
  ADD CONSTRAINT `Relationship4` FOREIGN KEY (`id_u`) REFERENCES `users` (`id_u`);

--
-- Omejitve za tabelo `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `Relationship10` FOREIGN KEY (`id_c`) REFERENCES `clubs` (`id_c`),
  ADD CONSTRAINT `Relationship8` FOREIGN KEY (`id_ci`) REFERENCES `city` (`id_ci`);

--
-- Omejitve za tabelo `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `Relationship11` FOREIGN KEY (`id_p`) REFERENCES `players` (`id_pl`),
  ADD CONSTRAINT `Relationship5` FOREIGN KEY (`id_u`) REFERENCES `users` (`id_u`);

--
-- Omejitve za tabelo `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `Relationship6` FOREIGN KEY (`id_p`) REFERENCES `players` (`id_pl`);

--
-- Omejitve za tabelo `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Relationship2` FOREIGN KEY (`u_type_id`) REFERENCES `user_type` (`u_type_id`),
  ADD CONSTRAINT `Relationship9` FOREIGN KEY (`id_ci`) REFERENCES `city` (`id_ci`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
