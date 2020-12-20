-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2019 at 01:20 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `entoneyo`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_log`
--

CREATE TABLE `attendance_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `start_titme` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Administrators', '2', 1516200406),
('Admins', '1', 1478591361),
('Teachers', '5', 1570807613),
('Users', '4', 1570807217),
('Users', '6', 1570893324);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/admin-contact-request/*', 2, NULL, NULL, NULL, 1478591657, 1478591657),
('/admin-dashboard/*', 2, NULL, NULL, NULL, 1478591659, 1478591659),
('/admin-dashboard/error', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-dashboard/index', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-dashboard/login', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-dashboard/logout', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-dashboard/upload', 2, NULL, NULL, NULL, 1570284468, 1570284468),
('/admin-manage-administrators/*', 2, NULL, NULL, NULL, 1478592600, 1478592600),
('/admin-manage-admins/*', 2, NULL, NULL, NULL, 1478592600, 1478592600),
('/admin-manage-assignments/*', 2, NULL, NULL, NULL, 1570811231, 1570811231),
('/admin-manage-attendance-logs/*', 2, NULL, NULL, NULL, 1572967837, 1572967837),
('/admin-manage-class-syllabus/*', 2, NULL, NULL, NULL, 1571563781, 1571563781),
('/admin-manage-classes/*', 2, NULL, NULL, NULL, 1570809084, 1570809084),
('/admin-manage-classes/add-student', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-classes/add-teacher', 2, NULL, NULL, NULL, 1571664211, 1571664211),
('/admin-manage-classes/create', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-classes/delete', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-classes/delete-student', 2, NULL, NULL, NULL, 1571664211, 1571664211),
('/admin-manage-classes/delete-teacher', 2, NULL, NULL, NULL, 1571664211, 1571664211),
('/admin-manage-classes/index', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-classes/update', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-classes/view', 2, NULL, NULL, NULL, 1571664210, 1571664210),
('/admin-manage-iam-in-member/*', 2, NULL, NULL, NULL, 1571585607, 1571585607),
('/admin-manage-iam-in-member/create', 2, NULL, NULL, NULL, 1571657899, 1571657899),
('/admin-manage-iam-in-member/delete', 2, NULL, NULL, NULL, 1571657899, 1571657899),
('/admin-manage-iam-in-member/index', 2, NULL, NULL, NULL, 1571657899, 1571657899),
('/admin-manage-iam-in-member/update', 2, NULL, NULL, NULL, 1571657899, 1571657899),
('/admin-manage-iam-in-member/view', 2, NULL, NULL, NULL, 1571657899, 1571657899),
('/admin-manage-records/*', 2, NULL, NULL, NULL, 1570811225, 1570811225),
('/admin-manage-teacher-uploads/*', 2, NULL, NULL, NULL, 1571061248, 1571061248),
('/admin-manage-teachers/*', 2, NULL, NULL, NULL, 1570275515, 1570275515),
('/admin-manage-user-payments/*', 2, NULL, NULL, NULL, 1571493099, 1571493099),
('/admin-manage-users/*', 2, NULL, NULL, NULL, 1516200031, 1516200031),
('/admin-manage-users/admin-change-password', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/create', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/delete', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/index', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/messages', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/profile', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/update', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-manage-users/view', 2, NULL, NULL, NULL, 1571756511, 1571756511),
('/admin-setting/*', 2, NULL, NULL, NULL, 1478591663, 1478591663),
('/admin-user-dashboard/*', 2, NULL, NULL, NULL, 1571489512, 1571489512),
('/admin-user-dashboard/index', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-user-dashboard/upload', 2, NULL, NULL, NULL, 1571488953, 1571488953),
('/admin-user/*', 2, NULL, NULL, NULL, 1478591667, 1478591667),
('/debug/*', 2, NULL, NULL, NULL, 1478591646, 1478591646),
('/gii/*', 2, NULL, NULL, NULL, 1478591903, 1478591903),
('/gridview/export/*', 2, NULL, NULL, NULL, 1570893401, 1570893401),
('/home/*', 2, NULL, NULL, NULL, 1478591518, 1478591518),
('/rights/*', 2, NULL, NULL, NULL, 1478591639, 1478591639),
('/search/*', 2, NULL, NULL, NULL, 1478591576, 1478591576),
('/uploaded/*', 2, NULL, NULL, NULL, 1478591571, 1478591571),
('Administrators', 1, 'Administrators', NULL, NULL, 1478591095, 1478591095),
('Admins', 1, 'Spring admins', NULL, NULL, 1478591115, 1478591115),
('Guests', 1, 'Website Guests', NULL, NULL, 1478591167, 1478591167),
('Teachers', 1, 'Teachers Role', NULL, NULL, 1570275499, 1570275499),
('Users', 1, NULL, NULL, NULL, 1516199976, 1516199976);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('Administrators', '/admin-contact-request/*'),
('Administrators', '/admin-dashboard/*'),
('Teachers', '/admin-dashboard/*'),
('Users', '/admin-dashboard/error'),
('Users', '/admin-dashboard/login'),
('Users', '/admin-dashboard/logout'),
('Administrators', '/admin-manage-administrators/*'),
('Admins', '/admin-manage-admins/*'),
('Administrators', '/admin-manage-assignments/*'),
('Teachers', '/admin-manage-assignments/*'),
('Administrators', '/admin-manage-attendance-logs/*'),
('Administrators', '/admin-manage-class-syllabus/*'),
('Teachers', '/admin-manage-class-syllabus/*'),
('Administrators', '/admin-manage-classes/*'),
('Teachers', '/admin-manage-classes/index'),
('Teachers', '/admin-manage-classes/view'),
('Administrators', '/admin-manage-iam-in-member/index'),
('Teachers', '/admin-manage-iam-in-member/index'),
('Administrators', '/admin-manage-iam-in-member/view'),
('Teachers', '/admin-manage-iam-in-member/view'),
('Administrators', '/admin-manage-records/*'),
('Administrators', '/admin-manage-teacher-uploads/*'),
('Teachers', '/admin-manage-teacher-uploads/*'),
('Administrators', '/admin-manage-teachers/*'),
('Administrators', '/admin-manage-user-payments/*'),
('Administrators', '/admin-manage-users/*'),
('Teachers', '/admin-manage-users/index'),
('Teachers', '/admin-manage-users/messages'),
('Teachers', '/admin-manage-users/view'),
('Administrators', '/admin-setting/*'),
('Users', '/admin-user-dashboard/*'),
('Administrators', '/admin-user/*'),
('Admins', '/debug/*'),
('Admins', '/gii/*'),
('Administrators', '/gridview/export/*'),
('Guests', '/home/*'),
('Admins', '/rights/*'),
('Guests', '/search/*'),
('Guests', '/uploaded/*'),
('Admins', 'Administrators');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_number_of_lectures` int(11) DEFAULT NULL,
  `taken_lectures` int(11) DEFAULT '0',
  `minimum_uploads` int(11) DEFAULT NULL,
  `minimum_listening` int(11) DEFAULT NULL,
  `rating` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iam_in_listenings` int(11) DEFAULT NULL,
  `iam_in_uploads` int(11) DEFAULT NULL,
  `show_payment` tinyint(1) DEFAULT NULL,
  `enable_iam_in` tinyint(1) DEFAULT NULL,
  `total_number_of_recording` int(11) DEFAULT NULL,
  `total_number_of_listening` int(11) DEFAULT NULL,
  `listening_duration` int(11) DEFAULT NULL,
  `recording_duration` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_syllabus`
--

CREATE TABLE `class_syllabus` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_request`
--

CREATE TABLE `contact_request` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci,
  `read` tinyint(1) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iam_in_member`
--

CREATE TABLE `iam_in_member` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `listening_count` int(11) DEFAULT NULL,
  `recording_count` int(11) DEFAULT NULL,
  `coming` tinyint(1) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` smallint(1) NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `read` tinyint(1) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1478529159),
('m130524_201442_init', 1478529338),
('m140501_075311_add_oauth2_server', 1516200157),
('m140506_102106_rbac_init', 1478529365),
('m150623_122836_create_profile_table', 1478529338),
('m150817_131954_add_settings_table', 1478529339),
('m150901_130138_create_contact_request_table', 1478529339),
('m171120_132637_add_role_to_user', 1516199517),
('m191004_110052_add_user_profile_table', 1570187646),
('m191005_113226_teacher_profile', 1570275250),
('m191011_153900_add_class__table', 1570808913),
('m191011_162221_add_syllabus_table', 1570811075),
('m191011_162231_add_assignment_table', 1570811075),
('m191014_134525_add_teacher_upload_table', 1571063403),
('m191014_134535_add_student_upload_table', 1571063403),
('m191014_162209_add_student_class', 1571070267),
('m191014_162221_add_teacher_class', 1571070267),
('m191019_130300_alter_user_profile_table', 1571490451),
('m191019_132914_add_payment_table', 1571492413),
('m191020_091402_add_class_syllabus_table', 1571563662),
('m191020_091448_add_messeage_table', 1571563662),
('m191020_133906_student_listening_table', 1571578841),
('m191020_141616_migrate_alter_student_class_table', 1571581319),
('m191020_152706_add_weekly_meeting_member', 1571661149),
('m191024_113620_alter_class_table', 1571917144),
('m191027_154213_alter_class_table', 1572191045),
('m191105_144657_add_attendance_table', 1572966609);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes`
--

CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `client_id` varchar(32) NOT NULL,
  `client_secret` varchar(32) DEFAULT NULL,
  `redirect_uri` varchar(1000) NOT NULL,
  `grant_types` varchar(100) NOT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('testclient', 'testpass', 'http://fake/', 'client_credentials authorization_code password implicit', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_jwt`
--

CREATE TABLE `oauth_jwt` (
  `client_id` varchar(32) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_public_keys`
--

CREATE TABLE `oauth_public_keys` (
  `client_id` varchar(255) NOT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  `private_key` varchar(2000) DEFAULT NULL,
  `encryption_algorithm` varchar(100) DEFAULT 'RS256'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `scope` varchar(2000) NOT NULL,
  `is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `uid`, `name`, `mobile`, `photo`, `date_of_birth`) VALUES
(1, 1, 'Admin', '00962795095511', '55f82b9a080af.png', '2019-10-19'),
(2, 2, 'rabie erfan AL awamleh', '795095511', '5a5f61d64259d.jpg', '1980-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `type` tinyint(1) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_listening`
--

CREATE TABLE `student_listening` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `upload_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_upload`
--

CREATE TABLE `student_upload` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `syllabus`
--

CREATE TABLE `syllabus` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE `teacher_class` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher_profile`
--

INSERT INTO `teacher_profile` (`id`, `uid`, `first_name`, `last_name`, `mobile`) VALUES
(1, 3, 'teacher', 'entoneyo', '+962795095511'),
(2, 5, 'teacher1', 'teacher1', '+962795095511');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_upload`
--

CREATE TABLE `teacher_upload` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(1) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `last_visit` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `df` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `auth_key`, `password_hash`, `password_reset_token`, `activation_code`, `username`, `email`, `status`, `last_visit`, `role`, `created_at`, `updated_at`, `df`) VALUES
(1, '', '$2y$13$.K9f58QPTRsOYd6H/YSiLe/jwSuqZHPnfSI5IQBiUzUOY0nPFXgqu', NULL, '', 'admin', 'admin@hellospring.net', 1, 0, 'Admins', 1478529338, 1570186142, 0),
(2, '2h5O97nGsuqrRapj8SasG_mh9vnzFrny', '$2y$13$RrJ3mVVJWWl9lPvmb7yiTODVurSmv11z5NEuGbD/nvKkf2xY4LVaC', NULL, NULL, 'administrator', 'rabie@hellospring.net', 1, 0, 'Administrators', 1516200406, 1570186217, 0),
(4, 'uJybtefwDjVGMhyuP1ene3OZ5ODnbMDS', '$2y$13$YZduoyuFZNgDH7H0FimTfOeXN3YCuZYXRVFkAIWZs8gMw/on5LRNy', NULL, NULL, 'Test', 'Test@Asdasd.com', 1, 0, 'Users', 1570807217, 1573048001, 0),
(5, 'KatvsrZByR8HVmJmw1OWYcfWivFSRKyU', '$2y$13$W56hd6ak1oOGXbUvee.M..pKxWGmvOjMXq9.GTtcX/ToUqxWhBEle', NULL, NULL, 'teacher1', 'teacher1@test.com', 1, 0, 'Teachers', 1570807613, 1570807613, 0),
(6, '_fKIwWMYX-l86mYxeYz3ROTgF5ErtxSy', '$2y$13$QZYe/YChzHLo0F7bEuDYQOvqEfFwWfQfGpJb8tAnntePqp36tiFui', NULL, NULL, 'test2', 'test2@asd.com', 1, 0, 'Users', 1570893324, 1571490740, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `balance` float DEFAULT NULL,
  `finger_print_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `uid`, `first_name`, `last_name`, `mobile`, `date_of_birth`, `address`, `balance`, `finger_print_id`) VALUES
(1, 4, 'rabie', 'awamleh', '+4940226317458', '2010-02-09', 'Sovereign AIC, Spreestrasse 4\r\nAMM 7658', 100, 1),
(2, 6, 'test', 'user', '+962795095511', '1980-10-14', 'Amman jordan', 280, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_log`
--
ALTER TABLE `attendance_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_class_uid` (`uid`);

--
-- Indexes for table `class_syllabus`
--
ALTER TABLE `class_syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_request`
--
ALTER TABLE `contact_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iam_in_member`
--
ALTER TABLE `iam_in_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`access_token`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`authorization_code`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_jwt`
--
ALTER TABLE `oauth_jwt`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_profile_uid` (`uid`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_setting_table_uid` (`uid`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_listening`
--
ALTER TABLE `student_listening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_upload`
--
ALTER TABLE `student_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `syllabus`
--
ALTER TABLE `syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_upload`
--
ALTER TABLE `teacher_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_teacher_profile_uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_log`
--
ALTER TABLE `attendance_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_syllabus`
--
ALTER TABLE `class_syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact_request`
--
ALTER TABLE `contact_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `iam_in_member`
--
ALTER TABLE `iam_in_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_class`
--
ALTER TABLE `student_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_listening`
--
ALTER TABLE `student_listening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_upload`
--
ALTER TABLE `student_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `syllabus`
--
ALTER TABLE `syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teacher_class`
--
ALTER TABLE `teacher_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teacher_upload`
--
ALTER TABLE `teacher_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_payment`
--
ALTER TABLE `user_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `FK_class_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD CONSTRAINT `oauth_access_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD CONSTRAINT `oauth_authorization_codes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD CONSTRAINT `oauth_refresh_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `FK_profile_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `setting`
--
ALTER TABLE `setting`
  ADD CONSTRAINT `FK_setting_table_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `FK_teacher_profile_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_profile_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
