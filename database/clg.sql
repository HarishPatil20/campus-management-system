-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 08:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clg`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `faculty_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `credits`, `dept_id`, `faculty_id`) VALUES
('123', 'full stack webdevolopment', 4, '', '123'),
('hdwe5', 'wefwef', 4, '', '123');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_hod` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_hod`) VALUES
(122, 'mec', 'prithvi'),
(123, 'cse', 'mithil');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` varchar(10) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`, `dept_id`, `email`) VALUES
('123', 'mithil', '122', 'mith@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `course_id` varchar(20) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `student_id`, `course_id`, `grade`, `semester`) VALUES
(1, '4So24cs414', '123', '34', 5),
(2, '4So24cs414', 'hdwe5', '48', 5);

-- --------------------------------------------------------

--
-- Table structure for table `hostel`
--

CREATE TABLE `hostel` (
  `hostel_id` int(10) NOT NULL,
  `hostel_name` varchar(100) NOT NULL,
  `st_id` varchar(10) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `roomno` varchar(10) NOT NULL,
  `block` varchar(10) NOT NULL,
  `type` enum('Boys','Girls') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hostel`
--

INSERT INTO `hostel` (`hostel_id`, `hostel_name`, `st_id`, `contact`, `roomno`, `block`, `type`) VALUES
(1, 'sjecboys', '4So24cs414', '9731975122', '313', '3', 'Boys'),
(2, 'sjecboys', '4So24cs400', '9731975122', '313', '3', 'Boys'),
(3, 'sjecboys', '4So24cs407', '9731975122', '313', '3', 'Boys'),
(5, 'sjec boys hostel', '4So24cs100', '9754121100', '414', '4', 'Boys'),
(6, 'sjec boys hostel', '4So24cs101', '9754121155', '414', '4', 'Boys');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `lib_id` varchar(250) NOT NULL,
  `st_id` varchar(250) NOT NULL,
  `book_id` varchar(250) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `issue_date` varchar(250) NOT NULL,
  `issue_id` int(250) NOT NULL,
  `is_submitted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`lib_id`, `st_id`, `book_id`, `book_name`, `issue_date`, `issue_id`, `is_submitted`) VALUES
('1', '4So24cs414', '1a', 'DSA', '2025-10-15', 4, 1),
('2', '4So24cs414', '1b', 'DAA', '2025-10-15', 5, 1),
('6', '4So24cs423', '1b', 'DAA', '2025-10-15', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'harish', 'hp@gmail.com', '$2y$10$3qQbNOEjHMuoFVE8ebXE1uotV0ZjE8r5QmEDt9c1uxxGo.UxChsq2', 'user'),
(2, 'Harish Patil', 'harishpatil@gmail.com', '$2y$10$B91n0CZpVgZjxBmaF8kYaearkvdY60vKE5WuDibMXzOQSRlN7clqi', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `st_id` varchar(20) NOT NULL,
  `st_name` varchar(100) NOT NULL,
  `semester` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`st_id`, `st_name`, `semester`, `dept_id`, `dob`, `email`) VALUES
('4So24cs100', 'hh', 3, 123, '2025-10-15', '24csdip100.ddik@sjec.ac.in'),
('4So24cs101', 'hh', 5, 123, '2025-10-15', '24csdip101.ddik@sjec.ac.in'),
('4So24cs102', 'hh', 7, 122, '2025-10-15', '24csdip102.ddik@sjec.ac.in'),
('4So24cs400', 'ppp', 5, 123, '2025-10-15', '24csdip10.ddik@sjec.ac.in'),
('4So24cs407', 'ppp', 5, 123, '2025-10-15', '24csdip13.ddik@sjec.ac.in'),
('4So24cs411', 'hh', 5, 123, '2025-10-15', '24csdip11.ddik@sjec.ac.in'),
('4So24cs414', 'Harish Patil', 5, 123, '2006-09-14', '24csdip14.ddik@sjec.ac.in'),
('4So24cs423', 'hh', 4, 122, '2025-10-15', '24csdip22.ddik@sjec.ac.in');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `hostel`
--
ALTER TABLE `hostel`
  ADD PRIMARY KEY (`hostel_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`st_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hostel`
--
ALTER TABLE `hostel`
  MODIFY `hostel_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `issue_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hostel`
--
ALTER TABLE `hostel`
  ADD CONSTRAINT `hostel_ibfk_1` FOREIGN KEY (`st_id`) REFERENCES `student` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
