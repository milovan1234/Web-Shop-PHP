-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 09:48 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prodavnica-tehnike`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikal`
--

CREATE TABLE `artikal` (
  `Id` int(10) UNSIGNED NOT NULL,
  `IdGrupe` int(10) UNSIGNED NOT NULL,
  `Naziv` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Marka` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BrojStanja` int(10) UNSIGNED NOT NULL,
  `Prodato` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Cena` double NOT NULL,
  `Popust` int(11) NOT NULL,
  `Opis` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Slika` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Aktivan` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `DatumDodavanja` timestamp NOT NULL DEFAULT current_timestamp(),
  `Izmena` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artikal`
--

INSERT INTO `artikal` (`Id`, `IdGrupe`, `Naziv`, `Marka`, `BrojStanja`, `Prodato`, `Cena`, `Popust`, `Opis`, `Slika`, `Aktivan`, `DatumDodavanja`, `Izmena`) VALUES
(1, 1, 'Frižider', 'Gorenje', 5, 0, 27990, 10, 'GORENJE Frižider sa jednim vratima R 6295 W, Samootapajući', 'slike-artikala/gorenje-frizider-2.png', 1, '2019-12-20 19:49:58', '2019-12-20 19:49:58'),
(2, 1, 'Frižider', 'Gorenje', 4, 0, 41990, 18, 'GORENJE Kombinovani frižider RK61FSY2B, Frost Less', './slike-artikala/gorenje-frizider-3.png', 1, '2019-12-20 22:27:05', '2019-12-21 14:40:57'),
(3, 1, 'Frižider', 'Vox', 10, 0, 21990, 0, 'VOX Kombinovani frižider KG 2600, Samootapajući', './slike-artikala/vox-frizider-1.jpg', 1, '2019-12-20 22:28:52', '2019-12-20 22:28:52'),
(4, 2, 'Mobilni telefon', 'Samsung', 5, 0, 36656, 10, 'Samsung Galaxy A30s - Crni', './slike-artikala/samsung-galaxya30s-mobilni-1.jpg', 1, '2019-12-20 22:30:47', '2019-12-20 22:30:47'),
(5, 2, 'Mobilni telefon', 'CAT', 0, 2, 7790, 10, 'CAT B25 - Crni', './slike-artikala/cat-b25-mobilni-1.jpg', 1, '2019-12-20 22:31:50', '2020-01-14 08:25:42'),
(6, 2, 'Mobilni telefon', 'IPhone', 4, 1, 141990, 10, 'iPhone XS - Space Grey', './slike-artikala/iphone-xs-mobilni-1.jpg', 1, '2019-12-20 22:32:28', '2020-01-09 09:38:42'),
(7, 1, 'Frižider', 'Beko', 5, 0, 61110, 9, 'Beko Kombinovani frižider RCNA406I30XB', './slike-artikala/beko-frizider-1.jpg', 1, '2019-12-20 22:34:04', '2019-12-20 22:34:04'),
(8, 1, 'Veš mašina', 'Bosch', 2, 0, 36990, 10, 'BOSCH Mašina za pranje veša WAB 20262BY', './slike-artikala/bosh-vesmasina-1.jpg', 1, '2019-12-20 22:34:57', '2019-12-20 22:34:57'),
(9, 1, 'Bojler', 'Gorenje', 10, 0, 12767, 0, 'Gorenje bojler TG80NGU', './slike-artikala/gorenje-bojler-1.jpg', 1, '2019-12-20 22:35:48', '2019-12-20 22:35:48'),
(10, 1, 'Mikrotalasna rerna', 'Samsung', 3, 0, 14599, 23, 'SAMSUNG Mikrotalasna rerna MG 23F301TAS', './slike-artikala/samsung-mikrotalasna-1.jpg', 1, '2019-12-20 22:36:37', '2019-12-20 22:36:37'),
(11, 1, 'Veš mašina', 'Beko', 4, 0, 39999, 10, 'BEKO Mašina za pranje veša WMY 71283 LMB', './slike-artikala/beko-vesmasina-2.jpg', 1, '2019-12-20 22:37:16', '2019-12-20 22:37:16'),
(12, 1, 'Frižider', 'Gorenje', 5, 0, 45990, 10, 'GORENJE Frižider sa jednim vratima R 6150 BX, Samootapajući', './slike-artikala/gorenje-frizider-1.png', 1, '2019-12-20 22:38:10', '2019-12-20 22:38:10'),
(13, 3, 'Televizor', 'Tesla', 8, 0, 33990, 10, 'Tesla Televizor 42S306BF', './slike-artikala/tesla-televizor-1.jpg', 1, '2019-12-20 22:39:28', '2019-12-20 22:39:28'),
(14, 4, 'Standardna klima', 'Tesla', 2, 0, 31110, 10, 'TESLA Standardna klima TC32H3 12410A', './slike-artikala/tesla-klima-1.jpg', 1, '2019-12-20 22:40:13', '2019-12-20 22:40:13'),
(17, 2, 'Mobilni telefon', 'Xiaomi', 5, 0, 19990, 0, 'Xiaomi Redmi 8 - 64 GB - Crni ', './slike-artikala/xiaomi-redmi8-mobilni-1.jpg', 1, '2020-01-04 14:05:33', '2020-01-04 14:06:02'),
(18, 4, 'Inverter klima', 'Gorenje', 5, 0, 91100, 24, 'GORENJE Inverter klima KAS 53INVDC ', './slike-artikala/gorenje-klima-1.jpg', 1, '2020-01-05 18:14:12', '2020-01-05 18:14:12'),
(19, 4, 'Pokretna klima', 'Vox', 7, 1, 42211, 10, 'VOX Pokretna klima VPA 14', './slike-artikala/vox-klima-1.jpg', 1, '2020-01-05 18:18:49', '2020-01-05 18:18:49'),
(20, 4, 'Standardna klima', 'Gorenje', 5, 2, 83322, 26, 'GORENJE standardna klima KAS 70 FT ', './slike-artikala/gorenje-klima-2.jpg', 1, '2020-01-05 18:20:53', '2020-01-05 18:20:53'),
(21, 4, 'Standardna klima', 'LG', 5, 0, 51110, 26, 'LG Standardna klima K 12EHC', './slike-artikala/lg-klima-1.jpg', 1, '2020-01-05 18:22:04', '2020-01-05 18:22:04'),
(22, 4, 'Inverter klima', 'DAIKIN', 8, 0, 75544, 10, 'DAIKIN Klima uređaj inverter FTXB35C/RXB35C', './slike-artikala/daikin-klima-1.jpg', 1, '2020-01-05 18:25:40', '2020-01-05 18:26:35'),
(23, 2, 'Žični telefon', 'Panasonic', 3, 0, 1443, 10, 'PANASONIC Telefon KX TS 500FXC ', './slike-artikala/panasonic-zicni-1.png', 1, '2020-01-05 20:22:45', '2020-01-05 20:22:45'),
(24, 3, 'Smart televizor', 'Vox', 5, 0, 49989, 10, 'Vox Smart televizor 55DSW293V', './slike-artikala/vox-televizor-1.jpg', 1, '2020-01-05 20:49:20', '2020-01-06 22:52:20'),
(25, 3, 'Smart televizor', 'Philips', 4, 1, 149989, 10, 'Philips Smart televizor 55PUS8303/12', './slike-artikala/philips-televizor-1.jpg', 1, '2020-01-05 20:50:50', '2020-01-05 20:50:50'),
(26, 3, 'Smart televizor', 'Sony', 4, 0, 53322, 10, 'Sony Smart televizor KDL40WE665BAEP', './slike-artikala/sony-televizor-1.jpg', 1, '2020-01-05 20:52:45', '2020-01-05 20:52:45'),
(27, 3, 'Dvd plejer', 'Sony', 5, 0, 5990, 0, 'Sony DVD plejer DVP-SR760HB EC1 ', './slike-artikala/sony-plejer-1.png', 1, '2020-01-05 20:55:00', '2020-01-05 20:55:00'),
(28, 3, 'Dvd plejer', 'Pioneer', 2, 0, 6990, 10, 'PIONEER DVD Plejer DV 2242 ', './slike-artikala/pioneer-plejer-1.jpg', 1, '2020-01-05 20:57:46', '2020-01-05 20:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `grupa`
--

CREATE TABLE `grupa` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Naziv` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Slika` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Aktivna` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Izmene` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grupa`
--

INSERT INTO `grupa` (`Id`, `Naziv`, `Slika`, `Aktivna`, `Izmene`) VALUES
(1, 'Bela tehnika', './slike-grupa/bela-tehnika.jpg', 1, '2019-12-20 08:06:45'),
(2, 'Telefonija', './slike-grupa/telefonija.jpg', 1, '2019-12-20 08:13:59'),
(3, 'TV', './slike-grupa/televizija.jpg', 1, '2019-12-20 08:16:26'),
(4, 'Klima uređaji', './slike-grupa/klima.jpg', 1, '2019-12-20 08:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Ime` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Prezime` varchar(20) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `Email` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Lozinka` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Slika` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Aktivan` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Prijava` timestamp NOT NULL DEFAULT current_timestamp(),
  `Izmena` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`Id`, `Ime`, `Prezime`, `Email`, `Lozinka`, `Status`, `Slika`, `Aktivan`, `Prijava`, `Izmena`) VALUES
(3, 'Milovan', 'Srejić', 'srejicmilovan@gmail.com', 'f26d1d40fa13b70fee383fad263a452a9870011c07fa29216adb4e7010e06dcd', 'Kupac', 'slike-korisnika/milovan_srejic.jpg', 0, '2019-12-24 14:44:29', '2019-12-24 14:45:09'),
(4, 'Admin', 'Admin', 'admin@gmail.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Administrator', 'slike-korisnika/customer.jpg', 1, '2020-01-21 12:43:13', '2020-01-09 14:22:43'),
(7, 'Miloš', 'Srejić', 'milos0604@hotmail.com', '4679d21aa611ce7b830f5ccaaf85a238a3b215974cad3f5ab33ee78e1d1efa6f', 'Kupac', 'slike-korisnika/milos_srejic.jpg', 0, '2020-01-21 12:42:34', '2020-01-14 17:00:46'),
(10, 'Bojan', 'Stojković', 'bokis97@gmail.com', 'f6aee0a540d3fb3d29d6036903962b46263cd7b9ebaba46a683ab33eadb6ab4e', 'Kupac', 'slike-korisnika/bojan-stojkovic.jpg', 0, '2020-01-14 15:05:37', '2019-12-25 08:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `slajder`
--

CREATE TABLE `slajder` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Slika` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Aktivna` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `DatumDodavanja` timestamp NOT NULL DEFAULT current_timestamp(),
  `Izmena` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slajder`
--

INSERT INTO `slajder` (`Id`, `Slika`, `Aktivna`, `DatumDodavanja`, `Izmena`) VALUES
(1, 'slike-slajder/slika-slajder-1.jpg', 0, '2019-12-21 23:46:20', '2020-01-09 14:19:06'),
(2, 'slike-slajder/slika-slajder-2.jpg', 1, '2019-12-21 23:46:20', '2020-01-21 12:46:06'),
(3, 'slike-slajder/slika-slajder-3.jpg', 1, '2019-12-21 23:46:20', '2020-01-14 16:24:02'),
(4, 'slike-slajder/slika-slajder-4.jpg', 1, '2019-12-21 23:46:20', '2020-01-09 11:10:52'),
(6, 'slike-slajder/slika-slajder-5.jpg', 0, '2019-12-22 11:50:28', '2020-01-14 16:23:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikal`
--
ALTER TABLE `artikal`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `grupa`
--
ALTER TABLE `grupa`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `slajder`
--
ALTER TABLE `slajder`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikal`
--
ALTER TABLE `artikal`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `grupa`
--
ALTER TABLE `grupa`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `slajder`
--
ALTER TABLE `slajder`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
