-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2025 at 08:03 AM
-- Server version: 8.0.42
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dblms`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_key`, `course_description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Art Appreciation', 'GEC1_Art_Appreciation', 'GEC 1 \r\nLecture - 3 Hours\r\nLaboratory - 0 Hours\r\nUnits - 3 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:25:27', '2025-05-18 03:25:27'),
(2, 'Readings in Philippine History', 'GEC2_Readings_in_Philippine_History', 'GEC 2\r\nLecture - 3 Hours\r\nLaboratory - 0 Hours\r\nUnits - 3 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:38:14', '2025-05-18 03:38:14'),
(3, 'Understanding the Self', 'GEC5_Understanding_the_Self', 'GEC 5\r\nLecture - 3 Hours\r\nLaboratory - 0 Hours\r\nUnits - 3 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:39:55', '2025-05-18 03:39:55'),
(4, 'Physical Education 1', 'PE1_Physical_Education_1', 'PE 1\r\nLecture - 2 Hours\r\nLaboratory - 0 Hours\r\nUnits - 2 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:41:30', '2025-05-18 03:41:30'),
(5, 'Introduction to Computing', 'IT111_Introduction_to_Computing', 'IT 111\r\nLecture - 2 Hours\r\nLaboratory - 1 Hours\r\nUnits - 3 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:46:42', '2025-05-18 03:46:42'),
(6, 'Computer Programming 1 (Java)', 'IT112_Computer_Programming_1', 'IT 112\r\nLecture - 2 Hours\r\nLaboratory - 1 Hours\r\nUnits - 3 Units\r\nNo Pre - requisites', 1, '2025-05-18 03:48:25', '2025-05-18 03:48:25'),
(7, 'Web Systems, Technologies and Development', 'IT113_Web_Systems_Technologies_and_Development', 'IT 113\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 03:54:52', '2025-05-18 03:54:52'),
(8, 'Aviation Fundamentals', 'AIT111_Aviation_Fundamentals', 'AIT 111\nLecture - 2 Hours\nLaboratory - 0 Hours\nUnits - 2 Units\nNo Pre - requisites', 1, '2025-05-18 03:59:07', '2025-05-18 03:59:07'),
(9, 'CWTS / ROTC 1', 'NSTP1_CWTS_ROTC_1', 'NSTP 1\nLecture - 0 Hours\nLaboratory - (-9-) Hours\nUnits - (-2-) Units\nNo Pre - requisites', 1, '2025-05-18 04:02:45', '2025-05-18 04:02:45'),
(10, 'Mathematics in Modern World', 'GEC6_Mathematics_in_Modern_World', 'GEC 6\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:05:51', '2025-05-18 04:05:51'),
(11, 'Ethics', 'GEC8_Ethics', 'GEC 8\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:07:11', '2025-05-18 04:07:11'),
(12, 'Physical Education 2', 'PE2_Phyiscal_Education_2', 'PE 2\nLecture - 2 Hours\nLaboratory - 0 Hours\nUnits - 2 Units\nPre - requisites - PE 1', 1, '2025-05-18 04:08:24', '2025-05-18 04:08:24'),
(13, 'Computer Networking 1 (Basic)', 'IT121_Computer_Networking_1', 'IT 121\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:09:45', '2025-05-18 04:09:45'),
(14, 'Computer Programming 2 (Advanced Java)', 'IT122_Computer_Programming_2', 'IT 122\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 112', 1, '2025-05-18 04:12:04', '2025-05-18 04:12:04'),
(15, 'Introduction to Human Computer Interaction', 'IT123_Introduction_to_Human_Computer_Interaction', 'IT 123\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 112', 1, '2025-05-18 04:14:01', '2025-05-18 04:14:01'),
(16, 'Discrete Mathematics', 'IT124_Discrete_Mathematics', 'IT 124\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 112', 1, '2025-05-18 04:15:14', '2025-05-18 04:15:14'),
(17, 'Professional Elective 1', 'AIT_Elec_1_Professional_Elective_1', 'AIT Elec 1\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:17:24', '2025-05-18 04:17:24'),
(18, 'Air Laws and Civil Air Regulations', 'AIT121_Air_Laws_and_Civil_Air_Regulations', 'AIT 121\nLecture - 2 Hours\nLaboratory - 0 Hours\nUnits - 2 Units\nNo Pre - requisites', 1, '2025-05-18 04:19:09', '2025-05-18 04:19:09'),
(19, 'CWTS / ROTC 2', 'NSTP2_CWTS_ROTC_2', 'NSTP 2\nLecture - 0 Hours\nLaboratory - (-9-) Hours\nUnits - (-3) Units\nNo Pre - requisites', 1, '2025-05-18 04:22:32', '2025-05-18 04:22:32'),
(20, 'Purposive Communication', 'GEC4_Purposive_Communication', 'GEC 4\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:24:06', '2025-05-18 04:24:06'),
(21, 'Physical Education 3', 'PE3_Physical_Education_3', 'PE 3\nLecture - 2 Hours\nLaboratory - 0 Hours\nUnits - 2 Units\nPre - requisites - PE 2', 1, '2025-05-18 04:25:49', '2025-05-18 04:25:49'),
(22, 'Computer Networking 2 (Routing)', 'IT211_Computer_Networking_2', 'IT 211\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 121', 1, '2025-05-18 04:27:18', '2025-05-18 04:27:18'),
(23, 'Object Oriented Programming 1 (Java)', 'IT212_Object_Oriented_Programming_1', 'IT 212\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 122', 1, '2025-05-18 04:28:36', '2025-05-18 04:28:36'),
(24, 'Data Structures and Algorithms (Java)', 'IT213_Data_Structures_and_Algorithms', 'IT 213 \nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 122', 1, '2025-05-18 04:30:11', '2025-05-18 04:30:11'),
(25, 'Advanced Web Programming (PHP, MySQL & XML)', 'IT214_Advanced_Web_Programming', 'IT 214\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 113', 1, '2025-05-18 04:31:54', '2025-05-18 04:31:54'),
(26, 'Quantitative Method (Modeling & Simulation)', 'IT215_Quantitative_Method', 'IT 215\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:32:56', '2025-05-18 04:32:56'),
(27, 'Professional Elective 2', 'AIT_Elec_2_Professional_Elective_2', 'AIT Elec 2\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:55:06', '2025-05-18 04:55:06'),
(28, 'Character Building', 'GEI1_Character_Building', 'GEI 1\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:56:37', '2025-05-18 04:56:37'),
(29, 'Enviromental Science', 'GEC11_Environmental_Science', 'GEC 11\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 04:57:23', '2025-05-18 04:57:23'),
(30, 'Physical Education 4', 'PE4_Physical_Education_4', 'PE 4\nLecture - 2 Hours\nLaboratory - 0 Hours\nUnits - 2 Units\nPre - requisites - PE 3', 1, '2025-05-18 04:58:27', '2025-05-18 04:58:27'),
(31, 'Aviation Information Management 1', 'IT221_Aviation_Information_Management_1', 'IT 221\r\nLecture - 2 Hours\r\nLaboratory - 1 Hours\r\nUnits - 3 Units\r\nPre - requisites - IT 214 & IT 212', 1, '2025-05-18 04:59:55', '2025-05-18 04:59:55'),
(32, 'Computer Networking 3 (Switching and VOIP)', 'IT222_Computer_Networking_3', 'IT 222\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 211', 1, '2025-05-18 05:02:10', '2025-05-18 05:02:10'),
(33, 'Aviation Secure Web Development', 'IT223_Aviation_Secure_Web_Development', 'IT 223\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 214', 1, '2025-05-18 05:04:32', '2025-05-18 05:04:32'),
(34, 'Aviation System Requirement Analysis, Design and Quality Assurance', 'IT224_Aviation_System_Requirement_Analysis_Design_and_Quality_Assurance', 'IT 224\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 212 & IT 214 ', 1, '2025-05-18 05:11:02', '2025-05-18 05:11:02'),
(35, 'Professional Elective 3', 'AIT_Elec_3_Professional_Elective_3', 'AIT Elec 3\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:20:41', '2025-05-18 05:20:41'),
(36, 'Life and Works of Rizal', 'GEC9_Life_and_Works_of_Rizal', 'GEC 9\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:22:10', '2025-05-18 05:22:10'),
(37, 'Science Technology & Society', 'GEC3_Science_Technology_&_Society', 'GEC 3\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:23:18', '2025-05-18 05:23:18'),
(38, 'Entrepreneurial Minds', 'GEC10_Entrepreneurial_Minds', 'GEC 10\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:24:09', '2025-05-18 05:24:09'),
(39, 'Aviation Database Systems', 'IT311_Aviation_Database_Systems', 'IT 311\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 221', 1, '2025-05-18 05:26:12', '2025-05-18 05:26:12'),
(40, 'System Integration & Architecture 1', 'IT312_System_Integration_&_Architecture_1', 'IT 312\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - 224', 1, '2025-05-18 05:27:26', '2025-05-18 05:27:26'),
(41, 'Aviation Information Assurance & Security 1', 'IT313_Aviation_Information_Assurance_&_Security_1', 'IT 313\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 224 & IT 222', 1, '2025-05-18 05:30:24', '2025-05-18 05:30:24'),
(42, 'Object Oriented Programming 2', 'IT314_Object_Oriented_Programming_2', 'IT 314\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 212', 1, '2025-05-18 05:32:48', '2025-05-18 05:32:48'),
(43, 'Social and Professional Issues', 'IT315_Social_and_Professional_Issues', 'IT 315\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:33:50', '2025-05-18 05:33:50'),
(44, 'Professional Elective 4', 'AIT_Elec_4_Professional_Elective_4', 'AIT Elec 4\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:34:48', '2025-05-18 05:34:48'),
(45, 'Professional Elective 5', 'AIT_Elec_5_Professional_Elective_5', 'AIT Elec 5\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 05:36:18', '2025-05-18 05:36:18'),
(46, 'Integrative Programming & Technologies', 'IT321_Integrative_Programming_&_Technologies', 'IT 321\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 312', 1, '2025-05-18 05:38:05', '2025-05-18 05:38:05'),
(47, 'Aviation Information Assurance and Security 2', 'IT322_Aviation_Information_Assurance_and_Security_2', 'IT 322\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 313', 1, '2025-05-18 06:17:33', '2025-05-18 06:17:33'),
(48, 'Aviation Application Development and Emerging Technologies', 'IT323_Aviation_Application_Development_and_Emerging_Technologies', 'IT 323\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 311 & IT 312', 1, '2025-05-18 06:19:15', '2025-05-18 06:19:15'),
(49, 'Software Engineering', 'IT324_Software_Engineering', 'IT 324\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 223', 1, '2025-05-18 06:22:55', '2025-05-18 06:22:55'),
(50, 'Multimedia Systems Development', 'IT325_Multimedia_Systems_Development', 'IT 325\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 06:24:01', '2025-05-18 06:24:01'),
(51, 'Aviation Capstone Project 1', 'IT326_Aviation_Capstone_Project_1', 'IT 326\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 311 & IT 312 ', 1, '2025-05-18 06:27:22', '2025-05-18 06:27:22'),
(52, 'Operating System', 'IT327_Operating_System', 'IT 327\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 06:28:57', '2025-05-18 06:28:57'),
(53, 'Philippine Pop Culture', 'GEC12_Philippine_Pop_Culture', 'GEC 12\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 06:31:03', '2025-05-18 06:31:03'),
(54, 'Contemporary World', 'GEC7_Contemporary_World', 'GEC 7\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 06:31:35', '2025-05-18 06:31:35'),
(55, 'Aviation Capstone Project 2', 'IT411_Aviation_Capstone_Project_2', 'IT 411\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 327', 1, '2025-05-18 06:32:42', '2025-05-18 06:32:42'),
(56, 'Aviation System Administration & Maintenance', 'IT412_Aviation_System_Administration_&_Maintenance', 'IT 412\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - 321', 1, '2025-05-18 06:34:02', '2025-05-18 06:34:02'),
(57, 'Project Quality Management System', 'IT413_Project_Quality_Management_System', 'IT 413\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 326', 1, '2025-05-18 06:35:27', '2025-05-18 06:35:27'),
(58, 'Aviation Database Administration', 'IT414_Aviation_Database_Administration', 'IT 414\nLecture - 2 Hours\nLaboratory - 1 Hours\nUnits - 3 Units\nPre - requisites - IT 311', 1, '2025-05-18 06:36:29', '2025-05-18 06:36:29'),
(59, 'Virtualization & Cloud Platforms', 'IT415_Virtualization_&Cloud_Platforms', 'IT 415\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nPre - requisites - IT 311', 1, '2025-05-18 06:37:27', '2025-05-18 06:37:27'),
(60, 'Professional Elective 6', 'AIT_Elec_6_Professional_Elective_6', 'AIT Elec 6\nLecture - 3 Hours\nLaboratory - 0 Hours\nUnits - 3 Units\nNo Pre - requisites', 1, '2025-05-18 06:38:15', '2025-05-18 06:38:15'),
(61, 'Internship / On-the-Job - Training / Practicum', 'IT421_Internship_OJT_Practicum', 'IT 421\nLecture - 0 Hours\nLaboratory - 18 Hours\nUnits - 6 Units\nRequirement - 70% of Course Taken', 1, '2025-05-18 06:40:27', '2025-05-18 06:40:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
