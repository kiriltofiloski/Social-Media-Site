-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2021 at 06:39 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homework3`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `postStatus` varchar(255) NOT NULL,
  `postType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `title`, `content`, `postStatus`, `postType`) VALUES
(1, 1, 'CSRF test', 'Decoy text . &#60;img src=&#34;youtube.com&#34; width=&#34;0&#34; height=&#34;0&#34; /&#62;', 'public', 'text'),
(2, 2, 'nto image', '1259083589', 'private', 'img'),
(3, 3, 'Me and the boys', '701182665', 'public', 'img'),
(4, 3, 'A song', 'I am sorry Ms. Jackson.', 'public', 'text'),
(6, 4, 'title', '1800862469', 'public', 'img'),
(7, 4, 'Textce', 'sho sakas', 'public', 'text'),
(8, 5, 'Song i like', 'Flip flop rock is good.', 'private', 'text'),
(9, 5, 'With my bro', '191629173', 'public', 'img'),
(10, 5, 'Great pack', '1192017099', 'private', 'img'),
(11, 5, 'Wassup', 'How is everyone', 'public', 'text'),
(12, 5, 'Some more', 'Hey ya', 'public', 'text'),
(13, 6, 'Hello', 'Hello everyone!', 'public', 'text'),
(15, 6, 'Started data mining', '732421807', 'private', 'img'),
(16, 6, 'Georgia', 'Is anyone here from Georgia?', 'public', 'text'),
(17, 6, 'More data mining', '1734146463', 'public', 'img'),
(18, 7, 'Purse', 'That&#39;s my purse!', 'public', 'text'),
(21, 7, 'Diet', '1399489448', 'private', 'img'),
(22, 7, 'Add me', 'I&#39;m new, add me guys!', 'private', 'text'),
(23, 7, 'Hi', 'Hi to everyone here', 'public', 'text'),
(24, 1, 'Did some art', '1305997320', 'private', 'img'),
(25, 1, 'Networking', '901109516', 'private', 'img'),
(26, 3, 'Reposting my bro', '2016915094', 'public', 'img'),
(27, 2, 'MyArea &#62; Facebook', 'This is better than facebook!', 'public', 'text'),
(28, 2, 'Twitter sucks!', 'It is awful', 'public', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(11) NOT NULL,
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`requestID`, `toUser`, `fromUser`) VALUES
(1, 2, 4),
(2, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `friends` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`userID`, `username`, `firstName`, `lastName`, `gender`, `theme`, `friends`) VALUES
(1, 'skiper4e', 'Kiril', 'Tofiloski', 'M', '#ac9cbf,#300d82', 'blank,2,4,3,5,6,7'),
(2, 'stela', 'Stela', 'Umbrella', 'F', '#435581,#637DBB', 'blank,1,6,7'),
(3, 'andre3k', 'Andre', 'Benjamin', 'M', '#f7a6dd,#0008f5', 'blank,4,6,1,5'),
(4, 'peco', 'Peco', 'Pecoto', 'M', '#b3bedb,#124dd9', 'blank,3,1'),
(5, 'bigboi', 'Andre', 'Patton', 'M', '#1a4908,#a1e8a5', 'blank,1,3'),
(6, 'elena', 'Elena', 'Umbrella', 'F', '#ec58ee,#671f75', 'blank,1,2,3'),
(7, 'bobby', 'Bobby', 'Hill', 'M', '#e2dd5a,#e7a108', 'blank,1,2');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`userID`, `username`, `pass`) VALUES
(1, 'skiper4e', '$2y$10$6I/kZIX7Gf1dyLg877xj1.uV4oKk5cZlsNsfYMlpqCQKxAY0o5au6'),
(2, 'stela', '$2y$10$XutwtvrZC71eEVq.40.12OcMC6/wjWfVVKT8EldtWis0cqomcwMQe'),
(3, 'andre3k', '$2y$10$H2rdZs6I82TPZHrtI1ZVAuXdVnyklevECFaJkUUyV/x58mZ6hGJPG'),
(4, 'peco', '$2y$10$ICeN0rsiqZ7AeVeQVmiK0eVRrXq4o6IEAEogu2h4uWe.Dj51S06h.'),
(5, 'bigboi', '$2y$10$pU5e/sKnjUaF.4gDYI2jSum5j6O10fvs0/ggXc2L.3cgXuqGUKP0e'),
(6, 'elena', '$2y$10$Wda2XtEUpwePLgBqYtlTl.ue36y6osBrXp.KCis76sXRLo7pZ9tPG'),
(7, 'bobby', '$2y$10$tF2XX9Xls.2kja3CntBBNeFphVjW7G5dh6kloBhKDObXR35/IJWJi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestID`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
