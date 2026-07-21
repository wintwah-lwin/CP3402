-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 10:04 AM
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
-- Database: `quizdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `AttemptID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Score` int(11) NOT NULL,
  `DatePlayed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attempts`
--

INSERT INTO `attempts` (`AttemptID`, `UserID`, `Score`, `DatePlayed`) VALUES
(1, 1, 20, '2026-07-21 02:15:32'),
(2, 1, 20, '2026-07-21 02:15:39'),
(3, 1, 10, '2026-07-21 02:22:25'),
(4, 1, 60, '2026-07-21 02:28:47'),
(5, 1, 70, '2026-07-21 02:31:08'),
(6, 1, 70, '2026-07-21 02:43:09'),
(7, 1, 70, '2026-07-21 08:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `QuestionText` text NOT NULL,
  `Option1` varchar(255) NOT NULL,
  `Option2` varchar(255) NOT NULL,
  `Option3` varchar(255) NOT NULL,
  `Option4` varchar(255) NOT NULL,
  `CorrectAnswer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `QuestionText`, `Option1`, `Option2`, `Option3`, `Option4`, `CorrectAnswer`) VALUES
(1, 'What is the capital of France?', 'Berlin', 'Madrid', 'Paris', 'Rome', 'Paris'),
(2, 'Which planet is known as the Red Planet?', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Mars'),
(3, 'What is the largest mammal on Earth?', 'Blue Whale', 'Elephant', 'Giraffe', 'Hippo', 'Blue Whale'),
(4, 'What is the chemical symbol for Gold?', 'Au', 'Ag', 'Fe', 'Cu', 'Au'),
(5, 'Which country has the most natural lakes in the world?', 'Canada', 'USA', 'Russia', 'Brazil', 'Canada'),
(6, 'How many bones are in the adult human body?', '206', '208', '210', '204', '206'),
(7, 'What is the hardest natural substance on Earth?', 'Diamond', 'Corundum', 'Topaz', 'Quartz', 'Diamond'),
(8, 'Which planet is closest to the Sun?', 'Mercury', 'Venus', 'Earth', 'Mars', 'Mercury'),
(9, 'In which year did World War II end?', '1945', '1939', '1918', '1950', '1945'),
(10, 'What is the capital city of Australia?', 'Canberra', 'Sydney', 'Melbourne', 'Brisbane', 'Canberra'),
(11, 'Who wrote the famous play \"Romeo and Juliet\"?', 'William Shakespeare', 'Charles Dickens', 'Mark Twain', 'Jane Austen', 'William Shakespeare'),
(12, 'What is the primary gas found in Earth atmosphere?', 'Nitrogen', 'Oxygen', 'Carbon Dioxide', 'Argon', 'Nitrogen'),
(13, 'What is the national summer sport of Canada?', 'Lacrosse', 'Ice Hockey', 'Baseball', 'Cricket', 'Lacrosse'),
(14, 'Which country is known as the Land of the Rising Sun?', 'Japan', 'China', 'South Korea', 'Thailand', 'Japan'),
(15, 'What does \"CPU\" stand for in computer hardware?', 'Central Processing Unit', 'Central Computer Unit', 'Core Processing Utility', 'Central Control Unit', 'Central Processing Unit'),
(16, 'Who was the first human to step on the Moon?', 'Neil Armstrong', 'Buzz Aldrin', 'Yuri Gagarin', 'Michael Collins', 'Neil Armstrong'),
(17, 'What currency is used in the United Kingdom?', 'Pound Sterling', 'Euro', 'US Dollar', 'Swiss Franc', 'Pound Sterling'),
(18, 'Which animal is known as the \"Ship of the Desert\"?', 'Camel', 'Elephant', 'Llama', 'Horse', 'Camel'),
(19, 'What is the smallest country in the world by land area?', 'Vatican City', 'Monaco', 'Nauru', 'San Marino', 'Vatican City'),
(20, 'How many sides does a heptagon have?', '7', '6', '8', '9', '7'),
(21, 'Which element is primarily used as fuel in nuclear power plants?', 'Uranium', 'Plutonium', 'Thorium', 'Radium', 'Uranium'),
(22, 'What is the largest living mammal on Earth?', 'Blue Whale', 'African Elephant', 'Giraffe', 'Colossal Squid', 'Blue Whale'),
(23, 'Who developed the general theory of relativity?', 'Albert Einstein', 'Isaac Newton', 'Galileo Galilei', 'Nikola Tesla', 'Albert Einstein'),
(24, 'Which city is famous for its ancient Amphitheatre, the Colosseum?', 'Rome', 'Athens', 'Cairo', 'Istanbul', 'Rome'),
(25, 'What is the chemical formula for common table salt?', 'NaCl', 'KCl', 'NaOH', 'HCl', 'NaCl'),
(26, 'What is the official capital city of Canada?', 'Ottawa', 'Toronto', 'Vancouver', 'Montreal', 'Ottawa'),
(27, 'What color pigment does chlorophyll absorb to make plants appear green?', 'Red and Blue', 'Green and Yellow', 'Only Green', 'UV Light', 'Red and Blue'),
(28, 'Which country is native to the Kangaroo?', 'Australia', 'South Africa', 'New Zealand', 'Brazil', 'Australia'),
(29, 'In what year was the World Wide Web made publicly available?', '1991', '1983', '1995', '2000', '1991'),
(30, 'What is the largest cold desert in the world?', 'Antarctic Desert', 'Sahara Desert', 'Gobi Desert', 'Arabian Desert', 'Antarctic Desert'),
(31, 'Which artist famously cut off part of his own left ear?', 'Vincent van Gogh', 'Pablo Picasso', 'Salvador Dali', 'Rembrandt', 'Vincent van Gogh'),
(32, 'What is the highest mountain peak above sea level in the world?', 'Mount Everest', 'K2', 'Kangchenjunga', 'Lhotse', 'Mount Everest'),
(33, 'How many colors are traditionally identified in a rainbow?', '7', '6', '8', '5', '7'),
(34, 'What is the main natural ingredient used to manufacture glass?', 'Silica Sand', 'Limestone', 'Sodium Carbonate', 'Clay', 'Silica Sand'),
(35, 'Which planet in our solar system has the most prominent ring system?', 'Saturn', 'Jupiter', 'Uranus', 'Neptune', 'Saturn'),
(36, 'What is the freezing point of pure water on the Celsius scale?', '0 degrees', '-10 degrees', '32 degrees', '100 degrees', '0 degrees'),
(37, 'What is the official primary language of Brazil?', 'Portuguese', 'Spanish', 'French', 'English', 'Portuguese'),
(38, 'Which bird is universally recognized as a symbol of peace?', 'Dove', 'Eagle', 'Owl', 'Peacock', 'Dove'),
(39, 'Which river is widely considered the longest in the world?', 'Nile River', 'Amazon River', 'Yangtze River', 'Mississippi River', 'Nile River'),
(40, 'Who is the author of the \"Harry Potter\" book series?', 'J.K. Rowling', 'J.R.R. Tolkien', 'George R.R. Martin', 'C.S. Lewis', 'J.K. Rowling'),
(41, 'In which human organ is bile produced?', 'Liver', 'Gallbladder', 'Pancreas', 'Stomach', 'Liver'),
(42, 'Which famous scientist experimented with falling bodies at the Tower of Pisa?', 'Galileo Galilei', 'Isaac Newton', 'Archimedes', 'Leonardo da Vinci', 'Galileo Galilei'),
(43, 'What is the capital city of France?', 'Paris', 'Lyon', 'Marseille', 'Nice', 'Paris'),
(44, 'What scientific unit is used to measure electrical resistance?', 'Ohm', 'Volt', 'Ampere', 'Watt', 'Ohm'),
(45, 'Which continent contains the geographic South Pole?', 'Antarctica', 'Australia', 'South America', 'Asia', 'Antarctica'),
(46, 'What is the approximate speed of light in a vacuum?', '300,000 km/s', '150,000 km/s', '1,000,000 km/s', '30,000 km/s', '300,000 km/s'),
(47, 'Which country gifted the Statue of Liberty to the United States?', 'France', 'United Kingdom', 'Spain', 'Germany', 'France'),
(48, 'What does \"HTTP\" stand for in web addresses?', 'Hypertext Transfer Protocol', 'High Transfer Text Process', 'Hypertext Test Protocol', 'Host Text Transfer Protocol', 'Hypertext Transfer Protocol'),
(49, 'Which mammal is capable of sustained, powered flight?', 'Bat', 'Flying Squirrel', 'Sugar Glider', 'Flying Lemur', 'Bat'),
(50, 'What is the primary raw ingredient used to make chocolate?', 'Cocoa Beans', 'Vanilla Pods', 'Sugar Cane', 'Milk Powder', 'Cocoa Beans'),
(51, 'Which sea creature is known to have three hearts?', 'Octopus', 'Shark', 'Dolphin', 'Jellyfish', 'Octopus'),
(52, 'What is the capital city of Spain?', 'Madrid', 'Barcelona', 'Seville', 'Valencia', 'Madrid'),
(53, 'How many sides does an octagon have?', '8', '6', '7', '10', '8');

-- --------------------------------------------------------

--
-- Table structure for table `usertb`
--

CREATE TABLE `usertb` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertb`
--

INSERT INTO `usertb` (`UserID`, `Username`, `Email`, `Password`, `CreatedAt`) VALUES
(1, 'arisa', 'arisa@gmail.com', '$2y$10$lzRJc.Ol8B0xBIStU3RjqOLIh0gRG.ew/tylsl1MMCgbmd4Fs7mji', '2026-07-21 02:10:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`AttemptID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`);

--
-- Indexes for table `usertb`
--
ALTER TABLE `usertb`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `AttemptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `usertb`
--
ALTER TABLE `usertb`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attempts`
--
ALTER TABLE `attempts`
  ADD CONSTRAINT `attempts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `usertb` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
