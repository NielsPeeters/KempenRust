-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 09 mrt 2017 om 17:16
-- Serverversie: 5.6.28-0ubuntu0.15.04.1
-- PHP-versie: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `tmk1617_pro05`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `arrangement`
--

CREATE TABLE IF NOT EXISTS `arrangement` (
`id` int(11) NOT NULL,
  `naam` varchar(20) NOT NULL,
  `beginDag` varchar(10) DEFAULT NULL,
  `eindDag` varchar(10) DEFAULT NULL,
  `omschrijving` text NOT NULL,
  `isArrangement` tinyint(1) NOT NULL,
  `pensionId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `arrangement`
--

INSERT INTO `arrangement` (`id`, `naam`, `beginDag`, `eindDag`, `omschrijving`, `isArrangement`, `pensionId`) VALUES
(1, 'Kort weekend', 'zaterdag', 'zondag', 'Eén overnachting met ontbijt, één 4-gangenmenu  (zaterdagnamiddag tot zondagmorgen)', 1, NULL),
(2, 'Lang weekend', 'vrijdag', 'zondag', 'Twee overnachtingen met ontbijt, één  3-gangenmenu op vr, 1 viergangenmenu op za (vrijdagnamiddag tot zondagmorgen)', 1, NULL),
(3, 'Fietsweekend', 'vrijdag', 'zondag', 'Twee overnachtingen met ontbijt, één 4-gangenmenu, één 3-gangenmenu en twee lunchpakketten (vrijdagnamiddag tot zondagmorgen)', 1, NULL),
(4, 'Midweek', 'maandag', 'vrijdag', 'Vier overnachtingen met ontbijt, één 4-gangenmenu en drie 3-gangenmenu''s(van maandag tot vrijdag)', 1, NULL),
(5, 'Pension', NULL, NULL, 'Half- of volpension.', 0, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boeking`
--

CREATE TABLE IF NOT EXISTS `boeking` (
`id` int(11) NOT NULL,
  `persoonId` int(11) NOT NULL,
  `startDatum` date NOT NULL,
  `eindDatum` date NOT NULL,
  `arrangementId` int(11) DEFAULT NULL,
  `tijdstip` datetime NOT NULL,
  `goedgekeurd` tinyint(1) NOT NULL,
  `opmerking` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `boeking`
--

INSERT INTO `boeking` (`id`, `persoonId`, `startDatum`, `eindDatum`, `arrangementId`, `tijdstip`, `goedgekeurd`, `opmerking`) VALUES
(2, 2, '2017-03-20', '2017-03-22', 1, '2017-03-08 03:08:10', 1, 'Gluten allergie'),
(3, 4, '2017-04-21', '2017-03-13', 3, '2017-03-01 06:34:47', 0, NULL),
(4, 13, '2017-03-28', '2017-03-30', 5, '2017-03-03 17:22:33', 1, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boekingTypePersoon`
--

CREATE TABLE IF NOT EXISTS `boekingTypePersoon` (
`id` int(11) NOT NULL,
  `typePersoonId` int(11) NOT NULL,
  `boekingId` int(11) NOT NULL,
  `aantal` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `boekingTypePersoon`
--

INSERT INTO `boekingTypePersoon` (`id`, `typePersoonId`, `boekingId`, `aantal`) VALUES
(2, 1, 2, 2),
(3, 3, 2, 2),
(4, 3, 3, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `extra`
--

CREATE TABLE IF NOT EXISTS `extra` (
`id` int(11) NOT NULL,
  `faciliteitId` int(11) NOT NULL,
  `boekingId` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  `toegepastePrijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `extra`
--

INSERT INTO `extra` (`id`, `faciliteitId`, `boekingId`, `aantal`, `toegepastePrijs`) VALUES
(2, 1, 2, 2, 4.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faciliteit`
--

CREATE TABLE IF NOT EXISTS `faciliteit` (
`id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `prijs` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `faciliteit`
--

INSERT INTO `faciliteit` (`id`, `naam`, `prijs`) VALUES
(1, 'zwembad', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `factuur`
--

CREATE TABLE IF NOT EXISTS `factuur` (
`id` int(11) NOT NULL,
  `boekingId` int(11) NOT NULL,
  `betaald` tinyint(1) NOT NULL,
  `datumFactuur` datetime NOT NULL,
  `datumBetaling` datetime DEFAULT NULL,
  `voorschotBetaald` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `factuur`
--

INSERT INTO `factuur` (`id`, `boekingId`, `betaald`, `datumFactuur`, `datumBetaling`, `voorschotBetaald`) VALUES
(2, 4, 1, '2017-03-21 00:00:00', '2017-03-22 00:00:00', 0),
(3, 2, 0, '2017-03-19 00:00:00', NULL, 1),
(4, 3, 1, '2017-03-01 00:00:00', '2017-03-02 00:00:00', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kamer`
--

CREATE TABLE IF NOT EXISTS `kamer` (
`id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `aantalPersonen` int(10) unsigned NOT NULL,
  `kamerTypeId` int(11) DEFAULT NULL,
  `beschikbaar` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `kamer`
--

INSERT INTO `kamer` (`id`, `naam`, `aantalPersonen`, `kamerTypeId`, `beschikbaar`) VALUES
(1, 'Kamer 1', 2, 1, 1),
(2, 'Kamer 5', 5, 3, 1),
(3, 'Kamer 2', 2, 2, 1),
(4, 'Kamer 3', 1, 1, 1),
(5, 'Kamer 4', 2, 3, 1),
(6, 'Kamer 6', 7, 3, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kamerBoeking`
--

CREATE TABLE IF NOT EXISTS `kamerBoeking` (
`id` int(11) NOT NULL,
  `boekingId` int(11) NOT NULL,
  `kamerId` int(11) NOT NULL,
  `aantalMensen` int(10) unsigned NOT NULL,
  `staatVast` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `kamerBoeking`
--

INSERT INTO `kamerBoeking` (`id`, `boekingId`, `kamerId`, `aantalMensen`, `staatVast`) VALUES
(2, 3, 3, 2, 0),
(3, 2, 6, 1, 1),
(4, 3, 1, 5, 0),
(5, 2, 6, 3, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kamerType`
--

CREATE TABLE IF NOT EXISTS `kamerType` (
`id` int(11) NOT NULL,
  `omschrijving` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `kamerType`
--

INSERT INTO `kamerType` (`id`, `omschrijving`) VALUES
(1, 'zonder douche, wc'),
(2, 'douche, toilet en tv'),
(3, 'douche/bad, toilet en tv');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `naam` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `menu`
--

INSERT INTO `menu` (`id`, `naam`) VALUES
(1, '3 gangen'),
(2, '4 gangen'),
(3, 'ontbijt'),
(4, 'lunchpakket');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menuArrangement`
--

CREATE TABLE IF NOT EXISTS `menuArrangement` (
`id` int(11) NOT NULL,
  `menuId` int(11) NOT NULL,
  `arrangementId` int(11) NOT NULL,
  `aantal` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `menuArrangement`
--

INSERT INTO `menuArrangement` (`id`, `menuId`, `arrangementId`, `aantal`) VALUES
(1, 1, 2, 3),
(2, 2, 3, 4),
(3, 3, 4, 2),
(4, 4, 5, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menuBoeking`
--

CREATE TABLE IF NOT EXISTS `menuBoeking` (
`id` int(11) NOT NULL,
  `menuId` int(11) NOT NULL,
  `boekingId` int(11) NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `menuBoeking`
--

INSERT INTO `menuBoeking` (`id`, `menuId`, `boekingId`, `datum`) VALUES
(1, 1, 2, '2017-03-30'),
(2, 4, 3, '2017-03-22'),
(3, 2, 4, '2017-03-22'),
(4, 4, 2, '2017-03-19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pension`
--

CREATE TABLE IF NOT EXISTS `pension` (
`id` int(11) NOT NULL,
  `naam` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `pension`
--

INSERT INTO `pension` (`id`, `naam`) VALUES
(1, 'volpension'),
(2, 'halfpension');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persoon`
--

CREATE TABLE IF NOT EXISTS `persoon` (
`id` int(10) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `voornaam` varchar(50) NOT NULL,
  `postcode` varchar(4) NOT NULL,
  `gemeente` varchar(50) NOT NULL,
  `straat` varchar(50) NOT NULL,
  `huisnummer` varchar(4) NOT NULL,
  `bus` varchar(4) DEFAULT NULL,
  `telefoon` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `soort` int(11) NOT NULL,
  `wachtwoord` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `persoon`
--

INSERT INTO `persoon` (`id`, `naam`, `voornaam`, `postcode`, `gemeente`, `straat`, `huisnummer`, `bus`, `telefoon`, `email`, `soort`, `wachtwoord`) VALUES
(2, 'Peeters', 'Jan', '2460', 'Kasterlee', 'Kerkstraat', '10', NULL, '0412345678', 'eigenaar@eigenaar.be', 3, '0f234575e68d7af3becc8ec78ed368561e66b23d'),
(4, 'Janssen', 'Peter', '2460', 'Kasterlee', 'Schoolstraat', '23', NULL, '0654323456', 'werknemer@werknemer.be', 2, '4bef4c711cc54f7b3e86cb38897bbec7fe57a102'),
(13, 'Marie', 'Willems', '2400', 'Mol', 'Rozenberg', '5', NULL, '0476543213', 'marie@telenet.be', 1, '9c2028963dc9f7fbb4cb30140428a210c61dbb2c');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `prijs`
--

CREATE TABLE IF NOT EXISTS `prijs` (
`id` int(11) NOT NULL,
  `arrangementId` int(11) NOT NULL,
  `kamertypeId` int(11) NOT NULL,
  `soortPrijsId` int(11) DEFAULT NULL,
  `actuelePrijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `prijs`
--

INSERT INTO `prijs` (`id`, `arrangementId`, `kamertypeId`, `soortPrijsId`, `actuelePrijs`) VALUES
(1, 1, 1, 1, 70.00),
(2, 1, 1, 2, 65.00),
(3, 1, 2, 1, 87.00),
(4, 1, 2, 2, 74.50),
(5, 1, 3, 1, 90.00),
(6, 1, 3, 2, 76.00),
(7, 2, 1, 1, 127.00),
(8, 2, 1, 2, 117.00),
(9, 3, 1, 1, 147.00),
(10, 3, 1, 2, 137.00),
(11, 4, 1, 1, 241.00),
(12, 4, 1, 2, 221.00),
(13, 2, 2, 1, 161.00),
(14, 2, 2, 2, 136.00),
(15, 3, 2, 1, 181.00),
(16, 3, 2, 2, 153.00),
(17, 4, 2, 1, 309.00),
(18, 4, 2, 2, 259.00),
(19, 2, 3, 1, 166.00),
(20, 2, 3, 2, 139.00),
(21, 3, 3, 1, 186.00),
(22, 3, 3, 2, 159.00),
(23, 4, 3, 1, 319.00),
(24, 4, 3, 2, 265.00);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `soortPrijs`
--

CREATE TABLE IF NOT EXISTS `soortPrijs` (
`id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `aantal` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `soortPrijs`
--

INSERT INTO `soortPrijs` (`id`, `naam`, `aantal`) VALUES
(1, 'éénpersoons', 1),
(2, 'tweepersoons', 2),
(3, 'diepersoons', 3),
(4, 'vierpersoons', 4),
(5, 'vijfpersoons', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `typePersoon`
--

CREATE TABLE IF NOT EXISTS `typePersoon` (
`id` int(11) NOT NULL,
  `soort` varchar(50) NOT NULL,
  `korting` decimal(2,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `typePersoon`
--

INSERT INTO `typePersoon` (`id`, `soort`, `korting`) VALUES
(1, '0-3 jaar', 0.80),
(2, '4-8 jaar', 0.50),
(3, '9-12 jaar', 0.30);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `arrangement`
--
ALTER TABLE `arrangement`
 ADD PRIMARY KEY (`id`), ADD KEY `pensionid` (`pensionId`);

--
-- Indexen voor tabel `boeking`
--
ALTER TABLE `boeking`
 ADD PRIMARY KEY (`id`), ADD KEY `persoonId` (`persoonId`,`arrangementId`), ADD KEY `arrangementId` (`arrangementId`), ADD KEY `persoonId_2` (`persoonId`);

--
-- Indexen voor tabel `boekingTypePersoon`
--
ALTER TABLE `boekingTypePersoon`
 ADD PRIMARY KEY (`id`), ADD KEY `typePersoonId` (`typePersoonId`,`boekingId`), ADD KEY `boekingId` (`boekingId`), ADD KEY `typePersoonId_2` (`typePersoonId`), ADD KEY `typePersoonId_3` (`typePersoonId`);

--
-- Indexen voor tabel `extra`
--
ALTER TABLE `extra`
 ADD PRIMARY KEY (`id`), ADD KEY `faciliteitId` (`faciliteitId`), ADD KEY `boekingId` (`boekingId`);

--
-- Indexen voor tabel `faciliteit`
--
ALTER TABLE `faciliteit`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `factuur`
--
ALTER TABLE `factuur`
 ADD PRIMARY KEY (`id`), ADD KEY `boekingId` (`boekingId`);

--
-- Indexen voor tabel `kamer`
--
ALTER TABLE `kamer`
 ADD PRIMARY KEY (`id`), ADD KEY `kamertypeId` (`kamerTypeId`);

--
-- Indexen voor tabel `kamerBoeking`
--
ALTER TABLE `kamerBoeking`
 ADD PRIMARY KEY (`id`), ADD KEY `boekingId` (`boekingId`), ADD KEY `kamerId` (`kamerId`);

--
-- Indexen voor tabel `kamerType`
--
ALTER TABLE `kamerType`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `menuArrangement`
--
ALTER TABLE `menuArrangement`
 ADD PRIMARY KEY (`id`), ADD KEY `menuId` (`menuId`), ADD KEY `arrangementId` (`arrangementId`), ADD KEY `menuId_2` (`menuId`), ADD KEY `arrangementId_2` (`arrangementId`);

--
-- Indexen voor tabel `menuBoeking`
--
ALTER TABLE `menuBoeking`
 ADD PRIMARY KEY (`id`), ADD KEY `menuId` (`menuId`), ADD KEY `boekingId` (`boekingId`);

--
-- Indexen voor tabel `pension`
--
ALTER TABLE `pension`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `persoon`
--
ALTER TABLE `persoon`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `prijs`
--
ALTER TABLE `prijs`
 ADD PRIMARY KEY (`id`), ADD KEY `arrangementId` (`arrangementId`,`kamertypeId`,`soortPrijsId`), ADD KEY `kamertypeId` (`kamertypeId`), ADD KEY `soortKamerId` (`soortPrijsId`), ADD KEY `arrangementId_2` (`arrangementId`,`kamertypeId`,`soortPrijsId`);

--
-- Indexen voor tabel `soortPrijs`
--
ALTER TABLE `soortPrijs`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `typePersoon`
--
ALTER TABLE `typePersoon`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `arrangement`
--
ALTER TABLE `arrangement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `boeking`
--
ALTER TABLE `boeking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `boekingTypePersoon`
--
ALTER TABLE `boekingTypePersoon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `extra`
--
ALTER TABLE `extra`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `faciliteit`
--
ALTER TABLE `faciliteit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `factuur`
--
ALTER TABLE `factuur`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `kamer`
--
ALTER TABLE `kamer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT voor een tabel `kamerBoeking`
--
ALTER TABLE `kamerBoeking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `kamerType`
--
ALTER TABLE `kamerType`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT voor een tabel `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT voor een tabel `menuArrangement`
--
ALTER TABLE `menuArrangement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `menuBoeking`
--
ALTER TABLE `menuBoeking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `pension`
--
ALTER TABLE `pension`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `persoon`
--
ALTER TABLE `persoon`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT voor een tabel `prijs`
--
ALTER TABLE `prijs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT voor een tabel `soortPrijs`
--
ALTER TABLE `soortPrijs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `typePersoon`
--
ALTER TABLE `typePersoon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `arrangement`
--
ALTER TABLE `arrangement`
ADD CONSTRAINT `arrangement_ibfk_1` FOREIGN KEY (`pensionId`) REFERENCES `pension` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `boeking`
--
ALTER TABLE `boeking`
ADD CONSTRAINT `boeking_ibfk_1` FOREIGN KEY (`arrangementId`) REFERENCES `arrangement` (`id`),
ADD CONSTRAINT `boeking_ibfk_2` FOREIGN KEY (`persoonId`) REFERENCES `persoon` (`id`);

--
-- Beperkingen voor tabel `boekingTypePersoon`
--
ALTER TABLE `boekingTypePersoon`
ADD CONSTRAINT `boekingTypePersoon_ibfk_1` FOREIGN KEY (`boekingId`) REFERENCES `boeking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `boekingTypePersoon_ibfk_2` FOREIGN KEY (`typePersoonId`) REFERENCES `typePersoon` (`id`);

--
-- Beperkingen voor tabel `extra`
--
ALTER TABLE `extra`
ADD CONSTRAINT `extra_ibfk_1` FOREIGN KEY (`faciliteitId`) REFERENCES `faciliteit` (`id`),
ADD CONSTRAINT `extra_ibfk_2` FOREIGN KEY (`id`) REFERENCES `boeking` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `factuur`
--
ALTER TABLE `factuur`
ADD CONSTRAINT `factuur_ibfk_1` FOREIGN KEY (`boekingId`) REFERENCES `boeking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `kamer`
--
ALTER TABLE `kamer`
ADD CONSTRAINT `kamer_ibfk_1` FOREIGN KEY (`kamerTypeId`) REFERENCES `kamerType` (`id`);

--
-- Beperkingen voor tabel `kamerBoeking`
--
ALTER TABLE `kamerBoeking`
ADD CONSTRAINT `kamerBoeking_ibfk_2` FOREIGN KEY (`kamerId`) REFERENCES `kamer` (`id`),
ADD CONSTRAINT `kamerBoeking_ibfk_3` FOREIGN KEY (`boekingId`) REFERENCES `boeking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `menuArrangement`
--
ALTER TABLE `menuArrangement`
ADD CONSTRAINT `menuArrangement_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`),
ADD CONSTRAINT `menuArrangement_ibfk_2` FOREIGN KEY (`arrangementId`) REFERENCES `arrangement` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `menuBoeking`
--
ALTER TABLE `menuBoeking`
ADD CONSTRAINT `menuBoeking_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`),
ADD CONSTRAINT `menuBoeking_ibfk_2` FOREIGN KEY (`boekingId`) REFERENCES `boeking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `prijs`
--
ALTER TABLE `prijs`
ADD CONSTRAINT `prijs_ibfk_1` FOREIGN KEY (`arrangementId`) REFERENCES `arrangement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prijs_ibfk_2` FOREIGN KEY (`kamertypeId`) REFERENCES `kamerType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `prijs_ibfk_3` FOREIGN KEY (`soortPrijsId`) REFERENCES `soortPrijs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
