-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Úte 20. úno 2018, 18:45
-- Verze serveru: 10.1.26-MariaDB-0+deb9u1
-- Verze PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `netteweb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prefix_menu`
--

CREATE TABLE `prefix_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_locale` bigint(20) UNSIGNED DEFAULT NULL,
  `ident` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `position` bigint(20) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_menu`
--
ALTER TABLE `prefix_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_locale_idx` (`id_locale`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_menu`
--
ALTER TABLE `prefix_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_menu`
--
ALTER TABLE `prefix_menu`
  ADD CONSTRAINT `fk_menu_locale` FOREIGN KEY (`id_locale`) REFERENCES `prefix_locale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
