-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2018 at 09:52 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techpalmy`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `ID` int(11) NOT NULL,
  `city` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `region` text,
  `postalcode` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`ID`, `city`, `address1`, `address2`, `region`, `postalcode`, `updated_at`, `created_at`) VALUES
(1, 'Palmerston North', '1/11 Worcester Street', NULL, 'N/A', 4410, '2018-10-06 05:04:09', '2018-10-06 05:04:09'),
(2, 'Palmerston North', '41 The Square', '3rd Floor, the Grand Hotel Building', 'Manawatu', 4410, '2018-10-28 08:16:32', '2018-10-28 08:16:32'),
(3, 'Palmerston North', 'SmoothPay Limited', 'PO Box 20019', 'Manawatu', 4448, '2018-10-28 08:23:34', '2018-10-28 08:23:34'),
(4, 'Palmerston North', '120D The Square', NULL, NULL, 4410, '2018-10-28 08:27:04', '2018-10-28 08:27:04'),
(5, 'Tokyo', 'Tokyo', NULL, NULL, 1111, '2018-10-28 08:28:31', '2018-10-28 08:28:31'),
(6, 'New York City', 'Manhatten', NULL, NULL, 1111, '2018-10-28 08:29:17', '2018-10-28 08:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `website` text NOT NULL,
  `address` int(11) NOT NULL,
  `phone` text NOT NULL,
  `email` text,
  `contact` text,
  `internships` text,
  `description` text NOT NULL,
  `company_size` int(11) DEFAULT NULL,
  `logo` text NOT NULL,
  `tags` text NOT NULL,
  `technology` text NOT NULL,
  `business` text,
  `industry` text NOT NULL,
  `contact_name` text NOT NULL,
  `contact_email` text NOT NULL,
  `contact_number` text NOT NULL,
  `flag` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`ID`, `name`, `website`, `address`, `phone`, `email`, `contact`, `internships`, `description`, `company_size`, `logo`, `tags`, `technology`, `business`, `industry`, `contact_name`, `contact_email`, `contact_number`, `flag`, `updated_at`, `created_at`, `expires_at`) VALUES
(1, 'Levno', 'www.levno.com', 1, '0800 453 866', 'loganmarch2@aol.com', 'Andrew Gray', '1', 'Levno is an Information Technology company; focused on, and a key solution provider in the Agri-tech industry.', 26, 'levno-logo-copy_1540426139.jpg', '1', 'LoRaWAN, NB-IoT, Cloud based solutions & services', 'Key solution provider', 'Agriculture-tech industry', 'Andrew Gray', 'andrew.gray@levno.com', '', 1, '2018-10-25 00:08:59', '2018-10-24 09:38:21', '2019-10-25 00:08:59'),
(2, 'SmoothPay', 'www.smoothpay.co.nz', 3, '06-353 6462', 'helpdesk@smoothpaygold.com', 'Matt Gardner', '0', 'We specialise in creating and supporting full-featured, compliant payroll software systems for southern hemisphere Pacific countries.', 3, 'smoothpay-logo-l_1540426225.png', '1', 'timeclocks, banking systems, Xojo, B4i and B4a', 'Software Product', 'Payroll software systems', 'Matt Gardner', 'info@smoothpay.co.nz', '06-353 64662', 1, '2018-10-28 08:23:58', '2018-10-24 10:06:15', '2019-10-25 00:10:25'),
(3, 'FireCrest', 'www.firecrestsystems.com', 4, '273499703', 'firecrest@example.com', 'Steve', '0', 'Firecrest Systems are your business support team If you have a project, an idea or just want to review your business and get some solutions to improve your I.T. or marketing, get in touch with us.', 5, 'firecrest-logo_1540426178.gif', '1', '.net, AWS, Automation and AI.', 'Software Product', 'Medical, live stream and Financial', 'Steve', 'example@hotmail.com', '2341234', 1, '2018-10-28 08:27:29', '2018-10-24 10:13:20', '2019-10-25 00:09:38'),
(4, 'Trio Technology Limited', 'www.triotech.co.nz', 2, '273499703', 'nick@tritoech.co.nz', 'Jim', '0', 'Trio Technology is a software and technology company offering our software development services in a wide range of platforms and languages.', 8, 'download_1540426067.png', '1', '.net, PHP', 'Software Product', 'Software Development', 'Jim', 'jim@gmail.com', '063734444', 1, '2018-10-28 08:16:58', '2018-10-24 10:21:39', '2019-10-25 00:07:47'),
(10, 'Toyota', 'https://www.toyota-global.com/', 5, '0800 869 682', 'toyata@gmail.com', NULL, '1', 'Toyota Motor Corporation&nbsp;(Japanese:&nbsp;??????????&nbsp;Hepburn:&nbsp;Toyota Jid?sha&nbsp;KK,&nbsp;IPA:&nbsp;[to?jota],&nbsp;English:&nbsp;/t???o?t?/), usually shortened to&nbsp;Toyota, is a Japanese&nbsp;multinational&nbsp;automotive&nbsp;manufacturer headquartered in&nbsp;Toyota, Aichi, Japan. In 2017, Toyota&#39;s corporate structure consisted of 364,445 employees worldwide[6]&nbsp;and, as of September&nbsp;2018, was the&nbsp;sixth-largest company in the world by revenue. As of 2017, Toyota is the world&#39;s second-largest automotive manufacturer. Toyota was the world&#39;s first automobile manufacturer to produce more than 10 million vehicles per year which it has done since 2012, when it also reported the production of its 200-millionth vehicle.[7]&nbsp;As of July&nbsp;2014, Toyota was the largest listed company in Japan by&nbsp;market capitalization&nbsp;(worth more than twice as much as #2-ranked&nbsp;SoftBank)[8]&nbsp;and by revenue.[9][10]\r\n\r\nThe company was founded by&nbsp;Kiichiro Toyoda&nbsp;in 1937, as a spinoff from&nbsp;his father&#39;s&nbsp;company&nbsp;Toyota Industries&nbsp;to create&nbsp;automobiles. Three years earlier, in 1934, while still a department of&nbsp;Toyota Industries, it created its first product, the&nbsp;Type A engine, and its first passenger car in 1936, the&nbsp;Toyota AA. Toyota Motor Corporation produces vehicles under five brands, including the Toyota brand,&nbsp;Hino,&nbsp;Lexus,&nbsp;Ranz, and&nbsp;Daihatsu. It also holds a 16.66% stake in&nbsp;Subaru Corporation, a 5.9% stake in&nbsp;Isuzu, as well as joint-ventures with two in&nbsp;China&nbsp;(GAC Toyota&nbsp;and&nbsp;Sichuan FAW Toyota Motor), one in India (Toyota Kirloskar), one in the&nbsp;Czech Republic&nbsp;(TPCA), along with several &quot;nonautomotive&quot; companies.[12]&nbsp;TMC is part of the&nbsp;Toyota Group, one of the largest conglomerates in Japan.', NULL, 'Origin-of-the-Toyota-Logo_o_1540422173.jpg', '1', 'Cars', 'Sales', 'Cars', 'Jonathon Doghtery', 'doooododo@hotmail.com', '1222222222', 1, '2018-10-28 08:29:47', '2018-10-24 23:02:53', '2019-10-24 23:02:53'),
(11, 'Comcast', 'https://corporate.comcast.com/', 6, '0800 869 682', 'comcast@comcast.net', 'Jonathon Doghtery', '1', 'Comcast Corporation&nbsp;(formerly registered as&nbsp;Comcast Holdings)[note 1]&nbsp;is an American global&nbsp;telecommunications&nbsp;conglomerate&nbsp;headquartered in&nbsp;Philadelphia,&nbsp;Pennsylvania.[9]&nbsp;It is the second-largest&nbsp;broadcasting&nbsp;and&nbsp;cable television&nbsp;company in the world by revenue and the largest pay-TV company, the largest cable TV company and largest home&nbsp;Internet service provider&nbsp;in the United States, and the nation&#39;s third-largest home&nbsp;telephone service provider. Comcast services U.S. residential and commercial customers in 40 states and in the&nbsp;District of Columbia.[10]&nbsp;As the owner of the international media company&nbsp;NBCUniversal&nbsp;since 2011,[11][12][13][14]&nbsp;Comcast is a producer of&nbsp;feature films&nbsp;and&nbsp;television&nbsp;programs intended for theatrical exhibition and over-the-air and cable television broadcast, respectively.', 3, 'cropped-Comcast-Logo-Only-1_1540423568.png', '1', 'Tech', 'Internet', 'Tech', 'Jonathon Doghtery', 'Jonny@hotmail.com', '7322570790', 1, '2018-10-28 08:30:06', '2018-10-24 23:26:08', '2019-10-25 00:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `consultants`
--

CREATE TABLE `consultants` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `website` text NOT NULL,
  `address` text,
  `phone` text NOT NULL,
  `email` text,
  `description` text NOT NULL,
  `terms_and_conditions` int(11) NOT NULL,
  `join_mailing_list` int(11) NOT NULL,
  `logo` text NOT NULL,
  `tags` text NOT NULL,
  `expertise` text NOT NULL,
  `flag` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultants`
--

INSERT INTO `consultants` (`ID`, `name`, `website`, `address`, `phone`, `email`, `description`, `terms_and_conditions`, `join_mailing_list`, `logo`, `tags`, `expertise`, `flag`, `updated_at`, `created_at`, `expires_at`) VALUES
(7, 'Barry Williams', 'www.barrywilliams.com', NULL, '555-0606', 'williams.barryleon@gmail.com', '<p>A university student looking to graduate 2018</p>', 0, 0, 'noimage.jpg', '1', 'Gaming', 0, '2018-10-28 08:34:43', '2018-10-28 08:34:43', '2019-10-28 08:34:43');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `addresses_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `time` time DEFAULT NULL,
  `duration` text,
  `link` text,
  `location` text NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `ID` int(11) NOT NULL,
  `companyID` int(11) DEFAULT NULL,
  `position` text NOT NULL,
  `application_due_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `external_link` text NOT NULL,
  `tags` text NOT NULL,
  `flag` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`ID`, `companyID`, `position`, `application_due_date`, `description`, `external_link`, `tags`, `flag`, `updated_at`, `created_at`, `expires_at`) VALUES
(5, 11, 'TV Analyst', '2018-11-14 11:00:00', '<p>We need a new TV analyst at our head office in New York City.</p>', 'link.com', '1', 1, '2018-10-28 08:35:49', '2018-10-28 08:35:49', '2018-11-28 11:00:00'),
(6, 11, 'Data Communications Expert', '2018-11-14 11:00:00', '<p>We need a data communications expert who is eager and willing.</p>', 'link.com', '1', 1, '2018-10-28 08:37:03', '2018-10-28 08:37:03', '2018-11-28 11:00:00'),
(7, 11, 'Business Manager', '2018-11-15 11:00:00', '<p>We need someone to run our Palmerston North base.</p>', 'comcast.com', '1', 1, '2018-10-28 08:40:45', '2018-10-28 08:40:45', '2018-11-29 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mailinglists`
--

CREATE TABLE `mailinglists` (
  `ID` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `queuejobs`
--

CREATE TABLE `queuejobs` (
  `id` bigint(11) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(11) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `techgroups`
--

CREATE TABLE `techgroups` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL,
  `website` text NOT NULL,
  `email` text,
  `description` text NOT NULL,
  `logo` text NOT NULL,
  `tags` text NOT NULL,
  `flag` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `techgroups`
--

INSERT INTO `techgroups` (`ID`, `name`, `website`, `email`, `description`, `logo`, `tags`, `flag`, `updated_at`, `created_at`, `expires_at`) VALUES
(6, 'Gaming Enthusiasts', 'www.gamingcorner.com', 'gamingcorner@gmail.com', '<p>We are advid fans of games and making them. If you want to stay up to date on all things gaming keep an eye on this group.&nbsp;</p>', 'noimage.jpg', '1', 0, '2018-10-28 08:38:41', '2018-10-28 08:38:41', '2019-10-28 08:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'default',
  `name` tinytext NOT NULL,
  `username` tinytext NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `con_id` int(11) DEFAULT NULL,
  `comp_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `type`, `name`, `username`, `email`, `password`, `con_id`, `comp_id`, `created_at`, `updated_at`, `remember_token`, `email_token`) VALUES
(4, 'verified', 'Barry Williams', '', 'williams.barryleon@gmail.com', '$2y$10$GdkB2DrPBDkH/buD0zdOW.iKOkXqSEmkWjcFRoAfmHkkp2bEz47r6', 7, 11, '2018-10-28 08:38:48', '2018-10-28 08:34:44', 'qeiVKw5p7ukXB435HmpDgdMXU6AqT0cJy5NPbpCZPk37ioVV7eK2dsGZzpDo', NULL),
(29, 'admin', 'Henning Koehler', '', 'henning.koehler.nz@gmail.com', '$2y$10$DEQkeXbdUCwLAoD1yxMpYeYQPiAHuYJakxuc3CSo9Hn5Cso9kHGvy', NULL, NULL, '2018-10-28 08:12:14', '2018-10-28 08:10:33', NULL, 'aGVubmluZy5rb2VobGVyLm56QGdtYWlsLmNvbQ==');

-- --------------------------------------------------------

--
-- Table structure for table `usertechgroups`
--

CREATE TABLE `usertechgroups` (
  `ID` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Tech_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertechgroups`
--

INSERT INTO `usertechgroups` (`ID`, `User_id`, `Tech_id`) VALUES
(5, 4, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `consultants`
--
ALTER TABLE `consultants`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `events_fk0` (`users_id`),
  ADD KEY `events_fk1` (`addresses_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `jobs_fk0` (`companyID`);

--
-- Indexes for table `mailinglists`
--
ALTER TABLE `mailinglists`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Indexes for table `queuejobs`
--
ALTER TABLE `queuejobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue` (`queue`);

--
-- Indexes for table `techgroups`
--
ALTER TABLE `techgroups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `users_fk0` (`con_id`),
  ADD KEY `users_fk1` (`comp_id`);

--
-- Indexes for table `usertechgroups`
--
ALTER TABLE `usertechgroups`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `usertechgroup_fk0` (`User_id`),
  ADD KEY `usertechgroup_fk1` (`Tech_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `consultants`
--
ALTER TABLE `consultants`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queuejobs`
--
ALTER TABLE `queuejobs`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `techgroups`
--
ALTER TABLE `techgroups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `usertechgroups`
--
ALTER TABLE `usertechgroups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_fk1` FOREIGN KEY (`addresses_id`) REFERENCES `addresses` (`ID`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_fk0` FOREIGN KEY (`companyID`) REFERENCES `companies` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk0` FOREIGN KEY (`con_id`) REFERENCES `consultants` (`ID`),
  ADD CONSTRAINT `users_fk1` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`ID`);

--
-- Constraints for table `usertechgroups`
--
ALTER TABLE `usertechgroups`
  ADD CONSTRAINT `usertechgroup_fk0` FOREIGN KEY (`User_id`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `usertechgroup_fk1` FOREIGN KEY (`Tech_id`) REFERENCES `techgroups` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
