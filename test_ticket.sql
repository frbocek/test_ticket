-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Ned 19. srp 2018, 12:13
-- Verze serveru: 5.7.23-0ubuntu0.16.04.1
-- Verze PHP: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `test_ticket`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `acl`
--

CREATE TABLE `acl` (
  `id` int(11) NOT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `resource` int(11) NOT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user_admin_village`
--

CREATE TABLE `user_admin_village` (
  `id` int(11) NOT NULL,
  `user_admin_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `village`
--

CREATE TABLE `village` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `village`
--

INSERT INTO `village` (`id`, `name`) VALUES
(1, 'Praha'),
(2, 'Brno');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `acl`
--
ALTER TABLE `acl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BC806D1284A66610` (`user_admin_id`);

--
-- Klíče pro tabulku `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `user_admin_village`
--
ALTER TABLE `user_admin_village`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64DE50735E0D5582` (`village_id`),
  ADD KEY `IDX_64DE507384A66610` (`user_admin_id`);

--
-- Klíče pro tabulku `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `village`
--
ALTER TABLE `village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `acl`
--
ALTER TABLE `acl`
  ADD CONSTRAINT `FK_BC806D1284A66610` FOREIGN KEY (`user_admin_id`) REFERENCES `user_admin` (`id`);

--
-- Omezení pro tabulku `user_admin_village`
--
ALTER TABLE `user_admin_village`
  ADD CONSTRAINT `FK_64DE50735E0D5582` FOREIGN KEY (`village_id`) REFERENCES `village` (`id`),
  ADD CONSTRAINT `FK_64DE507384A66610` FOREIGN KEY (`user_admin_id`) REFERENCES `user_admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
