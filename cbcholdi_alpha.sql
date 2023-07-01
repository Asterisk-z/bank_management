-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2023 at 06:35 AM
-- Server version: 5.7.42-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbcholdi_alpha`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `contact_email`, `contact_phone`, `address`, `descriptions`, `created_at`, `updated_at`) VALUES
(1, 'Melbourne Branch', 'melboure@cbcholdingsllc.com', NULL, NULL, NULL, '2022-08-16 01:23:03', '2022-08-16 01:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(10,6) NOT NULL,
  `base_currency` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `exchange_rate`, `base_currency`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', 1.000000, 1, 1, NULL, NULL),
(2, 'EUR', 0.983700, 0, 1, NULL, '2022-08-16 02:46:31'),
(3, 'AUD', 0.640000, 0, 1, NULL, '2022-10-07 22:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `database_backups`
--

CREATE TABLE `database_backups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_methods`
--

CREATE TABLE `deposit_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `minimum_amount` decimal(10,2) NOT NULL,
  `maximum_amount` decimal(10,2) NOT NULL,
  `fixed_charge` decimal(10,2) NOT NULL,
  `charge_in_percentage` decimal(10,2) NOT NULL,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposit_methods`
--

INSERT INTO `deposit_methods` (`id`, `name`, `image`, `currency_id`, `minimum_amount`, `maximum_amount`, `fixed_charge`, `charge_in_percentage`, `descriptions`, `status`, `requirements`, `created_at`, `updated_at`) VALUES
(1, 'Payoneer', '1662223354Payoneer_rebrands.jpg', 1, 50.00, 10000000.00, 0.00, 1.00, 'Withdraw Limit ($50.00 - $10,000.00)\r\nWithdraw Charge ($0.00 + 1.00%)', 1, 'null', '2022-09-04 01:42:34', '2022-09-04 01:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_requests`
--

CREATE TABLE `deposit_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `method_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `transaction_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposit_requests`
--

INSERT INTO `deposit_requests` (`id`, `user_id`, `method_id`, `amount`, `description`, `requirements`, `attachment`, `status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 400.00, NULL, 'null', '', 1, NULL, '2022-10-18 00:24:42', '2022-10-18 00:24:42'),
(2, 19, 1, 70.00, NULL, 'null', '1686373402Screenshot 2023-05-23 131255.png', 1, NULL, '2023-06-10 14:03:22', '2023-06-10 14:03:22'),
(3, 19, 1, 1000000.00, 'Testing', 'null', '', 2, 187, '2023-06-18 20:18:46', '2023-06-18 20:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci,
  `sms_body` text COLLATE utf8mb4_unicode_ci,
  `shortcode` text COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(4) NOT NULL DEFAULT '1',
  `sms_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `name`, `slug`, `subject`, `email_body`, `sms_body`, `shortcode`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'Deposit Money', 'DEPOSIT_MONEY', 'Deposit Money', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your account has been credited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your account has been credited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:32:59'),
(2, 'Deposit Request Approved', 'DEPOSIT_REQUEST_APPROVED', 'Deposit Request Approved', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your deposit request has been approved. Your account has been credited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your deposit request has been approved. Your account has been credited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}} {{depositMethod}}', 1, 1, NULL, '2022-08-15 16:32:42'),
(3, 'FDR Request Approved', 'FDR_REQUEST_APPROVED', 'FDR Request Approved', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your FDR request of {{amount}} has been approved on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your FDR request of {{amount}} has been approved on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:32:03'),
(4, 'Loan Request Approved', 'LOAN_REQUEST_APPROVED', 'Loan Request Approved', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your loan request has been approved. Your account has been credited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your loan request has been approved. Your account has been credited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:31:29'),
(5, 'Transfer Request Approved', 'TRANSFER_REQUEST_APPROVED', 'Transfer Request Approved', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your transfer request has been approved. Your account has been debited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your transfer request has been approved. Your account has been debited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:30:47'),
(6, 'Wire Transfer Request Approved', 'WIRE_TRANSFER_REQUEST_APPROVED', 'Wire Transfer Request Approved', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your wire transfer request has been approved. Your account has been debited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your wire transfer request has been approved. Your account has been debited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:30:22'),
(7, 'Withdraw Request Approved', 'WITHDRAW_REQUEST_APPROVED', 'Withdraw Request Approved', '<div>\r\n<div>Dear Customer,</div>\r\n<div>Your withdraw request has been approved. Your account has been debited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your withdraw request has been approved. Your account has been debited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-09-03 15:18:18'),
(8, 'FDR Matured', 'FDR_MATURED', 'FDR Matured', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your FDR is already matured. Your account has been credited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your FDR is already matured. Your account has been credited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:32:19'),
(9, 'Payment Request', 'PAYMENT_REQUEST', 'You have Received New Payment Request', '<div>Dear Sir,</div>\r\n<div>Your have received new payment request of {{amount}} on {{dateTime}}.</div>\r\n<div>&nbsp;</div>\r\n<div>{{payNow}}</div>', 'Dear Sir, Your have received new payment request of {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}} {{payNow}}', 1, 1, NULL, '2022-08-15 16:30:57'),
(10, 'Payment Completed', 'PAYMENT_COMPLETED', 'Payment Completed', '<div>Dear Sir,</div>\r\n<div>Good news, You have received a payment of {{amount}} on {{dateTime}} from {{paidBy}}</div>', 'Dear Sir, Good news, You have received a payment of {{amount}} on {{dateTime}} from {{paidBy}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}} {{paidBy}}', 1, 1, NULL, '2022-08-15 16:31:06'),
(11, 'Deposit Request Rejected', 'DEPOSIT_REQUEST_REJECTED', 'Deposit Request Rejected', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your deposit request of {{amount}} has been rejected.</div>\r\n<div>&nbsp;</div>\r\n<div>Amount:&nbsp;{{amount}}</div>\r\n<div>Deposit Method: {{depositMethod}}</div>\r\n</div>', 'Dear Sir, Your deposit request of {{amount}} has been rejected.', '{{name}} {{email}} {{phone}} {{amount}} {{depositMethod}}', 1, 1, NULL, '2022-08-15 16:32:30'),
(12, 'FDR Request Rejected', 'FDR_REQUEST_REJECTED', 'FDR Request Rejected', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your FDR request has been rejected. Your FDR amount {{amount}} has returned back to your account.</div>\r\n</div>', 'Dear Sir, Your FDR request has been rejected. Your FDR amount {{amount}} has returned back to your account.', '{{name}} {{email}} {{phone}} {{amount}}', 1, 1, NULL, '2022-08-15 16:31:51'),
(13, 'Loan Request Rejected', 'LOAN_REQUEST_REJECTED', 'Loan Request Rejected', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your loan request of {{amount}} has been rejected on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your loan request of {{amount}} has been rejected on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}}', 1, 1, NULL, '2022-08-15 16:31:15'),
(14, 'Transfer Request Rejected', 'TRANSFER_REQUEST_REJECTED', 'Transfer Request Rejected', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your transfer request has been rejected. Your transferred amount {{amount}} has returned back to your account.</div>\r\n</div>', 'Dear Sir, Your transfer request has been rejected. Your transferred amount {{amount}} has returned back to your account.', '{{name}} {{email}} {{phone}} {{amount}}', 1, 1, NULL, '2022-08-15 16:30:39'),
(15, 'Wire Transfer Rejected', 'WIRE_TRANSFER_REJECTED', 'Wire Transfer Rejected', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your wire transfer request has been rejected. Your transferred amount {{amount}} has returned back to your account.</div>\r\n</div>', 'Dear Sir, Your wire transfer request has been rejected. Your transferred amount {{amount}} has returned back to your account.', '{{name}} {{email}} {{phone}} {{amount}}', 1, 1, NULL, '2022-08-15 16:30:30'),
(16, 'Withdraw Request Rejected', 'WITHDRAW_REQUEST_REJECTED', 'Withdraw Request Rejected', '<div>\r\n<div>Dear Sir, Your withdraw request has been rejected. Your transferred amount {{amount}} has returned back to your account.</div>\r\n</div>', 'Dear Sir, Your withdraw request has been rejected. Your transferred amount {{amount}} has returned back to your account.', '{{name}} {{email}} {{phone}} {{amount}}', 1, 1, NULL, '2022-08-15 16:23:25'),
(17, 'Withdraw Money', 'WITHDRAW_MONEY', 'Withdraw Money', '<div>\r\n<div>Dear Sir,</div>\r\n<div>Your account has been debited by {{amount}} on {{dateTime}}</div>\r\n</div>', 'Dear Sir, Your account has been debited by {{amount}} on {{dateTime}}', '{{name}} {{email}} {{phone}} {{amount}} {{dateTime}} {{withdrawMethod}}', 1, 1, NULL, '2022-08-15 16:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2021-08-31 09:06:18', '2021-08-31 09:06:18'),
(2, 1, NULL, '2021-08-31 09:09:26', '2021-08-31 09:09:26'),
(3, 1, NULL, '2021-08-31 09:09:39', '2021-08-31 09:09:39'),
(4, 1, NULL, '2021-09-05 14:47:59', '2021-09-05 14:47:59'),
(5, 1, NULL, '2021-09-05 14:58:05', '2021-09-05 14:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `faq_translations`
--

CREATE TABLE `faq_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faq_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq_translations`
--

INSERT INTO `faq_translations` (`id`, `faq_id`, `locale`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 1, 'English', 'How to open an account?', 'Account opening is very easy. Just need to click Sign Up and enter some initial details for opening account. After that you need to verify your email address and that\'s ready to go.', '2021-08-31 09:07:50', '2021-09-05 14:37:10'),
(2, 2, 'English', 'How to deposit money?', 'You can deposit money via online payment gateway such as PayPal, Stripe, Razorpay, Paystack, Flutterwave as well as BlockChain for bitcoin. You can also deposit money by coming to our office physically.', '2021-08-31 09:09:26', '2021-09-05 14:38:39'),
(3, 3, 'English', 'How to withdraw money from my account?', 'We have different types of withdraw method. You can withdraw money to your bank account as well as your mobile banking account.', '2021-08-31 09:09:39', '2021-09-05 14:47:11'),
(7, 4, 'English', 'How to Apply for Loan?', 'You can apply loan based on your collateral.', '2021-09-05 14:47:59', '2021-09-05 14:47:59'),
(8, 5, 'English', 'How to Apply for Fixed Deposit?', 'If you have available balance in your account then you can apply for fixed deposit.', '2021-09-05 14:58:05', '2021-09-05 14:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `fdrs`
--

CREATE TABLE `fdrs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fdr_plan_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `return_amount` decimal(10,2) NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `approved_date` date DEFAULT NULL,
  `mature_date` date DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `approved_user_id` bigint(20) DEFAULT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fdrs`
--

INSERT INTO `fdrs` (`id`, `fdr_plan_id`, `user_id`, `currency_id`, `deposit_amount`, `return_amount`, `attachment`, `remarks`, `status`, `approved_date`, `mature_date`, `transaction_id`, `approved_user_id`, `created_user_id`, `updated_user_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(3, 4, 7, 2, 2000.00, 2300.00, '', 'Proceeds from FDs will go to the nominee and not to the legal heir of the deceased. However, the nominee gets the money only as a trustee. In case the legal heirs of the deceased claim the money, then the bank will not hold the money to be given to the nominee.', 1, '2022-10-08', '2024-10-08', NULL, 1, 1, NULL, NULL, '2022-10-08 02:57:22', '2022-10-08 02:57:22'),
(5, 2, 9, 2, 56187500.00, 61806250.00, '', NULL, 1, '2022-10-08', '2023-05-08', NULL, 1, 1, NULL, NULL, '2022-10-08 03:16:14', '2022-10-08 03:16:14'),
(6, 4, 9, 2, 36786573.00, 42304558.95, '', 'Proceeds from FDs will go to the nominee and not to the legal heir of the deceased. However, the nominee gets the money only as a trustee. In case the legal heirs of the deceased claim the money, then the bank will not hold the money to be given to the nominee.', 1, '2022-10-08', '2024-10-08', NULL, 1, 1, NULL, NULL, '2022-10-08 03:22:33', '2022-10-08 03:22:33'),
(7, 3, 9, 2, 76453261.00, 87921250.15, '', 'Proceeds from FDs will go to the nominee and not to the legal heir of the deceased. However, the nominee gets the money only as a trustee. In case the legal heirs of the deceased claim the money, then the bank will not hold the money to be given to the nominee.', 1, '2022-10-08', '2023-07-08', NULL, 1, 1, NULL, NULL, '2022-10-08 03:24:07', '2022-10-08 03:24:07'),
(8, 1, 9, 2, 68732543.00, 74231146.44, '', 'Proceeds from FDs will go to the nominee and not to the legal heir of the deceased. However, the nominee gets the money only as a trustee. In case the legal heirs of the deceased claim the money, then the bank will not hold the money to be given to the nominee.', 1, '2022-10-08', '2024-03-08', NULL, 1, 1, NULL, NULL, '2022-10-08 03:25:01', '2022-10-08 03:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `fdr_plans`
--

CREATE TABLE `fdr_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_amount` decimal(10,2) NOT NULL,
  `maximum_amount` decimal(10,2) NOT NULL,
  `interest_rate` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `duration_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fdr_plans`
--

INSERT INTO `fdr_plans` (`id`, `name`, `minimum_amount`, `maximum_amount`, `interest_rate`, `duration`, `duration_type`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Inheritance', 10.00, 99999999.99, 8.00, 17, 'month', 1, NULL, '2021-08-09 13:34:14', '2022-10-08 03:25:45'),
(2, 'Inheritance', 100.00, 99999999.99, 10.00, 7, 'month', 1, NULL, '2021-09-05 12:39:11', '2022-10-08 03:25:35'),
(3, 'Inheritance', 500.00, 99999999.99, 15.00, 9, 'month', 1, NULL, '2021-09-05 12:40:06', '2022-10-08 03:25:23'),
(4, 'Inheritance', 100.00, 99999999.99, 15.00, 2, 'year', 1, 'Proceeds from FDs will go to the nominee and not to the legal heir of the deceased. However, the nominee gets the money only as a trustee. In case the legal heirs of the deceased claim the money, then the bank will not hold the money to be given to the nominee.', '2022-10-08 02:55:04', '2022-10-08 03:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` bigint(20) DEFAULT NULL,
  `used_at` datetime DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_cards`
--

INSERT INTO `gift_cards` (`id`, `code`, `currency_id`, `amount`, `status`, `user_id`, `used_at`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, '83ML-16L4-3F67-F93F', 1, 100.00, 1, 19, '2023-06-18 21:26:12', NULL, '2023-06-18 20:25:57', '2023-06-18 20:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_product_id` bigint(20) UNSIGNED NOT NULL,
  `borrower_id` bigint(20) UNSIGNED NOT NULL,
  `first_payment_date` date NOT NULL,
  `release_date` date DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `applied_amount` decimal(10,2) NOT NULL,
  `total_payable` decimal(10,2) DEFAULT NULL,
  `total_paid` decimal(10,2) DEFAULT NULL,
  `late_payment_penalties` decimal(10,2) NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `approved_date` date DEFAULT NULL,
  `approved_user_id` bigint(20) DEFAULT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_collaterals`
--

CREATE TABLE `loan_collaterals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collateral_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_price` decimal(10,2) NOT NULL,
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_payments`
--

CREATE TABLE `loan_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) NOT NULL,
  `paid_at` date NOT NULL,
  `late_penalties` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `amount_to_pay` decimal(10,2) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `repayment_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_products`
--

CREATE TABLE `loan_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum_amount` decimal(10,2) NOT NULL,
  `maximum_amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `interest_rate` decimal(10,2) NOT NULL,
  `interest_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` int(11) NOT NULL,
  `term_period` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_products`
--

INSERT INTO `loan_products` (`id`, `name`, `minimum_amount`, `maximum_amount`, `description`, `interest_rate`, `interest_type`, `term`, `term_period`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Student Loan', 100.00, 1000.00, NULL, 5.00, 'flat_rate', 24, '+1 month', 1, '2021-08-09 10:06:19', '2021-08-10 06:47:20'),
(2, 'Business Loan', 1000.00, 100000.00, NULL, 12.00, 'mortgage', 12, '+1 month', 1, '2021-08-09 10:05:37', '2021-08-10 06:47:10'),
(3, 'Enterprise Loan', 5000.00, 50000.00, NULL, 12.00, 'mortgage', 36, '+1 month', 1, '2021-09-05 12:42:11', '2021-09-05 12:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayments`
--

CREATE TABLE `loan_repayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) NOT NULL,
  `repayment_date` date NOT NULL,
  `amount_to_pay` decimal(10,2) NOT NULL,
  `penalty` decimal(10,2) NOT NULL,
  `principal_amount` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_11_12_152015_create_email_templates_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_09_01_080940_create_settings_table', 1),
(6, '2020_07_02_145857_create_database_backups_table', 1),
(7, '2020_07_06_142817_create_roles_table', 1),
(8, '2020_07_06_143240_create_permissions_table', 1),
(9, '2021_03_22_071324_create_setting_translations', 1),
(10, '2021_07_02_145504_create_pages_table', 1),
(11, '2021_07_02_145952_create_page_translations_table', 1),
(12, '2021_08_06_104648_create_branches_table', 1),
(13, '2021_08_07_100944_create_other_banks_table', 1),
(14, '2021_08_07_111236_create_currency_table', 1),
(15, '2021_08_08_132702_create_payment_gateways_table', 1),
(16, '2021_08_08_152535_create_deposit_methods_table', 1),
(17, '2021_08_08_164152_create_withdraw_methods_table', 1),
(18, '2021_08_09_064023_create_transactions_table', 1),
(19, '2021_08_09_132854_create_fdr_plans_table', 1),
(20, '2021_08_10_075622_create_gift_cards_table', 1),
(21, '2021_08_10_095536_create_fdrs_table', 1),
(22, '2021_08_10_102503_create_support_tickets_table', 1),
(23, '2021_08_10_102527_create_support_ticket_messages_table', 1),
(24, '2021_08_20_092846_create_payment_requests_table', 1),
(25, '2021_08_20_150101_create_deposit_requests_table', 1),
(26, '2021_08_20_160124_create_withdraw_requests_table', 1),
(27, '2021_08_23_160216_create_notifications_table', 1),
(28, '2021_08_31_070908_create_services_table', 1),
(29, '2021_08_31_071002_create_service_translations_table', 1),
(30, '2021_08_31_075115_create_news_table', 1),
(31, '2021_08_31_075125_create_news_translations_table', 1),
(32, '2021_08_31_094252_create_faqs_table', 1),
(33, '2021_08_31_094301_create_faq_translations_table', 1),
(34, '2021_08_31_101309_create_testimonials_table', 1),
(35, '2021_08_31_101319_create_testimonial_translations_table', 1),
(36, '2021_08_31_201125_create_navigations_table', 1),
(37, '2021_08_31_201126_create_navigation_items_table', 1),
(38, '2021_08_31_201127_create_navigation_item_translations_table', 1),
(39, '2021_09_04_142110_create_teams_table', 1),
(40, '2021_10_04_082019_create_loan_products_table', 1),
(41, '2021_10_06_070947_create_loans_table', 1),
(42, '2021_10_06_071153_create_loan_collaterals_table', 1),
(43, '2021_10_09_110842_add_2fa_columns_to_users_table', 1),
(44, '2021_10_12_071843_add_allow_withdrawal_to_users_table', 1),
(45, '2021_10_12_104151_create_loan_repayments_table', 1),
(46, '2021_10_14_065743_create_loan_payments_table', 1),
(47, '2021_10_22_070458_create_email_sms_templates_table', 1),
(48, '2022_02_01_071417_add_account_number_to_users_table', 1),
(49, '2022_02_10_053301_add_document_verified_at_to_users_table', 1),
(50, '2022_02_10_063611_create_user_documents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE `navigations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Primary Menu', 1, '2021-08-31 10:11:31', '2021-08-31 10:11:31'),
(2, 'Quick Explore', 1, '2021-08-31 17:11:36', '2021-08-31 17:11:36'),
(3, 'Pages', 1, '2021-08-31 17:11:43', '2021-09-04 15:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_items`
--

CREATE TABLE `navigation_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `navigation_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `css_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_items`
--

INSERT INTO `navigation_items` (`id`, `navigation_id`, `type`, `page_id`, `url`, `icon`, `target`, `parent_id`, `position`, `status`, `css_class`, `css_id`, `created_at`, `updated_at`) VALUES
(6, 1, 'dynamic_url', NULL, '/', NULL, '_self', NULL, 1, 1, NULL, NULL, '2021-08-31 16:17:46', '2021-08-31 16:28:52'),
(7, 1, 'dynamic_url', NULL, '/about', NULL, '_self', NULL, 2, 1, NULL, NULL, '2021-08-31 16:17:58', '2021-08-31 16:28:52'),
(8, 1, 'dynamic_url', NULL, '/services', NULL, '_self', NULL, 3, 1, NULL, NULL, '2021-08-31 16:18:44', '2021-08-31 16:28:52'),
(10, 1, 'dynamic_url', NULL, 'faq', NULL, '_self', NULL, 4, 1, NULL, NULL, '2021-08-31 16:19:27', '2021-09-04 15:20:28'),
(11, 1, 'dynamic_url', NULL, '/contact', NULL, '_self', NULL, 5, 1, NULL, NULL, '2021-08-31 16:19:43', '2021-09-04 15:20:28'),
(15, 2, 'dynamic_url', NULL, '/contact', NULL, '_self', NULL, 1, 1, NULL, NULL, '2021-08-31 17:12:42', '2021-09-04 15:22:17'),
(20, 2, 'dynamic_url', NULL, '/about', NULL, '_self', NULL, 2, 1, NULL, NULL, '2021-09-04 15:21:32', '2021-09-04 15:22:17'),
(21, 2, 'dynamic_url', NULL, '/services', NULL, '_self', NULL, 3, 1, NULL, NULL, '2021-09-04 15:22:06', '2021-09-04 15:22:17'),
(22, 3, 'page', 2, NULL, NULL, '_self', NULL, 2, 1, NULL, NULL, '2021-09-04 15:22:58', '2021-09-04 15:23:26'),
(23, 3, 'page', 1, NULL, NULL, '_self', NULL, 1, 1, NULL, NULL, '2021-09-04 15:23:10', '2021-09-04 15:23:26'),
(24, 3, 'dynamic_url', NULL, '/faq', NULL, '_self', NULL, 3, 1, NULL, NULL, '2021-09-04 15:23:20', '2021-09-04 15:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_item_translations`
--

CREATE TABLE `navigation_item_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `navigation_item_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_item_translations`
--

INSERT INTO `navigation_item_translations` (`id`, `navigation_item_id`, `locale`, `name`, `created_at`, `updated_at`) VALUES
(6, 6, 'English', 'Home', '2021-08-31 16:17:46', '2021-08-31 16:17:46'),
(7, 7, 'English', 'About', '2021-08-31 16:17:58', '2021-08-31 16:17:58'),
(8, 8, 'English', 'Services', '2021-08-31 16:18:44', '2021-08-31 16:18:44'),
(10, 10, 'English', 'FAQ', '2021-08-31 16:19:27', '2021-08-31 16:19:27'),
(11, 11, 'English', 'Contact', '2021-08-31 16:19:43', '2021-08-31 16:19:43'),
(15, 15, 'English', 'Contact', '2021-08-31 17:12:42', '2021-09-04 15:22:15'),
(26, 20, 'English', 'About', '2021-09-04 15:21:32', '2021-09-04 15:21:32'),
(27, 21, 'English', 'Services', '2021-09-04 15:22:06', '2021-09-04 15:22:06'),
(28, 22, 'English', 'Terms & Condition', '2021-09-04 15:22:58', '2021-09-04 15:22:58'),
(29, 23, 'English', 'Privacy Policy', '2021-09-04 15:23:10', '2021-09-04 15:23:10'),
(30, 24, 'English', 'FAQ', '2021-09-04 15:23:20', '2021-09-04 15:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_translations`
--

CREATE TABLE `news_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('d49805c5-aa7f-4ff6-b5a9-b7be472e746c', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your account has been credited by $70,000,000.00 on 2022-08-16 00:00\"}', '2022-08-16 01:45:02', '2022-08-16 01:43:55', '2022-08-16 01:45:02'),
('c2141aea-cbad-41fd-8f95-6b33d17843c1', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your account has been credited by $2,000,000.00 on 2022-08-16 00:00\"}', '2022-08-16 01:44:58', '2022-08-16 01:44:11', '2022-08-16 01:44:58'),
('e1ee91c1-eec2-4d83-a64c-078c91f18cac', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $1,030.00 on 2022-08-16 02:54\"}', NULL, '2022-08-16 01:55:29', '2022-08-16 01:55:29'),
('ddcdad74-d83d-4bc9-b8bc-13be6ad164fe', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $1,030.00 on 2022-08-16 03:21 AM\"}', '2022-08-16 03:43:28', '2022-08-16 02:33:07', '2022-08-16 03:43:28'),
('5fe80c70-11b6-43a3-8fae-562ceae74262', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $1,030.00 on 2022-08-16 03:11 AM\"}', '2022-08-16 03:43:24', '2022-08-16 02:33:49', '2022-08-16 03:43:24'),
('a8e79460-40de-4a16-ac96-02f4c0895ef5', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 2, '{\"message\":\"Dear Sir, Your account has been credited by $2,670,900.00 on 2022-08-16 00:00\"}', '2022-08-16 03:42:10', '2022-08-16 03:40:53', '2022-08-16 03:42:10'),
('7e7b3e32-0912-4b06-be09-d617f71d9221', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 3, '{\"message\":\"Dear Sir, Your account has been credited by $70,000,000.00 on 2022-08-16 00:00\"}', NULL, '2022-08-16 03:50:15', '2022-08-16 03:50:15'),
('ce74c579-4a24-4b7c-85bc-a6bc8aa605c3', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 3, '{\"message\":\"Dear Sir, Your account has been credited by $4,566,780.00 on 2022-08-16 04:03\"}', NULL, '2022-08-16 03:52:43', '2022-08-16 03:52:43'),
('6edb96d7-2d41-4434-876d-57e9b70a9e30', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 3, '{\"message\":\"Dear Sir, Your account has been debited by $26,000.00 on 2022-08-16 12:02\"}', NULL, '2022-08-16 03:55:42', '2022-08-16 03:55:42'),
('a59b5ca9-2bfb-4b0e-8b3d-4eca1cddea21', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 3, '{\"message\":\"Dear Sir, Your account has been debited by $47,650.00 on 2022-08-16 02:00\"}', '2022-08-16 04:03:13', '2022-08-16 03:57:01', '2022-08-16 04:03:13'),
('3783ffee-e84c-4b6b-a79d-602c43a62fa0', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 3, '{\"message\":\"Dear Sir, Your account has been debited by $30,600.00 on 2021-05-04 15:00\"}', '2022-08-16 04:03:13', '2022-08-16 04:02:03', '2022-08-16 04:03:13'),
('94d19349-c36f-4c73-812f-40c9cb5d6c71', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 4, '{\"message\":\"Dear Sir, Your account has been credited by $358,450.00 on 2006-06-20 02:06\"}', '2022-09-04 00:46:33', '2022-09-04 00:41:28', '2022-09-04 00:46:33'),
('6e6170a0-c1be-4769-b5da-163aa37cae5e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 4, '{\"message\":\"Dear Sir, Your account has been credited by $32,000,000.00 on 2006-06-21 03:01\"}', '2022-09-04 00:46:30', '2022-09-04 00:44:30', '2022-09-04 00:46:30'),
('e670e7b4-8fa1-4d6a-849a-9691d63cf70e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 4, '{\"message\":\"Dear Sir, Your account has been credited by $1,508,000.00 on 2022-09-03 12:08\"}', '2022-09-04 00:56:31', '2022-09-04 00:54:25', '2022-09-04 00:56:31'),
('792bbfaa-fbd3-42d8-a55e-8aedb25608e0', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 4, '{\"message\":\"Dear Sir, Your account has been debited by $500,000.00 on 2022-09-03 00:00\"}', NULL, '2022-09-04 00:56:57', '2022-09-04 00:56:57'),
('74dec4cc-28dd-49d3-a84b-45f4b5e2555e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been credited by $878,000.00 on 2010-02-16 12:14\"}', '2022-09-04 01:03:56', '2022-09-04 01:02:49', '2022-09-04 01:03:56'),
('df0a2c46-1245-4fe5-9975-fea34fc48864', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been credited by $31,000,000.00 on 2010-08-31 03:07\"}', '2022-09-04 01:03:54', '2022-09-04 01:03:38', '2022-09-04 01:03:54'),
('f39043c8-b293-47e5-9788-9616299bf380', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been debited by $87,800.00 on 2010-02-16 12:19\"}', '2022-09-04 01:10:41', '2022-09-04 01:08:32', '2022-09-04 01:10:41'),
('e372f6bf-3def-45e0-9c86-fd98b15c2cc6', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been debited by $31,000.00 on 2010-08-31 03:16\"}', '2022-09-04 01:10:39', '2022-09-04 01:10:14', '2022-09-04 01:10:39'),
('59b11c5d-ddd9-4566-a2d3-7b41f747f7d7', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been credited by $800,000.00 on 2017-04-14 13:18\"}', '2022-09-04 01:16:52', '2022-09-04 01:13:15', '2022-09-04 01:16:52'),
('e40b2c75-c8bb-41c3-828a-3ebd5f4c4b2d', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been credited by $1,625,110.00 on 2021-01-05 12:14\"}', '2022-09-04 01:16:51', '2022-09-04 01:15:15', '2022-09-04 01:16:51'),
('32990cc3-a32c-4adf-be2e-f209300887ad', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $404,000.00 on 2022-09-04 02:22\"}', '2022-09-04 01:23:20', '2022-09-04 01:23:01', '2022-09-04 01:23:20'),
('d5aaa808-c378-43c2-9c53-91d50b3d1a0c', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your account has been debited by $1,000.00 on 2022-09-01 14:17\"}', '2022-09-04 01:24:23', '2022-09-04 01:24:13', '2022-09-04 01:24:23'),
('78543bb7-0810-4e14-b801-9425022db886', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $25,250.00 on 2022-10-05 13:17\"}', NULL, '2022-10-05 12:23:58', '2022-10-05 12:23:58'),
('37085199-bca1-4715-a164-2f59941b3d7f', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $18,000,000.00 on 2019-01-17 17:11\"}', NULL, '2022-10-05 22:25:20', '2022-10-05 22:25:20'),
('aa734146-c654-4136-b244-0d6a60adab44', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac7,500,000.00 on 2017-04-20 14:13\"}', NULL, '2022-10-05 22:26:43', '2022-10-05 22:26:43'),
('ba960835-50ce-4b4b-b787-bf4292ed55c1', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-01-01 00:00\"}', NULL, '2022-10-05 22:29:51', '2022-10-05 22:29:51'),
('9c62316a-4acd-4eea-80e6-d12ac8a95930', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-02-15 13:32\"}', NULL, '2022-10-05 22:31:25', '2022-10-05 22:31:25'),
('6e970989-59d9-45a8-80d6-f8a767945902', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-03-15 13:53\"}', NULL, '2022-10-05 22:32:07', '2022-10-05 22:32:07'),
('c0ba7ac7-34ce-47c1-98c3-aa66dd02b10b', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-04-19 12:18\"}', NULL, '2022-10-05 22:32:50', '2022-10-05 22:32:50'),
('84f3bb7b-2677-4dad-a309-48be29f32f41', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-05-17 13:00\"}', NULL, '2022-10-05 22:33:24', '2022-10-05 22:33:24'),
('93d4dad3-44fd-411c-a13b-67834fcddc56', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-06-13 13:00\"}', NULL, '2022-10-05 22:34:05', '2022-10-05 22:34:05'),
('1f6b3952-ec9c-475f-924b-310c71f91d9a', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-07-18 13:15\"}', NULL, '2022-10-05 22:34:40', '2022-10-05 22:34:40'),
('2320f227-a2f0-4334-97ed-1ebee45191f7', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-08-23 14:57\"}', '2023-02-09 10:54:26', '2022-10-05 22:35:34', '2023-02-09 10:54:26'),
('2a653dfb-f346-42b3-95c8-09c6f824d265', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-09-21 17:00\"}', '2023-03-10 14:52:15', '2022-10-05 22:36:05', '2023-03-10 14:52:15'),
('84658704-69fe-4a53-9f5b-d1df7601dc0b', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-09-27 15:51\"}', '2023-02-09 10:54:45', '2022-10-05 22:36:42', '2023-02-09 10:54:45'),
('176ff4c0-d429-46b7-8981-7df6b2bfdc38', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-10-26 14:15\"}', '2023-02-09 10:54:38', '2022-10-05 22:37:18', '2023-02-09 10:54:38'),
('c301e88a-e246-404d-8dfa-08cd5cd5281b', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $500.00 on 2017-12-14 16:11\"}', '2023-03-24 11:35:57', '2022-10-05 22:37:45', '2023-03-24 11:35:57'),
('2a4babcb-73ce-46cb-9d07-d7e354b12051', 'App\\Notifications\\RejectTransferRequest', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your transfer request has been rejected. Your transferred amount $2,000.00 has returned back to your account.\"}', '2023-03-24 11:36:02', '2022-10-05 22:56:56', '2023-03-24 11:36:02'),
('ab821fea-b3b6-40ae-bc00-37e05cfa22f9', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $190,476.00 on 2019-05-22 10:49\"}', '2023-03-24 11:36:07', '2022-10-05 23:01:50', '2023-03-24 11:36:07'),
('c881f226-cc07-4d11-895f-43af2ada4e38', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $235,900.00 on 2019-10-09 15:52\"}', '2023-03-24 11:36:09', '2022-10-05 23:02:59', '2023-03-24 11:36:09'),
('2a0f31de-1d29-4634-8e3f-f8edb34257ea', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $160,750.00 on 2019-10-21 16:13\"}', '2023-03-24 11:36:12', '2022-10-05 23:04:00', '2023-03-24 11:36:12'),
('ab82c6d8-6d14-4f20-a362-74c603988753', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $220,700.00 on 2019-06-10 14:16\"}', '2023-03-24 11:36:16', '2022-10-05 23:05:50', '2023-03-24 11:36:16'),
('39607d1b-ecf1-40d5-90da-8e5183822ead', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $210,750.00 on 2019-08-20 14:15\"}', '2023-03-24 11:36:18', '2022-10-05 23:08:52', '2023-03-24 11:36:18'),
('6328a615-0c0e-465c-b361-d86e49089a62', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $29,575,836.00 on 2012-06-13 14:17\"}', '2023-03-24 11:35:41', '2022-10-05 23:37:56', '2023-03-24 11:35:41'),
('8477293e-bdcb-49e7-872f-076fa57066c8', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac36,254,460.00 on 2012-08-14 12:44\"}', '2023-03-24 11:36:24', '2022-10-05 23:39:57', '2023-03-24 11:36:24'),
('50b23a7a-11f7-413a-a16d-9a4aee5041d2', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by $3,500.00 on 2018-10-17 11:52\"}', '2023-03-24 11:35:47', '2022-10-05 23:44:40', '2023-03-24 11:35:47'),
('cae8cf05-4965-48f5-8c94-2f21c7b9f123', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by $2,720.00 on 2018-05-15 13:52\"}', '2023-03-19 09:49:51', '2022-10-05 23:47:04', '2023-03-19 09:49:51'),
('38a6ed80-adc4-4e64-9396-43977e7fd1e3', 'App\\Notifications\\PaymentRequest', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your have received new payment request of $1,000.00 on 2022-10-06 04:42\"}', '2022-10-06 03:43:47', '2022-10-06 03:42:37', '2022-10-06 03:43:47'),
('6d877b28-70fc-419e-a756-5b2f8e31a119', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $429,250.00 on 2022-10-06 05:52\"}', NULL, '2022-10-06 05:53:15', '2022-10-06 05:53:15'),
('5015de78-460f-4d08-b30c-d53e0fd8d7fd', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your account has been credited by $31,000,000.00 on 2021-03-24 15:12\"}', NULL, '2022-10-07 22:22:42', '2022-10-07 22:22:42'),
('60a3cca2-8b30-4486-926b-51b9e6e128b2', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your account has been credited by $23,000.00 on 2019-05-06 16:10\"}', NULL, '2022-10-07 22:25:27', '2022-10-07 22:25:27'),
('b028b7c1-fa45-4dde-8ba9-3de35e0c69fa', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your account has been credited by $870,000.00 on 2019-06-18 11:16\"}', NULL, '2022-10-07 22:25:59', '2022-10-07 22:25:59'),
('0a6e1e7b-f38d-4781-80be-c8f903624c07', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $25,250.00 on 2022-10-07 23:43\"}', NULL, '2022-10-08 01:33:49', '2022-10-08 01:33:49'),
('5cd7fb28-d41e-4182-9c23-32c1ce5095de', 'App\\Notifications\\FDRMatured', 'App\\Models\\User', 7, '{\"message\":\"Dear Sir, Your FDR is already matured. Your account has been credited by \\u20ac110,000.00 on 2022-10-08 02:51\"}', '2022-10-08 02:58:39', '2022-10-08 01:51:25', '2022-10-08 02:58:39'),
('4c144c6a-7302-4ee3-996a-e1a9700afa41', 'App\\Notifications\\ApprovedFDRRequest', 'App\\Models\\User', 7, '{\"message\":\"Dear Sir, Your FDR request of $6,000.00 has been approved on 2022-10-08 03:44\"}', '2022-10-08 02:58:37', '2022-10-08 02:45:25', '2022-10-08 02:58:37'),
('2447e9ea-983b-4dbf-ac1a-d78b3b059aee', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 5, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $43,430.00 on 2022-10-07 23:15\"}', NULL, '2022-10-08 02:59:03', '2022-10-08 02:59:03'),
('0cd65127-1d9c-49e9-ab22-6d05ee6d0759', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $431,270.00 on 2022-10-09 15:39\"}', NULL, '2022-10-09 23:18:56', '2022-10-09 23:18:56'),
('6776ac90-a70b-4f85-92f7-88c24a437d66', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 9, '{\"message\":\"Dear Sir, Your account has been credited by $270.00 on 2021-03-22 00:00\"}', NULL, '2022-10-14 00:26:34', '2022-10-14 00:26:34'),
('9b398d87-a000-4b17-8d4a-adce642a7a85', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 9, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac521.00 on 2021-08-04 17:13\"}', NULL, '2022-10-14 00:27:11', '2022-10-14 00:27:11'),
('a7cdaa84-4dd5-40a5-bbba-06826356aff9', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 9, '{\"message\":\"Dear Sir, Your account has been credited by $169.00 on 2021-11-23 07:17\"}', '2022-10-15 07:12:28', '2022-10-14 00:27:45', '2022-10-15 07:12:28'),
('9758248c-9cb4-4e51-b2e8-4079da33e088', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $43,430.00 on 2022-10-17 13:53\"}', NULL, '2022-10-18 16:15:05', '2022-10-18 16:15:05'),
('ea9cda86-a124-4b72-bcd3-2f88ab3ead17', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac450,000.00 on 2014-12-07 11:54\"}', NULL, '2022-12-08 08:02:19', '2022-12-08 08:02:19'),
('c6d49b5b-9545-492f-a703-430fd9c20e12', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $500,000.00 on 2022-12-08 18:56\"}', NULL, '2022-12-08 08:06:29', '2022-12-08 08:06:29'),
('3e55231b-aad5-4ac5-9d9e-61091851fe63', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $950,000.00 on 2017-12-08 15:31\"}', NULL, '2022-12-08 08:07:38', '2022-12-08 08:07:38'),
('1224953c-8e37-4aae-88d9-e2052331fcae', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac250,000.00 on 2022-08-04 13:43\"}', NULL, '2022-12-08 08:09:09', '2022-12-08 08:09:09'),
('b674b8f5-33db-42ed-89ba-497f8f4a4241', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $9,600,000.00 on 2022-01-17 17:09\"}', NULL, '2022-12-08 08:13:01', '2022-12-08 08:13:01'),
('d1efb540-ea86-4792-8d49-66fd97cea459', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $56,000.00 on 2021-05-06 13:52\"}', NULL, '2022-12-08 08:14:39', '2022-12-08 08:14:39'),
('fbbc6033-a5e2-4a74-8170-e9c569a29e94', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $156,000.00 on 2020-07-01 00:00\"}', NULL, '2022-12-08 08:15:50', '2022-12-08 08:15:50'),
('c8cf83c7-8e74-4d07-887d-54421095708c', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac35,000.00 on 2022-11-14 12:45\"}', NULL, '2022-12-08 08:17:18', '2022-12-08 08:17:18'),
('519b8b1c-07a3-4a5c-934c-3bf74ef5eab9', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $455,000.00 on 2022-09-22 14:55\"}', NULL, '2022-12-08 08:18:36', '2022-12-08 08:18:36'),
('c4d4a28d-17a2-4179-b818-24274869c19a', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $650,000.00 on 2022-12-05 10:33\"}', NULL, '2022-12-08 08:21:25', '2022-12-08 08:21:25'),
('fb14f0b2-54d0-4ade-a41e-f4a7d41b9a7a', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $54,000.00 on 2022-12-08 11:43\"}', NULL, '2022-12-08 12:00:49', '2022-12-08 12:00:49'),
('938f05aa-b3b1-4ea7-826f-6b32d001d3eb', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac14,000.00 on 2021-12-08 14:56\"}', NULL, '2022-12-08 12:01:55', '2022-12-08 12:01:55'),
('57953d34-b343-472a-98c2-d385f704c0af', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $24,000.00 on 2022-12-08 14:13\"}', NULL, '2022-12-08 12:02:45', '2022-12-08 12:02:45'),
('8b8e936d-cc44-4553-82e3-6b0bc36c100e', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $85,000.00 on 2022-12-01 15:51\"}', NULL, '2022-12-08 12:03:38', '2022-12-08 12:03:38'),
('34850a25-33dd-40d9-9e08-e0c914e54f04', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $150,000.00 on 2022-11-23 12:45\"}', NULL, '2022-12-08 12:04:43', '2022-12-08 12:04:43'),
('7a6335c5-d1f7-42b8-8d70-9afdf10f8fa3', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $320,000.00 on 2022-12-08 13:17\"}', NULL, '2022-12-08 12:05:46', '2022-12-08 12:05:46'),
('093fe045-7610-498c-bdd5-8a4aed265c0b', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been credited by $720,000.00 on 2022-09-20 15:45\"}', NULL, '2022-12-08 12:09:26', '2022-12-08 12:09:26'),
('ba84cea7-0fc2-471a-9575-d431774d0a03', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac550,000.00 on 2012-02-14 13:55\"}', '2022-12-14 07:52:49', '2022-12-14 07:35:11', '2022-12-14 07:52:49'),
('36b93943-d93d-4752-89bd-7465ebf4ef5a', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $215,000.00 on 2012-04-12 12:45\"}', '2022-12-14 07:52:46', '2022-12-14 07:36:53', '2022-12-14 07:52:46'),
('a7010922-bd38-4c67-90d4-8a3c15d6d66e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $1,500,000.00 on 2020-07-16 14:33\"}', '2022-12-14 07:52:09', '2022-12-14 07:40:05', '2022-12-14 07:52:09'),
('c55f0da3-9ef5-4c96-a054-7876564ee3c8', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $55,000.00 on 2022-12-13 15:45\"}', '2022-12-14 07:52:38', '2022-12-14 07:41:12', '2022-12-14 07:52:38'),
('8eb28c45-ee5c-41e5-8402-b5d8c61fd3b0', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $2,500,000.00 on 2021-05-25 15:55\"}', '2022-12-14 07:52:33', '2022-12-14 07:42:35', '2022-12-14 07:52:33'),
('0052cb92-9e81-4713-bed4-3d5fa28eacde', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $650,000.00 on 2022-12-13 15:45\"}', '2022-12-14 07:52:17', '2022-12-14 07:43:44', '2022-12-14 07:52:17'),
('04fc79f9-3d28-4be5-963c-60b682404dfb', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 13, '{\"message\":\"Dear Sir, Your account has been credited by $8,500,000.00 on 2010-12-14 13:45\"}', NULL, '2022-12-14 21:36:36', '2022-12-14 21:36:36'),
('6313afae-f217-4d5c-896f-0854a09a0c2e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 13, '{\"message\":\"Dear Sir, Your account has been credited by $4,500.00 on 2022-12-07 00:00\"}', NULL, '2022-12-14 21:37:27', '2022-12-14 21:37:27'),
('9e988b1b-72bc-4682-a4d2-6c5e4b24cea2', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 13, '{\"message\":\"Dear Sir, Your account has been credited by $15,000.00 on 2016-12-20 12:45\"}', NULL, '2022-12-14 21:38:03', '2022-12-14 21:38:03'),
('912f05d3-74c8-4e4b-9eec-db29e343bb81', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 13, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac25,000.00 on 2022-12-14 15:34\"}', NULL, '2022-12-14 21:38:39', '2022-12-14 21:38:39'),
('11fb17dc-c802-4160-81fc-a4db7bf8c4c0', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 13, '{\"message\":\"Dear Sir, Your account has been credited by $11,400.00 on 2022-12-14 16:35\"}', NULL, '2022-12-14 21:39:16', '2022-12-14 21:39:16'),
('034d0a7b-ecb4-4430-8d90-b7336ec98af4', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $120,000.00 on 2022-12-27 00:00\"}', NULL, '2022-12-28 09:22:43', '2022-12-28 09:22:43'),
('c743dadb-7081-4584-aedf-e486f81f8725', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $120,000.00 on 2022-11-14 12:45\"}', NULL, '2022-12-28 09:23:23', '2022-12-28 09:23:23'),
('99f18272-9239-4ed3-a901-0e3fdee5f95d', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac55,000.00 on 2022-11-08 14:43\"}', NULL, '2022-12-28 09:24:37', '2022-12-28 09:24:37'),
('e57b4a28-c47f-4aac-809e-eea538649eb5', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $150,000.00 on 2022-11-13 14:32\"}', NULL, '2022-12-28 09:26:35', '2022-12-28 09:26:35'),
('4270a301-6df5-4a09-83fa-e6615897ad76', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your account has been debited by $100,000.00 on 2022-12-12 15:30\"}', NULL, '2022-12-28 09:28:11', '2022-12-28 09:28:11'),
('a37b7a6b-b398-4e5b-ac76-cc7c76daf206', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $530,250.00 on 2022-12-28 11:00\"}', NULL, '2022-12-28 18:35:10', '2022-12-28 18:35:10'),
('ba885cd6-c1c8-4e5a-8013-7718551c1586', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $79,537.50 on 2022-12-30 19:55\"}', NULL, '2022-12-31 03:39:06', '2022-12-31 03:39:06'),
('7be2ad98-6dcb-4a9e-ab2e-0ba94f48dd0f', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 10, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $207,120.70 on 2023-01-06 19:45\"}', NULL, '2023-01-06 18:56:48', '2023-01-06 18:56:48'),
('a335ad8e-4220-408d-8a6f-aacd24d046d2', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $200,000.00 on 2023-02-13 00:00\"}', NULL, '2023-02-14 07:28:13', '2023-02-14 07:28:13'),
('ad578d04-d303-4571-9d02-b19a19b5270e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $200,000.00 on 2023-02-13 00:00\"}', NULL, '2023-02-14 07:28:18', '2023-02-14 07:28:18'),
('25d9257e-9a14-41e0-98fb-1d4183cd0adc', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $200,000.00 on 2023-02-13 01:00\"}', NULL, '2023-02-14 07:31:25', '2023-02-14 07:31:25'),
('a9fd0899-5cca-4882-8068-bc668f698ef7', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $1,000,000,000.00 on 2022-02-16 10:00\"}', NULL, '2023-02-14 07:33:45', '2023-02-14 07:33:45'),
('82270a2d-054e-4bd5-bb9c-6c99a6fe7e40', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $47,500.00 on 2022-02-17 03:09\"}', NULL, '2023-02-14 07:35:20', '2023-02-14 07:35:20'),
('67e1166e-8c67-4afc-81d1-eb903384b1c2', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $450,000.00 on 2022-03-13 07:00\"}', NULL, '2023-02-14 07:38:13', '2023-02-14 07:38:13'),
('5cf922f8-24d3-4740-a42a-2f572abd1c24', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $1,000,000.00 on 2022-03-20 02:50\"}', NULL, '2023-02-14 07:40:59', '2023-02-14 07:40:59'),
('77bb562c-7830-42f9-98f6-85c3f175ccdc', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $500,000.00 on 2022-03-25 09:00\"}', NULL, '2023-02-14 07:44:05', '2023-02-14 07:44:05'),
('afe9fdd2-a129-4581-96e5-226f3f50211f', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $150,000.00 on 2022-04-01 10:34\"}', NULL, '2023-02-14 07:46:21', '2023-02-14 07:46:21'),
('9e24bb2e-39ea-4641-bb5d-cbe18e81b11b', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $2,000,000.00 on 2023-02-13 00:00\"}', NULL, '2023-02-14 07:47:28', '2023-02-14 07:47:28'),
('896b9b51-fb3e-42b9-ba23-f053c9032ca7', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac5,700,000.00 on 2022-04-11 01:15\"}', NULL, '2023-02-14 07:54:30', '2023-02-14 07:54:30'),
('69c4198c-bd18-4d06-89e1-7e242ff02725', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $10,000,000.00 on 2022-04-15 09:20\"}', NULL, '2023-02-14 07:55:34', '2023-02-14 07:55:34'),
('5331d9b4-95a1-4617-b6b2-b7ee6ab0ab6c', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $3,550,000,000.00 on 2022-04-22 13:00\"}', NULL, '2023-02-14 07:57:37', '2023-02-14 07:57:37'),
('1eac5d81-f092-4440-9816-6a565acde8f1', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $200,000.00 on 2022-04-25 14:09\"}', NULL, '2023-02-14 07:58:57', '2023-02-14 07:58:57'),
('e07307d8-9f52-4263-8e77-313cf72c12bf', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $26,000.00 on 2022-05-13 12:00\"}', NULL, '2023-02-14 08:00:52', '2023-02-14 08:00:52'),
('3d81bb2e-babd-422f-a5b4-efb3c37508e4', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $58,000.00 on 2022-05-20 15:25\"}', NULL, '2023-02-14 08:02:30', '2023-02-14 08:02:30'),
('e7448ee8-e494-4c7b-8998-8109a081cfee', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $350,000.00 on 2022-06-13 12:00\"}', NULL, '2023-02-14 08:04:08', '2023-02-14 08:04:08'),
('40664bfa-b9d9-4af0-a4ef-bf63319236fc', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $200,000.00 on 2022-07-10 00:00\"}', NULL, '2023-02-14 08:31:41', '2023-02-14 08:31:41'),
('270ff1d6-9488-4ba5-995a-5995351ebe36', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $1,000,000.00 on 2022-09-28 00:00\"}', NULL, '2023-02-14 08:36:09', '2023-02-14 08:36:09'),
('83856f91-c83e-4a63-bba5-6628d968a8a1', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $5,000,000.00 on 2023-01-03 00:00\"}', NULL, '2023-02-14 08:37:50', '2023-02-14 08:37:50'),
('acd35331-3bd8-4a58-ae28-74e3e8195af7', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $200,000.00 on 2022-07-10 00:00\"}', NULL, '2023-02-14 08:40:15', '2023-02-14 08:40:15'),
('19ba3d11-d6eb-4707-95ce-b8bbff05ad26', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $100,000.00 on 2022-10-28 00:00\"}', NULL, '2023-02-14 08:43:39', '2023-02-14 08:43:39'),
('ed1abe00-f100-4bd9-82c0-db3eb7b7400d', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been debited by $200,000.00 on 2022-11-30 00:00\"}', NULL, '2023-02-14 08:45:37', '2023-02-14 08:45:37'),
('694fcfe7-275e-4dd8-bc81-f5179a576c9f', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your account has been credited by $350,000.00 on 2023-02-13 00:00\"}', NULL, '2023-02-14 08:51:01', '2023-02-14 08:51:01'),
('31b0e0bc-bcbf-41aa-a40a-d71eb103b515', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 14, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $532,270.00 on 2023-02-17 07:11\"}', NULL, '2023-02-17 07:17:02', '2023-02-17 07:17:02'),
('bbadf3ef-fea6-4996-be9a-d228efdd41f2', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 17, '{\"message\":\"Dear Sir, Your account has been credited by $3,200,000.00 on 2006-09-20 06:02\"}', NULL, '2023-04-14 15:42:21', '2023-04-14 15:42:21'),
('a5bbfe0e-b8df-4c06-92eb-e73794a21b80', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 17, '{\"message\":\"Dear Sir, Your account has been credited by $860,450.00 on 2017-06-07 10:04\"}', NULL, '2023-04-14 15:44:23', '2023-04-14 15:44:23'),
('1ba60e7e-75b4-4b1f-ac68-0875dc2b9594', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 17, '{\"message\":\"Dear Sir, Your account has been credited by $480,000.00 on 2018-11-10 03:50\"}', NULL, '2023-04-14 15:45:46', '2023-04-14 15:45:46'),
('a6690771-7e30-4f54-808f-0c3675b9210f', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $757,500.00 on 2023-04-15 12:14\"}', NULL, '2023-04-15 16:36:25', '2023-04-15 16:36:25'),
('3ebf56f7-cfb4-4616-8207-59cef96235b5', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been credited by $850,000.00 on 2023-04-15 09:53\"}', NULL, '2023-04-15 23:21:36', '2023-04-15 23:21:36'),
('5ab3decf-f0bd-425d-a1e7-b72060cfb261', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac250,000.00 on 2020-04-16 12:28\"}', NULL, '2023-04-16 22:38:58', '2023-04-16 22:38:58'),
('4967f801-1fdd-460c-907b-9f17bb517fa1', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $154,000.00 on 2021-04-08 14:38\"}', NULL, '2023-04-16 22:40:23', '2023-04-16 22:40:23'),
('2d95f167-c344-40b5-8380-fbd186f16678', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac558,000.00 on 2022-04-20 23:43\"}', NULL, '2023-04-16 22:41:06', '2023-04-16 22:41:06'),
('3b77521b-f5f4-4f6a-b65c-84ab58910eed', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $625,000.00 on 2023-04-16 12:54\"}', NULL, '2023-04-16 22:42:03', '2023-04-16 22:42:03'),
('1f3afb4b-6f20-42ef-bc89-70715108a795', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $566,000.00 on 2017-04-16 15:44\"}', NULL, '2023-04-16 22:45:13', '2023-04-16 22:45:13'),
('28e5d8fe-e350-44a0-b10f-d6eadcf728aa', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by \\u20ac745,000.00 on 2022-02-06 00:00\"}', NULL, '2023-04-16 22:46:37', '2023-04-16 22:46:37'),
('896c7b14-66ec-40a9-a8e5-eacea23e06aa', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $50,000.00 on 2023-02-08 00:00\"}', NULL, '2023-04-16 22:47:26', '2023-04-16 22:47:26'),
('224f0b27-13c2-4bca-b89e-ff48e16a486d', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $50,500.00 on 2023-04-17 22:40\"}', NULL, '2023-04-18 12:44:43', '2023-04-18 12:44:43'),
('e493557d-5405-4fe0-aa5d-1f4ebbdf9cb6', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 8, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $25,250.00 on 2023-04-17 00:46\"}', NULL, '2023-04-18 12:45:05', '2023-04-18 12:45:05'),
('6feb260c-58a6-40c9-b9d8-fc3f100c4e70', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-04-20 07:51\"}', NULL, '2023-04-20 07:05:16', '2023-04-20 07:05:16'),
('228f23b9-f53a-458d-ada5-8c3484dbc9ff', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-04-20 16:55\"}', NULL, '2023-04-20 15:56:44', '2023-04-20 15:56:44'),
('43015e26-2b49-4868-9141-e102c7432dc9', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac550,000.00 on 2023-04-27 04:27\"}', NULL, '2023-04-28 20:41:47', '2023-04-28 20:41:47'),
('e5824df6-6a6a-4427-ac27-adb3b62c452d', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been debited by $3,169,000.00 on 2023-04-28 12:02\"}', NULL, '2023-04-28 20:42:31', '2023-04-28 20:42:31'),
('bf264f65-c547-498d-927c-30e46836b665', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 12, '{\"message\":\"Dear Sir, Your account has been debited by $2,500,000.00 on 2023-04-28 09:45\"}', '2023-04-30 00:34:56', '2023-04-28 20:43:21', '2023-04-30 00:34:56'),
('913ef17d-db33-4ac0-b7ba-b225b6b38081', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been credited by $1,800,000.00 on 2022-04-13 00:00\"}', NULL, '2023-05-08 16:58:10', '2023-05-08 16:58:10'),
('c4e40bf2-e3d0-4040-a762-efecd39977b1', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $131,300.00 on 2022-12-14 01:45\"}', NULL, '2023-05-08 16:59:06', '2023-05-08 16:59:06'),
('5ae44537-e6c2-4a13-8eec-110e6d85f34e', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac251,500.57 on 2022-05-07 00:00\"}', NULL, '2023-05-08 17:10:46', '2023-05-08 17:10:46'),
('68108b9b-eff7-4d83-8c5e-ced05950609a', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac31,525.25 on 2023-05-08 00:00\"}', NULL, '2023-05-09 00:32:39', '2023-05-09 00:32:39'),
('dd326cb2-91c6-425d-bade-f497daabc6f4', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac31,525.25 on 2022-09-29 00:00\"}', NULL, '2023-05-09 00:33:12', '2023-05-09 00:33:12'),
('02032986-6870-436f-b345-7cd45824f785', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac12,575.75 on 2022-10-12 00:00\"}', NULL, '2023-05-09 02:54:36', '2023-05-09 02:54:36'),
('ee1f6c4f-4ef7-45b2-8de7-5d63082ebdd5', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac79,750.00 on 2023-05-08 00:00\"}', NULL, '2023-05-09 09:32:22', '2023-05-09 09:32:22'),
('9d2ddf37-eabc-4673-8ef1-867c38ac922d', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac23,850.00 on 2023-05-09 00:00\"}', NULL, '2023-05-09 16:33:01', '2023-05-09 16:33:01'),
('3d4c3109-583d-4b2f-b95e-d9e0160bbc08', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac66,595.55 on 2022-10-08 00:00\"}', NULL, '2023-05-09 16:41:34', '2023-05-09 16:41:34'),
('4988ab02-4922-481e-a28e-795059c9949e', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by $98,350.00 on 2022-11-18 00:00\"}', NULL, '2023-05-09 17:01:45', '2023-05-09 17:01:45'),
('14f6398d-ba51-41d3-9830-90682764581f', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac379,650.00 on 2023-01-02 00:00\"}', NULL, '2023-05-09 17:17:59', '2023-05-09 17:17:59'),
('598afe55-2068-46b8-853a-eb8624d3762b', 'App\\Notifications\\WithdrawMoney', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your account has been debited by \\u20ac17,590.00 on 2023-01-27 00:00\"}', NULL, '2023-05-09 17:18:33', '2023-05-09 17:18:33'),
('60cd45c5-f349-4805-99cf-5218cd116b7a', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $99,262.80 on 2023-05-15 00:37\"}', NULL, '2023-05-14 23:38:26', '2023-05-14 23:38:26'),
('f44d9efc-a051-4c98-9785-fdd7c959fcdd', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $550,000.00 on 2020-02-08 12:56\"}', NULL, '2023-06-09 02:12:00', '2023-06-09 02:12:00'),
('7ab78b10-0213-48d4-ae4c-1b90f26fdc9e', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $50,000.00 on 2019-06-22 16:33\"}', NULL, '2023-06-09 02:12:45', '2023-06-09 02:12:45'),
('ad29571f-25f6-4e93-8e7b-f69036c041fb', 'App\\Notifications\\DepositMoney', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your account has been credited by $850,000.00 on 2018-11-22 00:00\"}', NULL, '2023-06-09 02:13:41', '2023-06-09 02:13:41'),
('7a3d567f-2cca-439b-9b37-ee53cc93a2de', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-06-09 03:28\"}', NULL, '2023-06-09 02:56:05', '2023-06-09 02:56:05'),
('c4152503-3190-46c0-8c44-08d0a340a6e6', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-06-10 07:17\"}', NULL, '2023-06-10 06:18:50', '2023-06-10 06:18:50'),
('dc2de050-7c71-4b7f-a1c3-1401335a208b', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-06-11 05:01\"}', NULL, '2023-06-11 05:18:21', '2023-06-11 05:18:21'),
('9ea695e6-2f85-49e1-81d0-50c459d3df2e', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-06-12 15:01\"}', NULL, '2023-06-12 14:02:35', '2023-06-12 14:02:35'),
('bae7b34a-25be-41de-8ac5-69700fc6f104', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 18, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-06-14 09:04\"}', NULL, '2023-06-14 08:08:52', '2023-06-14 08:08:52'),
('1413b556-640a-4e82-b40c-5b83c87d154f', 'App\\Notifications\\ApprovedDepositRequest', 'App\\Models\\User', 19, '{\"message\":\"Dear Sir, Your deposit request has been approved. Your account has been credited by $990,000.00 on 2023-06-18 21:21\"}', NULL, '2023-06-18 20:21:57', '2023-06-18 20:21:57'),
('5d2f99d4-5c59-45a3-a905-702e22b5e615', 'App\\Notifications\\ApprovedWireTransfer', 'App\\Models\\User', 6, '{\"message\":\"Dear Sir, Your wire transfer request has been approved. Your account has been debited by $101,000.00 on 2023-05-18 20:52\"}', NULL, '2023-06-26 02:44:31', '2023-06-26 02:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `other_banks`
--

CREATE TABLE `other_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `swift_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_currency` bigint(20) NOT NULL,
  `minimum_transfer_amount` decimal(10,2) NOT NULL,
  `maximum_transfer_amount` decimal(10,2) NOT NULL,
  `fixed_charge` decimal(10,2) NOT NULL,
  `charge_in_percentage` decimal(10,2) NOT NULL,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_banks`
--

INSERT INTO `other_banks` (`id`, `name`, `swift_code`, `bank_country`, `bank_currency`, `minimum_transfer_amount`, `maximum_transfer_amount`, `fixed_charge`, `charge_in_percentage`, `descriptions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BANK OF CHINA', 'BKCHCNBJ110', 'China', 1, 50.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-08-16 01:52:14', '2022-08-16 03:21:05'),
(2, 'Commonwealth Bank', 'CTBAAU2S.', 'Australia', 3, 50.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:22:58', '2022-08-16 03:22:58'),
(3, 'Australia and New Zealand Banking Group (ANZ)', 'ANZBAU3MXXX', 'Afghanistan', 1, 50.00, 100000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:23:53', '2022-08-16 03:23:53'),
(4, 'National Australian Bank (NAB)', 'NATAAU3303M', 'Afghanistan', 1, 50.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:24:47', '2022-08-16 03:24:47'),
(5, 'Westpac Bank', 'WPACAU2S', 'Australia', 3, 50.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:25:49', '2022-08-16 03:25:49'),
(6, 'Bank of Queensland', 'QBANAU4B', 'Afghanistan', 3, 50.00, 100000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:26:33', '2022-08-16 03:29:35'),
(7, 'Macquarie Bank', 'MACQAU2S', 'Afghanistan', 3, 50.00, 100000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:27:20', '2022-08-16 03:30:00'),
(8, 'Bendigo Bank', 'BENDAU3B.', 'Afghanistan', 3, 50.00, 100000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:28:09', '2022-08-16 03:29:51'),
(9, 'AMP Bank Ltd', 'AMPBAU2SRET', 'Australia', 3, 50.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:31:05', '2022-08-16 03:31:05'),
(10, 'Suncorp Bank', 'METWAU4B', 'Afghanistan', 1, 50.00, 100000.00, 0.00, 1.00, NULL, 1, '2022-08-16 03:31:49', '2022-08-16 03:31:49'),
(14, 'PNC Bank', 'PNCCUS33XXX', 'Afghanistan', 1, 100.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-10-03 22:04:28', '2022-10-03 22:04:28'),
(15, 'TURKIYE IS BANKASI A.S', 'ISBKTRISXXX', 'Turkey', 1, 100.00, 1000000.00, 0.00, 1.00, NULL, 1, '2022-10-07 22:07:04', '2022-10-07 22:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'privacy-policy', 1, '2021-08-31 09:42:32', '2021-08-31 09:42:32'),
(2, 'terms-condition', 1, '2021-08-31 09:44:42', '2021-08-31 09:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `page_translations`
--

CREATE TABLE `page_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_translations`
--

INSERT INTO `page_translations` (`id`, `page_id`, `locale`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 'English', 'Privacy Policy', '<h3>Information We Collect</h3>\n<p>Information we collect includes both information you knowingly and actively provide us when using or participating in any of our services and promotions, and any information automatically sent by your devices in the course of accessing our products and services.</p>\n<h4>Log Data</h4>\n<p>When you visit our website, our servers may automatically log the standard data provided by your web browser. It may include your device’s Internet Protocol (IP) address, your browser type and version, the pages you visit, the time and date of your visit, the time spent on each page, other details about your visit, and technical details that occur in conjunction with any errors you may encounter.</p>\n<p>Please be aware that while this information may not be personally identifying by itself, it may be possible to combine it with other data to personally identify individual persons.</p>\n<h4>Personal Information</h4>\n<p>We may ask for personal information which may include one or more of the following:</p>\n<ul>\n<li>Name</li>\n<li>Email</li>\n<li>Date of birth</li>\n<li>Phone/mobile number</li>\n</ul>\n<h4>Legitimate Reasons for Processing Your Personal Information</h4>\n<p>We only collect and use your personal information when we have a legitimate reason for doing so. In which instance, we only collect personal information that is reasonably necessary to provide our services to you.</p>\n<h4>Collection and Use of Information</h4>\n<p>We may collect personal information from you when you do any of the following on our website:</p>\n<ul>\n<li>Sign up to receive updates from us via email or social media channels</li>\n<li>Use a mobile device or web browser to access our content</li>\n<li>Contact us via email, social media, or on any similar technologies</li>\n<li>When you mention us on social media</li>\n</ul>\n<p>We may collect, hold, use, and disclose information for the following purposes, and personal information will not be further processed in a manner that is incompatible with these purposes:</p>\n<p>We may collect, hold, use, and disclose information for the following purposes, and personal information will not be further processed in a manner that is incompatible with these purposes:</p>\n<ul>\n<li>to contact and communicate with you</li>\n<li>to enable you to access and use our website, associated applications, and associated social media platforms</li>\n<li>for internal record keeping and administrative purposes</li>\n<li>for security and fraud prevention, and to ensure that our sites and apps are safe, secure, and used in line with our terms of use</li>\n</ul>\n<p>Please be aware that we may combine information we collect about you with general information or research data we receive from other trusted sources.</p>\n<h4>Security of Your Personal Information</h4>\n<p>When we collect and process personal information, and while we retain this information, we will protect it within commercially acceptable means to prevent loss and theft, as well as unauthorized access, disclosure, copying, use, or modification.</p>\n<p>Although we will do our best to protect the personal information you provide to us, we advise that no method of electronic transmission or storage is 100% secure, and no one can guarantee absolute data security. We will comply with laws applicable to us in respect of any data breach.</p>\n<p>You are responsible for selecting any password and its overall security strength, ensuring the security of your own information within the bounds of our services.</p>\n<h4>How Long We Keep Your Personal Information</h4>\n<p>We keep your personal information only for as long as we need to. This time period may depend on what we are using your information for, in accordance with this privacy policy. If your personal information is no longer required, we will delete it or make it anonymous by removing all details that identify you.</p>\n<p>However, if necessary, we may retain your personal information for our compliance with a legal, accounting, or reporting obligation or for archiving purposes in the public interest, scientific, or historical research purposes or statistical purposes.</p>\n<h3>Children’s Privacy</h3>\n<p>We do not aim any of our products or services directly at children under the age of 13, and we do not knowingly collect personal information about children under 13.</p>\n<h3>Disclosure of Personal Information to Third Parties</h3>\n<p>We may disclose personal information to:</p>\n<ul>\n<li>a parent, subsidiary, or affiliate of our company</li>\n<li>third party service providers for the purpose of enabling them to provide their services, for example, IT service providers, data storage, hosting and server providers, advertisers, or analytics platforms</li>\n<li>our employees, contractors, and/or related entities</li>\n<li>our existing or potential agents or business partners</li>\n<li>sponsors or promoters of any competition, sweepstakes, or promotion we run</li>\n<li>courts, tribunals, regulatory authorities, and law enforcement officers, as required by law, in connection with any actual or prospective legal proceedings, or in order to establish, exercise, or defend our legal rights</li>\n<li>third parties, including agents or sub-contractors, who assist us in providing information, products, services, or direct marketing to you third parties to collect and process data</li>\n</ul>\n<h3>International Transfers of Personal Information</h3>\n<p>The personal information we collect is stored and/or processed where we or our partners, affiliates, and third-party providers maintain facilities. Please be aware that the locations to which we store, process, or transfer your personal information may not have the same data protection laws as the country in which you initially provided the information. If we transfer your personal information to third parties in other countries: (i) we will perform those transfers in accordance with the requirements of applicable law; and (ii) we will protect the transferred personal information in accordance with this privacy policy.</p>\n<h3>Your Rights and Controlling Your Personal Information</h3>\n<p>You always retain the right to withhold personal information from us, with the understanding that your experience of our website may be affected. We will not discriminate against you for exercising any of your rights over your personal information. If you do provide us with personal information you understand that we will collect, hold, use and disclose it in accordance with this privacy policy. You retain the right to request details of any personal information we hold about you.</p>\n<p>If we receive personal information about you from a third party, we will protect it as set out in this privacy policy. If you are a third party providing personal information about somebody else, you represent and warrant that you have such person’s consent to provide the personal information to us.</p>\n<p>If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time. We will provide you with the ability to unsubscribe from our email-database or opt out of communications. Please be aware we may need to request specific information from you to help us confirm your identity.</p>\n<p>If you believe that any information we hold about you is inaccurate, out of date, incomplete, irrelevant, or misleading, please contact us using the details provided in this privacy policy. We will take reasonable steps to correct any information found to be inaccurate, incomplete, misleading, or out of date.</p>\n<p>If you believe that we have breached a relevant data protection law and wish to make a complaint, please contact us using the details below and provide us with full details of the alleged breach. We will promptly investigate your complaint and respond to you, in writing, setting out the outcome of our investigation and the steps we will take to deal with your complaint. You also have the right to contact a regulatory body or data protection authority in relation to your complaint.</p>\n<h3>Use of Cookies</h3>\n<p>We use “cookies” to collect information about you and your activity across our site. A cookie is a small piece of data that our website stores on your computer, and accesses each time you visit, so we can understand how you use our site. This helps us serve you content based on preferences you have specified.</p>\n<h3>Limits of Our Policy</h3>\n<p>Our website may link to external sites that are not operated by us. Please be aware that we have no control over the content and policies of those sites, and cannot accept responsibility or liability for their respective privacy practices.</p>\n<h3>Changes to This Policy</h3>\n<p>At our discretion, we may change our privacy policy to reflect updates to our business processes, current acceptable practices, or legislative or regulatory changes. If we decide to change this privacy policy, we will post the changes here at the same link by which you are accessing this privacy policy.</p>\n<p>If required by law, we will get your permission or give you the opportunity to opt in to or opt out of, as applicable, any new uses of your personal information.</p>', '2021-08-31 09:42:32', '2021-09-05 13:27:37'),
(2, 2, 'English', 'Terms & Condition', '<h2><strong>Terms and Conditions</strong></h2>\r\n<p>Welcome to LivoBank!</p>\r\n<p>These terms and conditions outline the rules and regulations for the use of Livo Bank\'s Website, located at https://livo-bank.trickycode.xyz.</p>\r\n<p>By accessing this website we assume you accept these terms and conditions. Do not continue to use LivoBank if you do not agree to take all of the terms and conditions stated on this page.</p>\r\n<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: \"Client\", \"You\" and \"Your\" refers to you, the person log on this website and compliant to the Company’s terms and conditions. \"The Company\", \"Ourselves\", \"We\", \"Our\" and \"Us\", refers to our Company. \"Party\", \"Parties\", or \"Us\", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>\r\n<h3><strong>Cookies</strong></h3>\r\n<p>We employ the use of cookies. By accessing LivoBank, you agreed to use cookies in agreement with the Livo Bank\'s Privacy Policy.</p>\r\n<p>Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>\r\n<h3><strong>License</strong></h3>\r\n<p>Unless otherwise stated, Livo Bank and/or its licensors own the intellectual property rights for all material on LivoBank. All intellectual property rights are reserved. You may access this from LivoBank for your own personal use subjected to restrictions set in these terms and conditions.</p>\r\n<p>You must not:</p>\r\n<ul>\r\n<li>Republish material from LivoBank</li>\r\n<li>Sell, rent or sub-license material from LivoBank</li>\r\n<li>Reproduce, duplicate or copy material from LivoBank</li>\r\n<li>Redistribute content from LivoBank</li>\r\n</ul>\r\n<p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href=\"https://www.termsandconditionsgenerator.com\">Terms And Conditions Generator</a>.</p>\r\n<p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Livo Bank does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Livo Bank,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Livo Bank shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>\r\n<p>Livo Bank reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>\r\n<p>You warrant and represent that:</p>\r\n<ul>\r\n<li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>\r\n<li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>\r\n<li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>\r\n<li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>\r\n</ul>\r\n<p>You hereby grant Livo Bank a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>\r\n<h3><strong>Hyperlinking to our Content</strong></h3>\r\n<p>The following organizations may link to our Website without prior written approval:</p>\r\n<ul>\r\n<li>Government agencies;</li>\r\n<li>Search engines;</li>\r\n<li>News organizations;</li>\r\n<li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li>\r\n<li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>\r\n</ul>\r\n<p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party’s site.</p>\r\n<p>We may consider and approve other link requests from the following types of organizations:</p>\r\n<ul>\r\n<li>commonly-known consumer and/or business information sources;</li>\r\n<li>dot.com community sites;</li>\r\n<li>associations or other groups representing charities;</li>\r\n<li>online directory distributors;</li>\r\n<li>internet portals;</li>\r\n<li>accounting, law and consulting firms; and</li>\r\n<li>educational institutions and trade associations.</li>\r\n</ul>\r\n<p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of Livo Bank; and (d) the link is in the context of general resource information.</p>\r\n<p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party’s site.</p>\r\n<p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Livo Bank. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>\r\n<p>Approved organizations may hyperlink to our Website as follows:</p>\r\n<ul>\r\n<li>By use of our corporate name; or</li>\r\n<li>By use of the uniform resource locator being linked to; or</li>\r\n<li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party’s site.</li>\r\n</ul>\r\n<p>No use of Livo Bank\'s logo or other artwork will be allowed for linking absent a trademark license agreement.</p>\r\n<h3><strong>iFrames</strong></h3>\r\n<p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p>\r\n<h3><strong>Content Liability</strong></h3>\r\n<p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>\r\n<h3><strong>Your Privacy</strong></h3>\r\n<p>Please read Privacy Policy</p>\r\n<h3><strong>Reservation of Rights</strong></h3>\r\n<p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it’s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>\r\n<h3><strong>Removal of links from our website</strong></h3>\r\n<p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>\r\n<p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>\r\n<h3><strong>Disclaimer</strong></h3>\r\n<p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>\r\n<ul>\r\n<li>limit or exclude our or your liability for death or personal injury;</li>\r\n<li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>\r\n<li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>\r\n<li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>\r\n</ul>\r\n<p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>\r\n<p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>', '2021-08-31 09:44:42', '2021-09-05 13:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `parameters` text COLLATE utf8mb4_unicode_ci,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci,
  `extra` text COLLATE utf8mb4_unicode_ci,
  `exchange_rate` decimal(10,6) DEFAULT NULL,
  `fixed_charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `charge_in_percentage` decimal(10,2) NOT NULL DEFAULT '0.00',
  `minimum_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maximum_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `slug`, `image`, `status`, `parameters`, `currency`, `supported_currencies`, `extra`, `exchange_rate`, `fixed_charge`, `charge_in_percentage`, `minimum_amount`, `maximum_amount`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 'PayPal', 'paypal.png', 1, '{\"client_id\":\"\",\"client_secret\":\"\",\"environment\":\"sandbox\"}', 'USD', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}', NULL, 1.000000, 0.00, 2.00, 10.00, 100000.00, NULL, '2022-09-04 01:47:01'),
(2, 'Stripe', 'Stripe', 'stripe.png', 0, '{\"secret_key\":\"\",\"publishable_key\":\"\"}', NULL, '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', NULL, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(3, 'Razorpay', 'Razorpay', 'razorpay.png', 0, '{\"razorpay_key_id\":\"\",\"razorpay_key_secret\":\"\"}', NULL, '{\"INR\":\"INR\"}', NULL, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(4, 'Paystack', 'Paystack', 'paystack.png', 0, '{\"paystack_public_key\":\"\",\"paystack_secret_key\":\"\"}', NULL, '{\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', NULL, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(5, 'BlockChain', 'BlockChain', 'blockchain.png', 1, '{\"blockchain_api_key\":\"\",\"blockchain_xpub\":\"\"}', 'BTC', '{\"BTC\":\"BTC\"}', NULL, 0.000051, 0.00, 1.00, 50.00, 1000000.00, NULL, '2022-09-04 01:45:21'),
(6, 'Flutterwave', 'Flutterwave', 'flutterwave.png', 0, '{\"public_key\":\"\",\"secret_key\":\"\",\"encryption_key\":\"\",\"environment\":\"sandbox\"}', NULL, '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', NULL, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_requests`
--

INSERT INTO `payment_requests` (`id`, `currency_id`, `amount`, `status`, `description`, `sender_id`, `receiver_id`, `transaction_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1000.00, 1, 'Payment', 6, 5, NULL, 1, '2022-10-06 03:42:36', '2022-10-06 03:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `created_at`, `updated_at`) VALUES
(2, '<i class=\"icofont-paper-plane\"></i>', '2021-08-31 06:34:38', '2021-09-05 14:33:22'),
(3, '<i class=\"icofont-money\"></i>', '2021-08-31 06:35:33', '2021-09-05 10:29:47'),
(4, '<i class=\"icofont-exchange\"></i>', '2021-08-31 06:38:26', '2021-09-05 10:30:04'),
(5, '<i class=\"icofont-bank-alt\"></i>', '2021-08-31 06:38:44', '2021-09-05 10:30:19'),
(6, '<i class=\"icofont-file-text\"></i>', '2021-08-31 06:39:01', '2021-09-05 10:30:32'),
(7, '<i class=\"icofont-pay\"></i>', '2021-08-31 06:39:19', '2021-09-05 10:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `service_translations`
--

CREATE TABLE `service_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_translations`
--

INSERT INTO `service_translations` (`id`, `service_id`, `locale`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 2, 'English', 'Money Transfer', 'We offers you secure and easy transfer. Transfer money between users within a minutes.', '2021-08-31 06:34:38', '2021-08-31 06:34:38'),
(2, 3, 'English', 'Multi Currency', 'We supports multi currency. Bank conveniently with currencies of your choice.', '2021-08-31 06:35:33', '2021-09-05 10:34:07'),
(3, 4, 'English', 'Exchange Currency', 'We offer lowest exchange fee so you can exchange your currency anytime.', '2021-08-31 06:38:26', '2021-08-31 06:38:26'),
(4, 5, 'English', 'Fixed Deposit', 'We offers long term investment and you will get good interest rate after maturity.', '2021-08-31 06:38:44', '2021-08-31 06:38:44'),
(5, 6, 'English', 'Apply Loan', 'We offers different types loan with low interest rate. You can get a loan easily.', '2021-08-31 06:39:01', '2021-08-31 06:39:01'),
(6, 7, 'English', 'Payment Request', 'You can make payment request to you customer for any types of product or services.', '2021-08-31 06:39:19', '2021-08-31 06:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'mail_type', 'smtp', NULL, '2022-08-16 02:18:14'),
(2, 'backend_direction', 'ltr', NULL, '2022-08-16 02:51:57'),
(3, 'language', 'English', NULL, NULL),
(4, 'email_verification', 'enabled', NULL, '2022-08-16 02:51:57'),
(5, 'allow_singup', 'yes', NULL, '2022-08-16 02:51:57'),
(6, 'company_name', 'CBC HOLDINGS', '2022-08-15 15:17:29', '2022-08-15 15:17:27'),
(7, 'site_title', 'CBC HOLDINGS', '2022-08-15 15:17:29', '2022-08-15 15:17:29'),
(8, 'phone', '+61480006275', '2022-08-15 15:17:29', '2022-08-15 15:17:29'),
(9, 'email', 'support@cbcholdingsllc.com', '2022-08-15 15:17:29', '2022-08-15 15:17:29'),
(10, 'timezone', 'Australia/Melbourne', '2022-08-15 15:17:29', '2022-08-15 15:17:29'),
(38, 'main_heading', 'Smart way to keep your money safe and secure', '2021-08-31 14:38:10', '2021-09-05 10:47:17'),
(39, 'sub_heading', 'Transfer money within minutes and save money for your future. All of your desired service in single platform.', '2021-08-31 14:39:15', '2021-09-05 10:47:17'),
(41, 'copyright', 'Copyright © 2021 <a href=\"#\" target=\"_blank\">Tricky Code</a>  -  All Rights Reserved.', '2021-08-31 14:39:15', '2021-09-05 10:24:45'),
(46, 'meta_keywords', '', '2021-08-31 14:39:15', '2021-08-31 14:39:15'),
(47, 'meta_content', '', '2021-08-31 14:39:15', '2021-08-31 14:39:15'),
(49, 'footer_about_us', 'Livo Bank is a micro banking system. We offers different types of financial services to our customers all over the world such as Loan, Wire transfer, Long term deposit, savings and some other related services.', '2021-08-31 14:58:14', '2021-09-05 10:24:45'),
(51, 'primary_menu', '1', '2021-08-31 16:30:14', '2021-08-31 16:30:14'),
(52, 'footer_menu_1', '2', '2021-08-31 16:30:14', '2021-08-31 17:13:31'),
(53, 'footer_menu_1_title', 'Quick Explore', '2021-09-01 05:50:56', '2021-09-01 05:50:56'),
(54, 'footer_menu_2_title', 'Pages', '2021-09-01 05:50:56', '2021-09-05 10:24:45'),
(55, 'footer_menu_2', '3', '2021-09-01 05:50:56', '2021-09-01 05:50:56'),
(56, 'home_about_us_heading', 'About Us', '2021-09-05 09:52:18', '2021-09-05 09:54:38'),
(58, 'home_service_content', 'You can choose any of our services', '2021-09-05 09:52:18', '2021-09-05 10:12:10'),
(59, 'home_fixed_deposit_heading', 'Fixed Deposit Plans', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(60, 'home_fixed_deposit_content', 'You will get maximum rewards with us by making long term deposit', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(61, 'home_loan_heading', 'Loan Packages', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(62, 'home_loan_content', 'We offers different types loan with low interest rate. You will get hassle free loan easily.', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(63, 'home_testimonial_heading', 'We served over 500+ Customers', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(64, 'home_testimonial_content', '', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(65, 'home_partner_heading', 'Partners who support us', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(66, 'home_partner_content', '', '2021-09-05 09:52:18', '2021-09-05 10:19:41'),
(67, 'home_about_us_content', 'Livo Bank is a micro banking system. We offers different types of financial services to our customers all over the world. We have multiple branches to provide different services such as Loan, Wire transfer, Long term deposit, savings and some other related services.', '2021-09-05 09:54:15', '2021-09-05 09:54:15'),
(68, 'home_service_heading', 'Our Services', '2021-09-05 09:54:38', '2021-09-05 10:12:10'),
(69, 'total_customer', '500', '2021-09-05 10:06:39', '2021-09-05 10:08:10'),
(70, 'total_branch', '5', '2021-09-05 10:06:39', '2021-09-05 10:11:53'),
(71, 'total_transactions', '1', '2021-09-05 10:06:39', '2021-09-05 10:11:53'),
(72, 'total_countries', '200', '2021-09-05 10:06:39', '2021-09-05 10:11:53'),
(73, 'about_page_title', ' Who We Are', '2021-09-05 14:07:18', '2021-09-05 14:07:18'),
(74, 'our_team_title', 'Meet Our Team', '2021-09-05 14:07:18', '2021-09-05 14:07:18'),
(75, 'our_team_sub_title', '', '2021-09-05 14:07:18', '2021-09-05 14:07:18'),
(76, 'about_us_content', '<p>Livo Bank is a micro banking system. We offers different types of financial services to our customers all over the world. </p><p>We have multiple branches to provide different services such as Loan, Wire transfer, Long term deposit, savings and some other related services.</p>', '2021-09-05 14:08:15', '2021-09-05 14:08:15'),
(77, 'privacy_policy_page', 'privacy-policy', '2022-06-01 14:07:18', '2022-06-01 14:07:18'),
(78, 'terms_condition_page', 'terms-condition', '2022-06-01 14:07:18', '2022-06-01 14:07:18'),
(79, 'APP_VERSION', '1.3.3', '2022-08-16 01:17:30', '2022-08-16 01:17:30'),
(80, 'next_account_number', '20221019', '2022-08-16 01:27:08', '2023-06-10 13:58:10'),
(81, 'from_email', 'support@cbcholdingsllc.com', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(82, 'from_name', 'Support', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(83, 'smtp_host', 'mail.cbcholdingsllc.com', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(84, 'smtp_port', ' 465', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(85, 'smtp_username', 'support@cbcholdingsllc.com', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(86, 'smtp_password', 'AlphaOne12$', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(87, 'smtp_encryption', 'ssl', '2022-08-16 02:14:43', '2022-08-16 02:18:14'),
(88, 'send_money_action', '1', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(89, 'send_money_otp', '1', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(90, 'exchange_money_action', '0', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(91, 'exchange_money_otp', '1', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(92, 'withdraw_money_otp', '1', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(93, 'wire_transfer_otp', '1', '2022-08-16 02:19:18', '2022-08-16 02:19:18'),
(94, 'website_enable', 'yes', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(95, 'currency_position', 'left', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(96, 'date_format', 'Y-m-d', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(97, 'time_format', '24', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(98, 'mobile_verification', 'disabled', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(99, 'enable_2fa', 'no', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(100, 'enable_kyc', 'no', '2022-08-16 02:51:57', '2022-08-16 02:51:57'),
(101, 'enable_sms', '1', '2022-08-16 02:57:05', '2022-08-16 02:57:05'),
(102, 'twilio_account_sid', 'AC2e50c7de34b2e5249024c5eea924d69f', '2022-08-16 02:57:05', '2022-08-16 02:57:05'),
(103, 'twilio_auth_token', '2171cff469668adc469feeb1c43918ab', '2022-08-16 02:57:05', '2022-08-16 02:57:05'),
(104, 'twilio_mobile_number', '+61259445304', '2022-08-16 02:57:05', '2022-08-16 02:57:05'),
(105, 'favicon', 'file_1660586263.png', '2022-08-16 02:57:43', '2022-08-16 02:57:43'),
(106, 'gdpr_cookie_content', 'We and our partners are using technologies like Cookies or Targeting and process personal data like the IP-address or browser information in order to personalize the advertising that you see. This helps us to show you more relevant ads and improves your internet experience. We also use it in order to measure results or align our website content. Because we value your privacy, we are herewith asking for your permission to use this technologies. You can always change/withdraw your consent later by clicking on the settings button on the left lower corner of the page.', '2022-08-16 03:00:42', '2022-08-16 03:00:42'),
(107, 'gdpr_privacy_policy_page', 'privacy-policy', '2022-08-16 03:00:42', '2022-08-16 03:00:42'),
(108, 'gdpr_cookie_status', '1', '2022-08-16 03:00:42', '2022-08-16 03:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `setting_translations`
--

CREATE TABLE `setting_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_translations`
--

INSERT INTO `setting_translations` (`id`, `setting_id`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 106, 'English', 'We and our partners are using technologies like Cookies or Targeting and process personal data like the IP-address or browser information in order to personalize the advertising that you see. This helps us to show you more relevant ads and improves your internet experience. We also use it in order to measure results or align our website content. Because we value your privacy, we are herewith asking for your permission to use this technologies. You can always change/withdraw your consent later by clicking on the settings button on the left lower corner of the page.', '2022-08-16 03:00:42', '2022-08-16 03:00:42'),
(2, 107, 'English', 'privacy-policy', '2022-08-16 03:00:42', '2022-08-16 03:00:42'),
(3, 108, 'English', '1', '2022-08-16 03:00:42', '2022-08-16 03:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `created_user_id` bigint(20) NOT NULL,
  `operator_id` bigint(20) DEFAULT NULL,
  `closed_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_messages`
--

CREATE TABLE `support_ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_ticket_messages`
--

INSERT INTO `support_ticket_messages` (`id`, `support_ticket_id`, `message`, `sender_id`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 1, 'aa', 16, NULL, '2023-04-11 07:46:34', '2023-04-11 07:46:34'),
(2, 1, 'asfasf', 16, '1681166903fks.jpg', '2023-04-11 07:48:23', '2023-04-11 07:48:23'),
(3, 1, 'asfasf', 16, '1681166911fks.php56', '2023-04-11 07:48:31', '2023-04-11 07:48:31'),
(4, 1, 'asfasf', 16, '1681166924fks.php7', '2023-04-11 07:48:44', '2023-04-11 07:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_translations`
--

CREATE TABLE `testimonial_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `testimonial_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `testimonial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dr_cr` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `loan_id` bigint(20) DEFAULT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `other_bank_id` bigint(20) DEFAULT NULL,
  `gateway_id` bigint(20) DEFAULT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `transaction_details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `currency_id`, `amount`, `fee`, `dr_cr`, `type`, `method`, `status`, `note`, `loan_id`, `ref_id`, `parent_id`, `other_bank_id`, `gateway_id`, `created_user_id`, `updated_user_id`, `branch_id`, `transaction_details`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 70000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-15 23:00:00', '2022-08-16 01:43:53'),
(2, 2, 1, 2000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-15 23:00:00', '2022-08-16 01:44:11'),
(3, 2, 1, 100000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 1, NULL, '2022-08-16 01:48:20', '2022-08-16 01:48:20'),
(4, 2, 2, 85000.00, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 3, NULL, NULL, 2, NULL, 1, NULL, '2022-08-16 01:48:20', '2022-08-16 01:48:20'),
(5, 2, 1, 1030.00, 30.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 1, NULL, 2, NULL, 1, '{\"account_number\":\"223266452882\",\"account_holder_name\":\"Trina Solar\"}', '2022-08-16 01:54:36', '2022-08-16 01:55:28'),
(6, 2, 1, 1030.00, 30.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 1, NULL, 2, NULL, 1, '{\"account_number\":\"33387369\",\"account_holder_name\":\"Trina\"}', '2022-08-16 02:11:25', '2022-08-16 02:33:48'),
(7, 2, 1, 1030.00, 30.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 1, NULL, 2, NULL, 1, '{\"account_number\":\"1122444\",\"account_holder_name\":\"Trina Solar\"}', '2022-08-16 02:21:35', '2022-08-16 02:33:05'),
(8, 2, 1, 2670900.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Payment From Gray Tech Solutions', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-15 23:00:00', '2022-08-16 03:40:51'),
(9, 3, 3, 70000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-15 23:00:00', '2022-08-16 03:50:14'),
(10, 3, 1, 4566780.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Payment from HydroTech Solutions', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-16 03:03:00', '2022-08-16 03:52:43'),
(11, 3, 1, 100000.00, 0.00, 'dr', 'Exchange', 'Online', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, NULL, '2022-08-16 03:54:02', '2023-06-18 04:26:47'),
(12, 3, 2, 98370.00, 0.00, 'cr', 'Exchange', 'Online', 0, NULL, NULL, NULL, 11, NULL, NULL, 3, NULL, 1, NULL, '2022-08-16 03:54:02', '2023-06-18 04:26:47'),
(13, 3, 1, 26000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-16 11:02:00', '2022-08-16 03:55:42'),
(14, 3, 1, 47650.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-16 01:00:00', '2022-08-16 03:57:01'),
(15, 3, 1, 30600.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-05-04 14:00:00', '2022-08-16 04:02:02'),
(16, 4, 3, 358450.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit.', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2006-06-20 01:06:00', '2022-09-04 00:41:27'),
(17, 4, 3, 32000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2006-06-21 02:01:00', '2022-09-04 00:44:30'),
(18, 4, 3, 1508000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Direct Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-03 11:08:00', '2022-09-04 00:54:25'),
(19, 4, 3, 500000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Government Taxes', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-02 23:00:00', '2022-09-04 00:56:57'),
(20, 5, 3, 878000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2010-02-16 11:14:00', '2022-09-04 01:02:49'),
(21, 5, 3, 31000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2010-08-31 02:07:00', '2022-09-04 01:03:38'),
(22, 5, 3, 87800.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Charges', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2010-02-16 11:19:00', '2022-09-04 01:08:32'),
(23, 5, 3, 31000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Charges', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2010-08-31 02:16:00', '2022-09-04 01:10:14'),
(24, 5, 3, 800000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Direct Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-04-14 12:18:00', '2022-09-04 01:13:15'),
(25, 5, 3, 1625110.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-01-05 11:14:00', '2022-09-04 01:15:15'),
(26, 5, 3, 300000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, '2022-09-04 01:21:14', '2022-09-04 01:21:14'),
(27, 5, 1, 428571.43, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 26, NULL, NULL, 5, NULL, 1, NULL, '2022-09-04 01:21:14', '2022-09-04 01:21:14'),
(28, 5, 1, 404000.00, 4000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 1, NULL, 5, NULL, 1, '{\"account_number\":\"1123345667\",\"account_holder_name\":\"Jensing Solar\"}', '2022-09-04 01:22:33', '2022-09-04 01:23:01'),
(29, 5, 1, 1000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Maintenance', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-01 13:17:00', '2022-09-04 01:24:13'),
(31, 5, 3, 200000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, '2022-10-05 12:04:05', '2022-10-05 12:04:05'),
(32, 5, 1, 285714.29, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 31, NULL, NULL, 5, NULL, 1, NULL, '2022-10-05 12:04:05', '2022-10-05 12:04:05'),
(33, 5, 1, 25250.00, 250.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Morgan for workers', NULL, NULL, NULL, 10, NULL, 5, NULL, 1, '{\"account_number\":\"2536128892\",\"account_holder_name\":\"2A Solar Enerji\"}', '2022-10-05 12:17:00', '2022-10-05 12:23:58'),
(34, 6, 1, 18000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Payment form Turkey.', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-01-17 16:11:00', '2022-10-05 22:25:19'),
(35, 6, 2, 7500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Cheque Deposit.', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-04-20 13:13:00', '2022-10-05 22:26:42'),
(36, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2016-12-31 23:00:00', '2022-10-05 22:29:50'),
(37, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-02-15 12:32:00', '2022-10-05 22:31:25'),
(38, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-03-15 12:53:00', '2022-10-05 22:32:07'),
(39, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-04-19 11:18:00', '2022-10-05 22:32:50'),
(40, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-05-17 12:00:00', '2022-10-05 22:33:24'),
(41, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-06-13 12:00:00', '2022-10-05 22:34:05'),
(42, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-07-18 12:15:00', '2022-10-05 22:34:40'),
(43, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-08-23 13:57:00', '2022-10-05 22:35:34'),
(44, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-09-21 16:00:00', '2022-10-05 22:36:05'),
(45, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-09-27 14:51:00', '2022-10-05 22:36:42'),
(46, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-10-26 13:15:00', '2022-10-05 22:37:18'),
(47, 6, 3, 500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Airbnb Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-12-14 15:11:00', '2022-10-05 22:37:45'),
(48, 6, 3, 2000.00, 0.00, 'dr', 'Transfer', 'Online', 0, 'Automatic payment', NULL, NULL, NULL, NULL, NULL, 6, NULL, 1, NULL, '2022-10-05 22:55:05', '2022-10-05 22:56:56'),
(49, 5, 3, 2000.00, 0.00, 'cr', 'Transfer', 'Online', 0, 'Automatic payment', NULL, NULL, 48, NULL, NULL, 6, NULL, 1, NULL, '2022-10-05 22:55:05', '2022-10-05 22:56:56'),
(50, 6, 3, 190476.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Payment for installation Fee', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-05-22 09:49:00', '2022-10-05 23:01:50'),
(51, 6, 3, 235900.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Consultation and Maintenance Fee', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-10-09 14:52:00', '2022-10-05 23:02:59'),
(52, 6, 3, 160750.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Installation Fee', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-10-21 15:13:00', '2022-10-05 23:04:00'),
(53, 6, 3, 220700.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Installation and Consultation fee', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-06-10 13:16:00', '2022-10-05 23:05:50'),
(54, 6, 3, 210750.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-08-20 13:15:00', '2022-10-05 23:08:52'),
(55, 6, 3, 29575836.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Inheritance Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2012-06-13 13:17:00', '2022-10-05 23:37:55'),
(56, 6, 2, 36254460.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Inheritance Deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2012-08-14 11:44:00', '2022-10-05 23:39:57'),
(57, 6, 3, 3500.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Car Rental Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2018-10-17 10:52:00', '2022-10-05 23:44:40'),
(58, 6, 3, 2720.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Groceries Purchase', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2018-05-15 12:52:00', '2022-10-05 23:47:04'),
(59, 5, 3, 300000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 1, NULL, '2022-10-06 04:43:04', '2022-10-06 04:43:04'),
(60, 5, 1, 428571.43, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 59, NULL, NULL, 5, NULL, 1, NULL, '2022-10-06 04:43:04', '2022-10-06 04:43:04'),
(61, 5, 1, 429250.00, 4250.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Morgan for 400 units of 72-cells MBB Bifacial PERC Half-cell double glass module', NULL, NULL, NULL, 1, NULL, 5, NULL, 1, '{\"account_number\":\"986556175688\",\"account_holder_name\":\"Trina Solar\"}', '2022-10-06 04:52:37', '2022-10-06 05:53:14'),
(62, 5, 1, 43430.00, 430.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Morgan for shipment clearance and courier', NULL, NULL, NULL, 15, NULL, 5, NULL, 1, '{\"account_number\":\"10987654321\",\"account_holder_name\":\"Turkish Customs\"}', '2022-10-07 22:15:57', '2022-10-08 02:59:02'),
(63, 8, 3, 31000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-03-24 14:12:00', '2022-10-07 22:22:40'),
(64, 8, 1, 23000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-05-06 15:10:00', '2022-10-07 22:25:27'),
(65, 8, 3, 870000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-06-18 10:16:00', '2022-10-07 22:25:59'),
(66, 8, 3, 400000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, '2022-10-07 22:37:39', '2022-10-07 22:37:39'),
(67, 8, 1, 625000.00, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 66, NULL, NULL, 8, NULL, 1, NULL, '2022-10-07 22:37:39', '2022-10-07 22:37:39'),
(68, 8, 1, 25250.00, 250.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Morgan for workers', NULL, NULL, NULL, 10, NULL, 8, NULL, 1, '{\"account_number\":\"2536128892\",\"account_holder_name\":\"2A Solar Enerji\"}', '2022-10-07 22:43:34', '2022-10-08 01:33:48'),
(69, 7, 2, 110000.00, 0.00, 'cr', 'Deposit', 'Online', 2, 'Return of Fixed deposit', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-08 01:51:25', '2022-10-08 01:51:25'),
(70, 7, 2, 100000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, '2022-10-08 01:54:50', '2022-10-08 01:54:50'),
(71, 7, 1, 101657.01, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 70, NULL, NULL, 7, NULL, NULL, NULL, '2022-10-08 01:54:50', '2022-10-08 01:54:50'),
(72, 7, 1, 4040.00, 40.00, 'dr', 'Wire_Transfer', 'Manual', 1, NULL, NULL, NULL, NULL, 13, NULL, 7, NULL, NULL, '{\"account_number\":\"6667890\",\"account_holder_name\":\"jihuytre\"}', '2022-10-08 01:56:32', '2022-10-08 01:56:32'),
(74, 8, 1, 431270.00, 4270.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Morgan for 400 units of 72-cells MBV Bifacial PERX half-cell double glass module', NULL, NULL, NULL, 1, NULL, 8, NULL, 1, '{\"account_number\":\"986556175688\",\"account_holder_name\":\"Trina Solar\"}', '2022-10-09 14:39:00', '2022-10-09 23:18:54'),
(75, 9, 1, 270.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-03-21 23:00:00', '2022-10-14 00:26:34'),
(76, 9, 2, 521.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-08-04 16:13:00', '2022-10-14 00:27:11'),
(77, 9, 3, 169.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-11-23 06:17:00', '2022-10-14 00:27:45'),
(78, 8, 1, 43430.00, 430.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr. Morgan for shipment clearance and courier.', NULL, NULL, NULL, 15, NULL, 8, NULL, 1, '{\"account_number\":\"112589037914\",\"account_holder_name\":\"Turkish Customs\"}', '2022-10-17 12:53:43', '2022-10-18 16:15:04'),
(79, 10, 2, 450000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2014-12-07 10:54:00', '2022-12-08 08:02:12'),
(80, 10, 1, 500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-08 17:56:00', '2022-12-08 08:06:28'),
(81, 10, 3, 950000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-12-08 14:31:00', '2022-12-08 08:07:37'),
(82, 10, 2, 250000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-08-04 12:43:00', '2022-12-08 08:09:09'),
(83, 10, 3, 9600000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-01-17 16:09:00', '2022-12-08 08:13:01'),
(84, 10, 1, 56000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-05-06 12:52:00', '2022-12-08 08:14:39'),
(85, 10, 3, 156000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-06-30 23:00:00', '2022-12-08 08:15:50'),
(86, 10, 2, 35000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-14 11:45:00', '2022-12-08 08:17:18'),
(87, 10, 1, 455000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-22 13:55:00', '2022-12-08 08:18:36'),
(88, 10, 1, 650000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-05 09:33:00', '2022-12-08 08:21:25'),
(89, 10, 1, 54000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-08 10:43:00', '2022-12-08 12:00:48'),
(90, 10, 2, 14000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-12-08 13:56:00', '2022-12-08 12:01:55'),
(91, 10, 1, 24000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-08 13:13:00', '2022-12-08 12:02:45'),
(92, 10, 1, 85000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-01 14:51:00', '2022-12-08 12:03:37'),
(93, 10, 1, 150000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-23 11:45:00', '2022-12-08 12:04:43'),
(94, 10, 1, 320000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-08 12:17:00', '2022-12-08 12:05:46'),
(95, 10, 1, 720000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-20 14:45:00', '2022-12-08 12:09:26'),
(96, 6, 1, 131300.00, 1300.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'null', NULL, NULL, NULL, 12, NULL, 6, NULL, 1, '{\"account_number\":\"45678456789876545\",\"account_holder_name\":\"5678987678978\"}', '2022-12-14 00:45:35', '2023-05-08 16:59:06'),
(97, 12, 2, 550000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2012-02-14 12:55:00', '2022-12-14 07:35:10'),
(98, 12, 1, 215000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2012-04-12 11:45:00', '2022-12-14 07:36:53'),
(99, 12, 1, 1500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-07-16 13:33:00', '2022-12-14 07:40:05'),
(100, 12, 1, 55000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-13 14:45:00', '2022-12-14 07:41:12'),
(101, 12, 3, 2500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-05-25 14:55:00', '2022-12-14 07:42:35'),
(102, 12, 1, 650000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-13 14:45:00', '2022-12-14 07:43:44'),
(103, 13, 1, 8500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2010-12-14 12:45:00', '2022-12-14 21:36:32'),
(104, 13, 1, 4500.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-06 23:00:00', '2022-12-14 21:37:27'),
(105, 13, 1, 15000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2016-12-20 11:45:00', '2022-12-14 21:38:03'),
(106, 13, 2, 25000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-14 14:34:00', '2022-12-14 21:38:39'),
(107, 13, 1, 11400.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-14 15:35:00', '2022-12-14 21:39:16'),
(108, 10, 1, 120000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-26 23:00:00', '2022-12-28 09:22:42'),
(109, 10, 1, 120000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-14 11:45:00', '2022-12-28 09:23:23'),
(110, 10, 2, 55000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-08 13:43:00', '2022-12-28 09:24:37'),
(111, 10, 1, 150000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-13 13:32:00', '2022-12-28 09:26:35'),
(112, 10, 1, 100000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-12-12 14:30:00', '2022-12-28 09:28:11'),
(113, 10, 1, 530250.00, 5250.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Parts', NULL, NULL, NULL, 1, NULL, 10, NULL, 1, '{\"account_number\":\"650091255002190\",\"account_holder_name\":\"Human Hua-Ali Machinery Tech\"}', '2022-12-28 10:00:36', '2022-12-28 18:35:09'),
(114, 10, 1, 79537.50, 787.50, 'dr', 'Wire_Transfer', 'Manual', 2, 'Customs clearance', NULL, NULL, NULL, 15, NULL, 10, NULL, 1, '{\"account_number\":\"0519984457841352\",\"account_holder_name\":\"Customs brokerage Ata\\u015fehir\"}', '2022-12-30 18:55:38', '2022-12-31 03:39:05'),
(115, 10, 1, 207120.70, 2050.70, 'dr', 'Wire_Transfer', 'Manual', 2, 'Robotics', NULL, NULL, NULL, 1, NULL, 10, NULL, 1, '{\"account_number\":\"651185009001578\",\"account_holder_name\":\"Siasun Robot Automation\"}', '2023-01-06 18:45:27', '2023-01-06 18:56:48'),
(116, 14, 1, 200000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Construction', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-02-12 23:00:00', '2023-02-14 07:28:09'),
(117, 14, 1, 200000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Construction', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-02-12 23:00:00', '2023-02-14 07:28:18'),
(118, 14, 1, 200000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Building materials', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-02-13 00:00:00', '2023-02-14 07:31:25'),
(126, 14, 2, 5700000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Winnie Palmer', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-11 00:15:00', '2023-02-14 07:54:30'),
(120, 14, 1, 47500.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'House rent', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-02-17 02:09:00', '2023-02-14 07:35:20'),
(121, 14, 1, 450000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Winnie Palmer', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-03-13 06:00:00', '2023-02-14 07:38:13'),
(122, 14, 1, 1000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Insulation Materials', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-03-20 01:50:00', '2023-02-14 07:40:59'),
(123, 14, 1, 500000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'The Acra Screed', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-03-25 08:00:00', '2023-02-14 07:44:05'),
(124, 14, 1, 150000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Blinding plates', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-01 09:34:00', '2023-02-14 07:46:21'),
(127, 14, 1, 10000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Turner Construction', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-15 08:20:00', '2023-02-14 07:55:34'),
(134, 14, 1, 1000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Turner Construction', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-27 23:00:00', '2023-02-14 08:36:09'),
(129, 14, 3, 200000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Rossy coperations', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-25 13:09:00', '2023-02-14 07:58:57'),
(130, 14, 1, 26000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'EME LTD', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-05-13 11:00:00', '2023-02-14 08:00:52'),
(131, 14, 1, 58000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'WUN JI Interprise', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-05-20 14:25:00', '2023-02-14 08:02:30'),
(132, 14, 1, 350000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'SALEM LTD', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-06-13 11:00:00', '2023-02-14 08:04:08'),
(135, 14, 1, 5000000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Ha Long Ceramic Company', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-01-02 23:00:00', '2023-02-14 08:37:50'),
(136, 14, 1, 200000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Winnie Palmer', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-07-09 23:00:00', '2023-02-14 08:40:15'),
(137, 14, 1, 100000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Wu Yi Co. Ltd.', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-27 23:00:00', '2023-02-14 08:43:39'),
(138, 14, 1, 200000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'Insulation Materials & Elements Companies', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-29 23:00:00', '2023-02-14 08:45:37'),
(139, 14, 3, 350000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Westland Construction Company', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-02-12 23:00:00', '2023-02-14 08:51:01'),
(141, 14, 1, 532270.00, 5270.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Building materials', NULL, NULL, NULL, 11, NULL, 14, NULL, 1, '{\"account_number\":\"1640961426\",\"account_holder_name\":\"Kelvin Kent Ind ltd\"}', '2023-02-17 06:11:23', '2023-02-17 07:17:00'),
(142, 17, 1, 3200000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Inheritance Payment', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2006-09-20 05:02:00', '2023-04-14 15:42:18'),
(143, 17, 1, 860450.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'AI Robotic Project', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-06-07 09:04:00', '2023-04-14 15:44:21'),
(144, 17, 1, 480000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'Apex Renewable Energy Project', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2018-11-10 02:50:00', '2023-04-14 15:45:46'),
(145, 8, 3, 500000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, 1, NULL, '2023-04-15 11:01:50', '2023-04-15 11:01:50'),
(146, 8, 1, 781250.00, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 145, NULL, NULL, 8, NULL, 1, NULL, '2023-04-15 11:01:50', '2023-04-15 11:01:50'),
(147, 8, 1, 757500.00, 7500.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr. Rhys for 400 units with next day delivery -of 72-cell MBB Bifacial PERC half-cell double glass module', NULL, NULL, NULL, 1, NULL, 8, NULL, 1, '{\"account_number\":\"986556175688\",\"account_holder_name\":\"Trina Solar\"}', '2023-04-15 11:14:26', '2023-04-15 16:36:22'),
(148, 12, 1, 850000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-04-15 08:53:00', '2023-04-15 23:21:32'),
(149, 18, 2, 250000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-04-16 11:28:00', '2023-04-16 22:38:57'),
(150, 18, 1, 154000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-04-08 13:38:00', '2023-04-16 22:40:23'),
(151, 18, 2, 558000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-20 22:43:00', '2023-04-16 22:41:06'),
(152, 18, 1, 625000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-04-16 11:54:00', '2023-04-16 22:42:03'),
(153, 18, 3, 566000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2017-04-16 14:44:00', '2023-04-16 22:45:13'),
(154, 18, 2, 745000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-02-05 23:00:00', '2023-04-16 22:46:37'),
(155, 18, 1, 50000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-02-07 23:00:00', '2023-04-16 22:47:26'),
(156, 8, 1, 25250.00, 250.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Rhys for workers', NULL, NULL, NULL, 15, NULL, 8, NULL, 1, '{\"account_number\":\"2536128892\",\"account_holder_name\":\"Uzay Constructions\"}', '2023-04-16 23:46:21', '2023-04-18 12:45:05'),
(157, 8, 1, 50500.00, 500.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment from Mr Rhys for custom clearance', NULL, NULL, NULL, 15, NULL, 8, NULL, 1, '{\"account_number\":\"10987654321\",\"account_holder_name\":\"Turkey Customs\"}', '2023-04-17 21:40:13', '2023-04-18 12:44:41'),
(158, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, NULL, '{\"account_number\":\"000446511884\",\"account_holder_name\":\"Chloe A Carlos\"}', '2023-04-20 06:51:34', '2023-04-20 07:05:14'),
(159, 12, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 12, NULL, 1, '{\"account_number\":\"000114474375\",\"account_holder_name\":\"Chloe Sandy David\"}', '2023-04-20 15:55:44', '2023-04-20 15:56:41'),
(160, 12, 2, 550000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-04-27 03:27:00', '2023-04-28 20:41:46'),
(161, 12, 1, 3169000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-04-28 11:02:00', '2023-04-28 20:42:31'),
(162, 12, 3, 2500000.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-04-28 08:45:00', '2023-04-28 20:43:21'),
(163, 6, 1, 1800000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, 'TEKFEN CONSTRUCTIONS PAYMENT FOR THE TANAP PROJECT', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-04-12 23:00:00', '2023-05-08 16:58:07'),
(164, 6, 2, 251500.57, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'NOBINA SVERIGE AB', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-05-06 23:00:00', '2023-05-08 17:10:46'),
(167, 6, 2, 12575.75, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'EUROPCAR STOCKHOLM CITY', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-11 23:00:00', '2023-05-09 02:54:32'),
(166, 6, 2, 31525.25, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'INSURANCE DEPOSIT', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-28 23:00:00', '2023-05-09 00:33:12'),
(168, 6, 2, 79750.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-05-07 23:00:00', '2023-05-09 09:32:19'),
(169, 6, 2, 23850.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-05-08 23:00:00', '2023-05-09 16:32:59'),
(170, 6, 2, 66595.55, 0.00, 'dr', 'Withdraw', 'Manual', 2, 'ROBOT MAINTENANCE', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-07 23:00:00', '2023-05-09 16:41:33'),
(171, 6, 1, 98350.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-17 23:00:00', '2023-05-09 17:01:45'),
(172, 6, 2, 379650.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-01-01 23:00:00', '2023-05-09 17:17:59'),
(173, 6, 2, 17590.00, 0.00, 'dr', 'Withdraw', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-01-26 23:00:00', '2023-05-09 17:18:33'),
(174, 6, 1, 99262.80, 982.80, 'dr', 'Wire_Transfer', 'Manual', 2, 'CUSTOMS TAX CLEARANCE', NULL, NULL, NULL, 15, NULL, 6, NULL, 1, '{\"account_number\":\"774-9078103\",\"account_holder_name\":\"Fatih Esentimor\"}', '2023-05-14 23:37:23', '2023-05-14 23:38:26'),
(175, 6, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, 'Payment for Green Renewable Energy', NULL, NULL, NULL, 1, NULL, 6, NULL, 1, '{\"account_number\":\"650091236567890\",\"account_holder_name\":\"Wu Yi co.,Ltd\"}', '2023-05-18 19:52:34', '2023-06-26 02:44:29'),
(176, 18, 1, 550000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2020-02-08 11:56:00', '2023-06-09 02:12:00'),
(177, 18, 1, 50000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2019-06-22 15:33:00', '2023-06-09 02:12:45'),
(178, 18, 1, 850000.00, 0.00, 'cr', 'Deposit', 'Manual', 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2018-11-21 23:00:00', '2023-06-09 02:13:41'),
(179, 18, 2, 1000000.00, 0.00, 'dr', 'Exchange', 'Online', 2, NULL, NULL, NULL, NULL, NULL, NULL, 18, NULL, 1, NULL, '2023-06-09 02:19:57', '2023-06-09 02:19:57'),
(180, 18, 1, 1016570.09, 0.00, 'cr', 'Exchange', 'Online', 2, NULL, NULL, NULL, 179, NULL, NULL, 18, NULL, 1, NULL, '2023-06-09 02:19:57', '2023-06-09 02:19:57'),
(181, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, 1, '{\"account_number\":\"00447654321\",\"account_holder_name\":\"Chloe Davies\"}', '2023-06-09 02:28:40', '2023-06-09 02:56:03'),
(182, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, 1, '{\"account_number\":\"00447654321\",\"account_holder_name\":\"Chloe Davis\"}', '2023-06-10 06:17:21', '2023-06-10 06:18:50'),
(183, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, 1, '{\"account_number\":\"00447654321\",\"account_holder_name\":\"Chloe Davies\"}', '2023-06-11 04:01:44', '2023-06-11 05:18:19'),
(184, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, 1, '{\"account_number\":\"20221017\",\"account_holder_name\":\"Chloe Davies\"}', '2023-06-12 14:01:37', '2023-06-12 14:02:35'),
(185, 18, 1, 101000.00, 1000.00, 'dr', 'Wire_Transfer', 'Manual', 2, NULL, NULL, NULL, NULL, 14, NULL, 18, NULL, 1, '{\"account_number\":\"00447654321\",\"account_holder_name\":\"Chloe Davies\"}', '2023-06-14 08:04:59', '2023-06-14 08:08:51'),
(186, 19, 1, 1000.00, 20.00, 'cr', 'Deposit', 'PayPal', 1, 'Deposit Via PayPal', NULL, NULL, NULL, NULL, 1, 19, NULL, NULL, NULL, '2023-06-18 15:46:17', '2023-06-18 15:46:17'),
(187, 19, 1, 990000.00, 10000.00, 'cr', 'Deposit', 'Payoneer', 2, 'Deposit Via Payoneer', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-06-18 20:21:54', '2023-06-18 20:21:54'),
(188, 19, 1, 100000.00, 2000.00, 'cr', 'Deposit', 'PayPal', 1, 'Deposit Via PayPal', NULL, NULL, NULL, NULL, 1, 19, NULL, NULL, NULL, '2023-06-18 20:24:39', '2023-06-18 20:24:39'),
(190, 19, 1, 100.00, 0.00, 'cr', 'Deposit', 'GiftCard', 2, 'Redeem Gift Card', NULL, NULL, NULL, NULL, NULL, 19, NULL, NULL, NULL, '2023-06-18 20:26:12', '2023-06-18 20:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `profile_picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `sms_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `otp` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `allow_withdrawal` tinyint(4) NOT NULL DEFAULT '1',
  `document_verified_at` timestamp NULL DEFAULT NULL,
  `document_submitted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `account_number`, `user_type`, `role_id`, `branch_id`, `status`, `profile_picture`, `email_verified_at`, `sms_verified_at`, `password`, `provider`, `provider_id`, `country_code`, `remember_token`, `created_at`, `updated_at`, `two_factor_code`, `two_factor_expires_at`, `otp`, `otp_expires_at`, `allow_withdrawal`, `document_verified_at`, `document_submitted_at`) VALUES
(1, 'AlphaOne', 'georgeonline112@gmail.com', NULL, NULL, 'admin', NULL, NULL, 1, 'default.png', '2022-08-15 15:14:15', NULL, '$2y$10$xrP30EKC9ibXlI84f4soae3n/bm65gj96oqHw0OSZW9goMvxCMnSK', NULL, NULL, NULL, 'sXnCZ3LDeUKa354ZjWTvRov7amedm4uzk10ASAWMBlPy7bHzbNJPcLcyOHda', '2022-08-15 15:14:15', '2022-08-15 15:14:15', NULL, NULL, NULL, NULL, 1, NULL, NULL),
(5, 'Dean Waltzer', 'deanwaltzter2005@gmail.com', '8252535173', '20221004', 'customer', NULL, 1, 1, '', '2022-09-04 00:59:45', '2022-09-04 00:59:45', '$2y$10$TGb59xawZybbrauG.pVa6.K7xhvjgtc.1B0y9esqPhKlSfVWUBcyO', NULL, NULL, '1', 'BDSgCxxe7FDRsDl0Mw5EvpaT5UamtbK4ifMBAdssYH7e4v548YktC6UgYFkY', '2022-09-04 01:00:53', '2023-03-16 08:50:09', NULL, NULL, '468505', '2022-10-07 23:20:11', 0, NULL, NULL),
(6, 'George Vashakidze', 'vashageorge@gmail.com', '8102155836', '20221005', 'customer', NULL, 1, 1, '', '2022-10-05 21:57:37', '2022-10-05 21:57:37', '$2y$10$2rL/rZ3yiGDVH4fhGAucVuXpYi/vO6Z0TAWBhTTFL59Jl540xRFQW', NULL, NULL, '1', 'Ue0IFFyvHVBkPbnuVAqoVPtq0oH9fEsgaKidLoeMfhPPwJ7SSvcLFZ8Z5hXu', '2022-10-05 22:11:58', '2023-05-14 23:35:23', NULL, NULL, '631376', '2023-05-18 20:56:18', 1, NULL, NULL),
(7, 'Dylan Pickett', 'dylanpickett498@gmail.com', '2897972562', '20221006', 'customer', NULL, NULL, 1, 'default.png', '2022-10-05 17:42:35', NULL, '$2y$10$nAzM8FKe1dNWE9VsCSiiTuyNXE6ANPtXX/0Z/j3Z3bHVJUx8iZ98C', NULL, NULL, '1', NULL, '2022-10-05 16:52:56', '2022-10-08 01:57:14', NULL, NULL, '266838', '2022-10-08 03:00:57', 0, NULL, NULL),
(8, 'Rhys Jakobsson', 'rhysinthewoods@outlook.com', '6612793148', '20221007', 'customer', NULL, 1, 1, '', '2022-10-07 22:17:43', '2022-10-07 22:17:43', '$2y$10$EkeiB171Gr9XKu61tToq.ugfXhhB/TTZcMhQFEND6xAEB.he.g6a2', NULL, NULL, '1', NULL, '2022-10-07 22:21:21', '2023-04-21 17:12:27', NULL, NULL, '526315', '2023-04-17 22:44:24', 0, NULL, NULL),
(9, 'Collins Alanis', 'Pattymakin2021@gmail.com', '4386009812', '20221008', 'customer', NULL, 1, 1, '', '2022-10-08 02:27:34', '2022-10-08 02:27:34', '$2y$10$6xx9iLC0mqZ5bzsMmAUtC.lpo28Mdsruwn/3sA85xqD64aMWiJfle', NULL, NULL, '1', NULL, '2022-10-08 02:30:46', '2022-10-09 14:33:45', NULL, NULL, NULL, NULL, 0, NULL, NULL),
(10, 'Lawrence Edward Oliver', 'Lawolivergreenenergy@gmail.com', '5309017395', '20221009', 'customer', NULL, NULL, 1, '1680468344EE976F2E-6C7E-41FF-A689-39E9992980C8.jpeg', '2022-12-08 07:36:19', NULL, '$2y$10$tSaFIoHaGohF0uNgIehrrOHkoltB6rVudiP1MeSuV/xR60zC62lN.', NULL, NULL, '1', NULL, '2022-12-08 07:54:35', '2023-04-03 05:45:44', NULL, NULL, '469988', '2023-01-06 19:49:26', 0, NULL, NULL),
(13, 'Jane Gebella Massey.', 'Janemasseyg@gmail.com', '3004664421', '20221012', 'customer', NULL, 1, 1, '', '2022-12-14 21:34:18', NULL, '$2y$10$n4ObM9jwQj5j0byqnXjGo.wscyJ.Pdly7/ULj.ZMDJAViUODKR9kW', NULL, NULL, '61', 'GsMLJ8yGry1SfIcQZ6DYmK6Icgl5V1U3DBQoSipGjOVzhB1PLAqlHCDFriZV', '2022-12-14 21:35:35', '2022-12-15 08:25:11', NULL, NULL, NULL, NULL, 1, NULL, NULL),
(12, 'Craig Henderson', 'Bleudechanel56@gmail.com', '3004422341', '20221011', 'customer', NULL, 1, 0, 'default.png', '2022-12-11 18:50:12', NULL, '$2y$10$zqEwrmqWYBbekVMj/spE5.4XNqN0yqEm6idp0PFANiJnNev.4LDyu', NULL, NULL, '61', '0gaOcu0z2qIGPJuuRA8nbtmFJmT3cFKA7OBeVgsAlJP6v2EVizr6a8n3y9qU', '2022-12-11 18:44:43', '2023-05-05 15:32:04', NULL, NULL, '636607', '2023-04-20 17:00:13', 0, NULL, NULL),
(14, 'Marcus Reed', 'marcusreed1963@gmail.com', '8283738588', '20221013', 'customer', NULL, 1, 1, '1676323345IMG_0503.jpg', '2023-02-14 16:45:51', NULL, '$2y$10$tEVvL5shZARMLzH8sc5i6eDei21SL9dbMolMnQA6xMetL9CVgAXBa', NULL, NULL, '1', 'httVCGzo8Fw1bsNdAxNyztoVQ5cn6dpOQLeGsFe9kCuuhU7oysJQ1SSjiOox', '2023-02-14 07:22:25', '2023-02-14 16:45:51', NULL, NULL, '887818', '2023-02-17 07:15:49', 1, NULL, NULL),
(19, 'nwo50810@zslsz.com', 'nwo50810@zslsz.com', '1234567890', '20221018', 'customer', NULL, NULL, 1, 'default.png', '2023-06-10 04:00:18', NULL, '$2y$10$/jJ7HN55pBys6H21xFVKpuNbsPdQkNpIr0StbJ6OX9JpIX3HD/J2.', NULL, NULL, '1268', NULL, '2023-06-10 03:58:10', '2023-06-10 04:00:18', NULL, NULL, NULL, NULL, 1, NULL, NULL),
(18, 'Craig Henderson', 'bleudechanel57@gmail.com', '2897972564', '20221017', 'customer', NULL, 1, 1, 'default.png', '2023-04-16 06:39:27', NULL, '$2y$10$jf/rOz/hADzZSdjrF0.hkuxdYUElgCfgeU0nY2XumKOXn3qkLZFmW', NULL, NULL, '1', NULL, '2023-04-16 06:38:48', '2023-06-09 02:09:18', NULL, NULL, '796633', '2023-06-14 09:09:31', 1, NULL, NULL),
(17, 'Arvid Vashakide', 'arvidvash@outlook.com', '7187379874', '20221016', 'customer', NULL, 1, 1, '', '2023-04-14 15:26:37', '2023-04-14 15:26:37', '$2y$10$12BekVaf2U9BAAKK7S/MDutzilUGNmjL72Tg64LjdH6fCVZTi3ZP6', NULL, NULL, '1', NULL, '2023-04-14 15:33:22', '2023-04-14 15:33:22', NULL, NULL, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` bigint(20) NOT NULL,
  `minimum_amount` decimal(10,2) NOT NULL,
  `maximum_amount` decimal(10,2) NOT NULL,
  `fixed_charge` decimal(10,2) NOT NULL,
  `charge_in_percentage` decimal(10,2) NOT NULL,
  `descriptions` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_methods`
--

INSERT INTO `withdraw_methods` (`id`, `name`, `image`, `currency_id`, `minimum_amount`, `maximum_amount`, `fixed_charge`, `charge_in_percentage`, `descriptions`, `status`, `requirements`, `created_at`, `updated_at`) VALUES
(1, 'Payoneer', '1662222762Payoneer_rebrands.jpg', 1, 50.00, 10000.00, 0.00, 1.00, 'Bank Transfer\r\nWithdraw Limit ($50.00 - $1,000.00)\r\nWithdraw Charge ($0.00 + 1.00%)', 1, 'null', '2022-08-16 03:13:28', '2022-09-04 01:32:42'),
(2, 'Plaid', '1662223221plaid-01-1.jpg', 1, 100.00, 10000000.00, 0.00, 3.00, 'Withdraw Limit ($100.00 - $10,000.00)\r\nWithdraw Charge ($0.00 + 3.00%)', 1, 'null', '2022-09-04 01:37:51', '2022-09-04 01:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_requests`
--

CREATE TABLE `withdraw_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `method_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `transaction_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_backups`
--
ALTER TABLE `database_backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_requests`
--
ALTER TABLE `deposit_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_translations`
--
ALTER TABLE `faq_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faq_translations_faq_id_locale_unique` (`faq_id`,`locale`);

--
-- Indexes for table `fdrs`
--
ALTER TABLE `fdrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fdr_plans`
--
ALTER TABLE `fdr_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_payments`
--
ALTER TABLE `loan_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_products`
--
ALTER TABLE `loan_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation_items`
--
ALTER TABLE `navigation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navigation_items_parent_id_foreign` (`parent_id`),
  ADD KEY `navigation_items_page_id_foreign` (`page_id`),
  ADD KEY `navigation_items_navigation_id_index` (`navigation_id`);

--
-- Indexes for table `navigation_item_translations`
--
ALTER TABLE `navigation_item_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `navigation_item_translations_navigation_item_id_locale_unique` (`navigation_item_id`,`locale`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_translations`
--
ALTER TABLE `news_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_translations_news_id_locale_unique` (`news_id`,`locale`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `other_banks`
--
ALTER TABLE `other_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `page_translations`
--
ALTER TABLE `page_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_translations_page_id_locale_unique` (`page_id`,`locale`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_translations`
--
ALTER TABLE `service_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_translations_service_id_locale_unique` (`service_id`,`locale`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_translations`
--
ALTER TABLE `setting_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_translations_setting_id_locale_unique` (`setting_id`,`locale`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_messages`
--
ALTER TABLE `support_ticket_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial_translations`
--
ALTER TABLE `testimonial_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `testimonial_translations_testimonial_id_locale_unique` (`testimonial_id`,`locale`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `database_backups`
--
ALTER TABLE `database_backups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_methods`
--
ALTER TABLE `deposit_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit_requests`
--
ALTER TABLE `deposit_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faq_translations`
--
ALTER TABLE `faq_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fdrs`
--
ALTER TABLE `fdrs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fdr_plans`
--
ALTER TABLE `fdr_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_collaterals`
--
ALTER TABLE `loan_collaterals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_payments`
--
ALTER TABLE `loan_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_products`
--
ALTER TABLE `loan_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `navigations`
--
ALTER TABLE `navigations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navigation_items`
--
ALTER TABLE `navigation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `navigation_item_translations`
--
ALTER TABLE `navigation_item_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_translations`
--
ALTER TABLE `news_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_banks`
--
ALTER TABLE `other_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_translations`
--
ALTER TABLE `page_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `service_translations`
--
ALTER TABLE `service_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `setting_translations`
--
ALTER TABLE `setting_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_ticket_messages`
--
ALTER TABLE `support_ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonial_translations`
--
ALTER TABLE `testimonial_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
