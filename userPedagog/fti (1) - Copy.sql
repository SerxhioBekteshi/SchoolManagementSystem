-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2021 at 09:41 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fti`
--

-- --------------------------------------------------------

--
-- Table structure for table `klase_lende`
--

CREATE TABLE `klase_lende` (
  `klase_lende_id` int(11) NOT NULL,
  `student_klase_id` int(11) NOT NULL,
  `lenda_id` int(11) NOT NULL,
  `mesues_id` int(11) NOT NULL,
  `seminar_leksion` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klase_lende`
--

INSERT INTO `klase_lende` (`klase_lende_id`, `student_klase_id`, `lenda_id`, `mesues_id`, `seminar_leksion`) VALUES
(1, 8, 1, 1, 'l'),
(2, 8, 1, 1, 's'),
(3, 1, 1, 1, 'l'),
(17, 10, 1, 1, 'l'),
(19, 9, 1, 5, 'l');

-- --------------------------------------------------------

--
-- Table structure for table `lenda`
--

CREATE TABLE `lenda` (
  `lenda_id` int(11) NOT NULL,
  `titulli_lendes` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lenda`
--

INSERT INTO `lenda` (`lenda_id`, `titulli_lendes`) VALUES
(1, 'Analize matematike 1'),
(2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `mesues`
--

CREATE TABLE `mesues` (
  `mesues_id` int(11) NOT NULL,
  `emri` varchar(30) NOT NULL,
  `mbiemri` varchar(30) NOT NULL,
  `roli` varchar(20) NOT NULL,
  `gjinia` varchar(1) NOT NULL,
  `titulli` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `adresa` varchar(30) NOT NULL,
  `cel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mesues`
--

INSERT INTO `mesues` (`mesues_id`, `emri`, `mbiemri`, `roli`, `gjinia`, `titulli`, `email`, `adresa`, `cel`) VALUES
(1, 'Srofe', 'Profesori', 'Shef Departamenti', 'M', 'Prof. Dri', 'tokohar210@jentrix.com', 'Tirane', '0692141241'),
(3, 'Ergys', 'meda', 'Roli', 'M', 'Titulli', 'saf@yahoo.com', 'Tirane', '0692412412'),
(4, 'Pedagog', 'Pedagog', 'Pedagog i brendshem', 'M', 'MsC', 'rym41294@cuoly.com', 'Laprake', '0681231323'),
(5, 'Profe', 'Matematike', 'Shef Departamenti', 'M', 'Prof. Dr', 'tzex5rsx.lbb@kjjit.eu', 'Durres', '0683243423');

-- --------------------------------------------------------

--
-- Table structure for table `mungesa`
--

CREATE TABLE `mungesa` (
  `mungesa_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `student_id` int(11) NOT NULL,
  `klase_lende_id` int(11) NOT NULL,
  `mesues_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provim`
--

CREATE TABLE `provim` (
  `provim_id` int(11) NOT NULL,
  `studenti_id` int(11) NOT NULL,
  `mesuesi_id` int(11) NOT NULL,
  `email_mesues` int(11) NOT NULL,
  `viti_provimit` year(4) NOT NULL,
  `nota` int(11) NOT NULL,
  `kredite` int(11) NOT NULL,
  `lenda_id` int(11) NOT NULL,
  `student_klase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_email` varchar(30) NOT NULL,
  `emer_mbiemer` varchar(60) NOT NULL,
  `student_klase_id` varchar(20) NOT NULL,
  `student_adresa` varchar(40) NOT NULL,
  `cel` varchar(15) NOT NULL,
  `atesia` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `gjinia` varchar(1) NOT NULL,
  `status` varchar(10) NOT NULL,
  `kredite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_email`, `emer_mbiemer`, `student_klase_id`, `student_adresa`, `cel`, `atesia`, `dob`, `gjinia`, `status`, `kredite`) VALUES
(3, 'ranas.kech.73113@koalaswap.com', 'Lionel Messi', '1', 'Librazhd', '0892312421', 'Andres', '1984-07-24', 'M', 'Aktiv', 120),
(4, 'ergys.meda@fti.edu.al', 'Lautaro Martinez', '1', 'Milano, Itali', '0682341241', 'BabiLautaros', '1992-10-17', 'M', 'Aktiv', 6);

-- --------------------------------------------------------

--
-- Table structure for table `student_klase`
--

CREATE TABLE `student_klase` (
  `student_klase_id` int(11) NOT NULL,
  `niveli` varchar(20) NOT NULL,
  `dega` varchar(30) NOT NULL,
  `viti` varchar(1) NOT NULL,
  `grupi` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_klase`
--

INSERT INTO `student_klase` (`student_klase_id`, `niveli`, `dega`, `viti`, `grupi`) VALUES
(1, 'Bachelor', 'Inxhinieri Informatike', '1', 'D'),
(3, 'Bachelor', 'Inxhinieri Informatike', '1', 'B'),
(5, 'Bachelor', 'Inxhinieri Informatike', '2', 'A'),
(6, 'Bachelor', 'Inxhinieri Informatike', '2', 'B'),
(7, 'Bachelor', 'Inxhinieri Informatike', '2', 'C'),
(8, 'Bachelor', 'Inxhinieri Informatike', '2', 'D'),
(9, 'Bachelor', 'Inxhinieri Informatike', '3', 'A'),
(10, 'Bachelor', 'Inxhinieri Informatike', '3', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_role` varchar(10) NOT NULL,
  `user_emri` varchar(20) NOT NULL,
  `user_mbiemri` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_password`, `user_role`, `user_emri`, `user_mbiemri`) VALUES
(1, 'admin', '6399fb67c687ea25266f52219e58f580', 'admin', 'admin', 'admin'),
(2, 'ergysmeda1@gmail.com', '9a6e2df6411b4a7f30b797918f16cf1f', 'student', 'Ergys', 'Meda'),
(3, 'ergmeda@gmail.com', '9a6e2df6411b4a7f30b797918f16cf1f', 'sekretar', 'Erg', 'Meda'),
(6, 'ranas.kech.73113@koalaswap.com', 'a81aedaa81fc4894c40e7eb39e4a7ebd', 'student', 'Lionel', 'Messi'),
(7, 'ergys.meda@fti.edu.al', '0fbc3a05e4932e016038e2b306cab9e8', 'student', 'Lautaro', 'Martinez'),
(8, 'tokohar210@jentrix.com', 'ab848ad9cd6fb86295b942e8f1bb3199', 'pedagog', 'Srofe', 'Profesori'),
(10, 'saf@yahoo.com', '118a1e514369136273cfa9c30537fe83', 'pedagog', 'Ergys', 'meda'),
(11, 'rym41294@cuoly.com', '1679cd1832d098ffa3bd5c8b28fe39d6', 'pedagog', 'Pedagog', 'Pedagog'),
(12, 'tzex5rsx.lbb@kjjit.eu', '818de3b3428082a7a63f3c8238c16d73', 'pedagog', 'Profe', 'Matematike');

-- --------------------------------------------------------

--
-- Table structure for table `vleresimi`
--

CREATE TABLE `vleresimi` (
  `lenda_id` int(11) NOT NULL,
  `vleresimi_id` int(11) NOT NULL,
  `studenti_id` int(11) NOT NULL,
  `nota_prov` int(11) NOT NULL,
  `pesha_prov` float NOT NULL,
  `nota_detyre` int(11) NOT NULL,
  `pesha_detyre` float NOT NULL,
  `nota_tjera` int(11) NOT NULL,
  `pesha_tjera` float NOT NULL,
  `kredite` int(11) NOT NULL,
  `student_klase_id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klase_lende`
--
ALTER TABLE `klase_lende`
  ADD PRIMARY KEY (`klase_lende_id`),
  ADD KEY `student_klase_id` (`student_klase_id`),
  ADD KEY `lenda_id` (`lenda_id`),
  ADD KEY `mesues_id` (`mesues_id`);

--
-- Indexes for table `lenda`
--
ALTER TABLE `lenda`
  ADD PRIMARY KEY (`lenda_id`);

--
-- Indexes for table `mesues`
--
ALTER TABLE `mesues`
  ADD PRIMARY KEY (`mesues_id`),
  ADD KEY `mesues_id` (`mesues_id`);

--
-- Indexes for table `mungesa`
--
ALTER TABLE `mungesa`
  ADD PRIMARY KEY (`mungesa_id`),
  ADD KEY `student_id` (`student_id`,`klase_lende_id`,`mesues_id`);

--
-- Indexes for table `provim`
--
ALTER TABLE `provim`
  ADD PRIMARY KEY (`provim_id`),
  ADD KEY `studenti_id` (`studenti_id`,`mesuesi_id`,`lenda_id`,`student_klase_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_klase`
--
ALTER TABLE `student_klase`
  ADD PRIMARY KEY (`student_klase_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vleresimi`
--
ALTER TABLE `vleresimi`
  ADD PRIMARY KEY (`vleresimi_id`),
  ADD KEY `lenda_id` (`lenda_id`,`studenti_id`,`student_klase_id`,`prof_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klase_lende`
--
ALTER TABLE `klase_lende`
  MODIFY `klase_lende_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lenda`
--
ALTER TABLE `lenda`
  MODIFY `lenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mesues`
--
ALTER TABLE `mesues`
  MODIFY `mesues_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mungesa`
--
ALTER TABLE `mungesa`
  MODIFY `mungesa_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provim`
--
ALTER TABLE `provim`
  MODIFY `provim_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_klase`
--
ALTER TABLE `student_klase`
  MODIFY `student_klase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vleresimi`
--
ALTER TABLE `vleresimi`
  MODIFY `vleresimi_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
