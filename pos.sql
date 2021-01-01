-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 01. led 2021, 13:36
-- Verze serveru: 10.4.17-MariaDB
-- Verze PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `pos`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isSolved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `teams`
--

INSERT INTO `teams` (`id`, `code`, `name`, `isSolved`) VALUES
(2, 'MK4NJP69', 'Defalut test', 0),
(3, 'JJHAE5ESR63', 'Test', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `team`) VALUES
(1, 'Default', 'default@default.com', 'default', 2),
(2, 'test', 'test@test.cz', 'test', 2),
(3, 'TestSend', 'TestSend@TestSend.com', 'TestSend', 2);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
