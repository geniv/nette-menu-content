-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Čtv 08. úno 2018, 18:09
-- Verze serveru: 10.1.26-MariaDB-0+deb9u1
-- Verze PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Struktura tabulky `prefix_mc_content`
--

CREATE TABLE `prefix_mc_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_rule_menu` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `position` bigint(20) UNSIGNED DEFAULT '0',
  `added` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='obsah';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_mc_content`
--
ALTER TABLE `prefix_mc_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_content_menu_idx` (`id_rule_menu`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_mc_content`
--
ALTER TABLE `prefix_mc_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_mc_content`
--
ALTER TABLE `prefix_mc_content`
  ADD CONSTRAINT `fk_content_menu` FOREIGN KEY (`id_rule_menu`) REFERENCES `hradejov_rule_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
