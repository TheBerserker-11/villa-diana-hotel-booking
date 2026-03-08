-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2026 at 06:50 PM
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
-- Database: `hoteldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `capacity_children` int(11) DEFAULT NULL,
  `available_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `type`, `description`, `price`, `image`, `capacity`, `capacity_children`, `available_date`, `created_at`, `updated_at`) VALUES
(1, 'Wedding', 'Aspen', 'sarap', 5000.00, 'events/xovUihImxdv3vWRD1V1EERN6PMDcCgS4robaKaAE.jpg', 500, 200, '2025-12-16', '2025-12-02 07:51:43', '2025-12-02 08:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_images`
--

INSERT INTO `event_images` (`id`, `event_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'events/Da2ndgqSrytZETlZfJDB7mqU0beZDlQke3Xzh9NN.jpg', '2025-12-02 07:51:43', '2025-12-02 07:51:43'),
(2, 1, 'events/rxMbyLLJXWNJutUc1fkW2t9VrHaWFXjyddYPOdEf.jpg', '2025-12-02 07:51:43', '2025-12-02 07:51:43'),
(3, 1, 'events/1ZG2VrnXbBHsBaHTKpaWdSSVPPwuJmTZbqktBTDA.jpg', '2025-12-02 07:51:43', '2025-12-02 07:51:43'),
(4, 1, 'events/WanUAmobNxfPylxHqFXlrGHyvcPkofHxoVM8JfHC.jpg', '2025-12-02 07:51:43', '2025-12-02 07:51:43'),
(5, 1, 'events/RYFQVS5pB4oQ41ugVrbJPV7ZJZ3SHwsHlCr4C9FH.jpg', '2025-12-02 07:51:43', '2025-12-02 07:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_07_014731_create_room_types_table', 1),
(6, '2023_03_07_014753_create_rooms_table', 1),
(7, '2023_03_07_014808_create_orders_table', 1),
(8, '2025_08_06_171212_create_customers_table', 1),
(9, '2025_08_13_155002_create_feedbacks_table', 1),
(10, '2025_08_14_061121_create_events_table', 1),
(11, '2025_11_20_052321_add_bed_type_to_rooms_table', 1),
(12, '2025_12_01_110247_create_event_images_table', 1),
(14, '2025_12_02_172908_create_reviews_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `check_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `check_out` timestamp NOT NULL DEFAULT current_timestamp(),
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reference_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `check_in`, `check_out`, `room_id`, `user_id`, `created_at`, `updated_at`, `reference_code`) VALUES
(1, '2025-12-03 16:00:00', '2025-12-04 16:00:00', 10, 2, '2025-12-02 08:14:05', '2025-12-02 08:14:05', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `stay_date` date DEFAULT NULL,
  `helpful_votes` int(11) NOT NULL DEFAULT 0,
  `insider_tip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `avatar`, `location`, `title`, `content`, `rating`, `stay_date`, `helpful_votes`, `insider_tip`, `created_at`, `updated_at`) VALUES
(6, 'ertyr', 'avatars/Hx4iDDI6wcNmRzA8eSZC16OkG43vcpH4GerTWdAR.jpg', '345678', 'dfdhghkjlk', 'sgdfhgjkfdgewgerggegsgsgsg', 2, '2025-12-26', 2, NULL, '2025-12-02 10:04:43', '2025-12-02 10:08:28'),
(7, 'Jenecel L Molina', 'avatars/QFlXcYSPQO3aAnSVMlyh8M7nWNkSxPeVcPhMhrw8.jpg', 'Santiago City', NULL, 'vfbcgnvhbjnkml,', 5, '2026-01-22', 0, NULL, '2026-01-10 08:55:00', '2026-01-10 08:55:00'),
(8, 'SERE', 'avatars/DCH5gir9Bxd0nFjPx8OOAauSs3hMWvEgBpadLEok.jpg', 'warewtreyru', 'asrdtytu', 'ateyrtuytiuy', 1, '2026-01-18', 0, NULL, '2026-01-10 09:04:05', '2026-01-10 09:04:05'),
(9, 'Jenecel L Molina', 'avatars/iogFPGpnPmwYqaaISvpXN08I0K1oAtwTy5T4l2KE.jpg', 'rw4te565', '3435467', 'qewrtrytu', 1, '2026-01-23', 0, NULL, '2026-01-10 09:05:43', '2026-01-10 09:05:43'),
(10, 'Jenecel L Molina', 'avatars/PtnTJZpKOQajbq6dc2TDMjBARGKdAvZZl6CcY2iI.jpg', 'fsdgfh', 'ertyterut', 'asdfgjhkhj', 3, '0456-03-12', 0, NULL, '2026-01-10 09:06:16', '2026-01-10 09:06:16'),
(11, 'sweretr', 'avatars/EVtoy8I8zTPmcQ9MQPgWhkYpFFRZly6uMRJjKnN4.jpg', 'qerwteyrtuu', 'wrtreyrut', 'wretytkuhgfgdwert', 5, '2026-01-16', 0, NULL, '2026-01-10 09:08:25', '2026-01-10 09:08:25'),
(12, 'sdfretrytuyi', NULL, 'wretuytiyo', 'wqertyruty', 'rewtreyrutioiupi', 1, '2026-01-08', 0, NULL, '2026-01-10 09:15:56', '2026-01-10 09:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_room` int(11) NOT NULL,
  `no_beds` int(11) NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `desc` text NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `kuula_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bed_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `total_room`, `no_beds`, `price`, `image`, `status`, `desc`, `room_type_id`, `kuula_link`, `created_at`, `updated_at`, `bed_type`) VALUES
(1, 1, 1, 1595, 'superior.jpg', 1, '\r\nIf you’re in town for business, the Superior Room has been specially designed for your comfort and convenience. This room is comfy and cozy! Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Writing Desk, Villa Diana Personal Care Kit, Bath Towel, Bottled Water. * WITH HOT SHOWER* IMPORTANT NOTE: **Room rate includes 1 person only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel. ** **Kids below 7 years of age are complimentary.', 1, 'https://kuula.co/share/collection/7DwH7?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1', '2025-12-02 06:55:47', '2025-12-02 06:55:47', '1'),
(2, 1, 1, 1995, 'singledeluxe.jpg', 1, 'The quiet, spacious room features a Deluxe queen sized bed for a good night’s sleep and a work station area. Features: Indulgent bed with 300-count cotton linen & duvet sheets, Complimentary Wi-Fi, Writing desk, Villa Diana Personal Care Kit, Bath Towels, Hot & Cold Shower & Bottled Water. IMPORTANT NOTE: **Room rate include 2 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel** **Kids below 7 years of age are complimentary.', 2, 'https://kuula.co/share/collection/7DwHk?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1', '2025-12-02 06:55:47', '2025-12-02 06:55:47', '1'),
(3, 1, 4, 3895, 'famroom.jpg', 1, 'The fun & relaxed atmosphere of the Family Room makes it the perfect getaway for the entire family! Equipped with a Dining Area & a Mini Kitchen Space. The 1st bedroom is located on the first floor and the 2nd bedroom on the 2nd Floor. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Writing Desk, Villa Diana Personal Care Kit, Bath Towels, Hot & Cold Shower & Complimentary Bottled Water. IMPORTANT NOTE: **Room rates include 4 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel.**', 3, 'https://kuula.co/share/collection/7DwHF?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1', '2025-12-02 06:55:47', '2025-12-02 06:55:47', '2'),
(4, 1, 2, 2995, 'doubledeluxebalcony.jpg', 1, 'Decorated in pastel colors with a balcony over looking the poolside, this charming double deluxe room creates a soothing ambience that is perfect for some Rest and Relaxation. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Writing Desk, Villa Diana Personal Care Kit, Bath Towels, Hot & Cold Shower & Complimentary Bottled Water. IMPORTANT NOTE: **Room rates include 2 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel.** **Kids below 7 years of age are complimentary.', 4, 'https://kuula.co/share/collection/7DwHJ?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1', '2025-12-02 06:55:47', '2025-12-02 06:55:47', '2'),
(5, 1, 2, 2495, 'doubledeluxe.jpg', 1, 'Decorated in pastel colors, this charming double deluxe room creates a soothing ambience that is perfect for some Rest and Relaxation. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Writing Desk, Villa Diana Personal Care Kit, Bath Towels, Hot & Cold Shower & Complimentary Bottled Water. IMPORTANT NOTE: **Room rates include 2 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel.**', 5, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '2'),
(6, 1, 1, 3195, 'executive.jpg', 1, 'Combining luxury and comfort, the Executive room is the perfect escape to a much needed vacation or maybe for some work and relaxation with Jacuzzi. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Writing Desk, Mini Bar, Vanity Mirror, Separate Toilet and Bath, Spacious Bathroom, Hairdryer, Villa Diana Personalized Toiletries, Bath Towels, Hot & Cold Shower & Complimentary Bottled Water. IMPORTANT NOTE: **Room rates include 2 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel.**', 6, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '1'),
(7, 1, 1, 2400, 'vip.jpg', 1, 'Decorated with exquisite taste, the VIP room is the perfect suite for combined work and relaxation. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Coffee table, Writing Desk, Hairdryer, Villa Diana Personalized Toiletries, Bath Towels,Hot & Cold Shower & Complimentary Bottled Water. IMPORTANT NOTE: **Room rates include 2 persons only. Any additional heads will be charged as extra person/extra bed. Extra head/bed can be paid through online or upon check in at the hotel.**', 7, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '1'),
(8, 1, 1, 8500, 'hcabin.webp', 1, 'The Cabin sleeps up to 16-20 guests, offers 2 private bathrooms, Double Deck Beds, Air-condition, Pillows & Blankets, Mezzanine Floor and FREE WiFi. IMPORTANT NOTE: **Towels, Toiletries are included in the room rate.** **Breakfast is not included in the room rates.** **NO HOT SHOWER**', 8, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '1'),
(9, 1, 2, 2795, 'vipdouble.jpg', 1, 'The VIP Double Deluxe Room provides extra space your family needs for a perfect holiday experience. Features: Indulgent bed with 300-count cotton linen and duvet sheets, Complimentary Wi-Fi, Coffee Table, Villa Diana Personalized toiletries, Spacious Bathroom, Bath Towels, Hot & Cold Shower & Complimentary Bottled Water. Our VIP Double Deluxe room can fit up to 15 Guests. Extra Mattress can be requested with additional fee. IMPORTANT NOTE: **Room rates include 2 persons only. Any additional heads will be charged as extra person. Extra head can be paid through online or upon check in at the hotel.**', 9, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '2'),
(10, 1, 20, 9500, 'cabin.jpg', 1, 'The Cabin sleeps up to 16-20 guests, offers 2 private bathrooms, Double Deck Beds, Air-condition, Pillows & Blankets, Mezzanine Floor and FREE WiFi. IMPORTANT NOTE: **Towels, Toiletries are included in the room rate.** **Breakfast is not included in the room rates.** **NO HOT SHOWER**', 10, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47', '3'),
(11, 22, 1, 10500, 'vd1.webp', 1, 'The Cabin sleeps up to 16-20 guests, offers 2 private bathrooms, Double Deck Beds, Air-condition, Pillows & Blankets, Mezzanine Floor and FREE WiFi. IMPORTANT NOTE: **Towels, Toiletries are included in the room rate.** **Breakfast is not included in the room rates.** **NO HOT SHOWER**', 12, NULL, NULL, NULL, '22'),
(12, 22, 1, 10500, 'vd2.webp', 1, 'The Cabin sleeps up to 16-20 guests, offers 2 private bathrooms, Double Deck Beds, Air-condition, Pillows & Blankets, Mezzanine Floor and FREE WiFi. IMPORTANT NOTE: **Towels, Toiletries are included in the room rate.** **Breakfast is not included in the room rates.** **NO HOT SHOWER**', 13, NULL, NULL, NULL, '22');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Superior', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(2, 'Single Deluxe', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(3, 'Family', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(4, 'Balcony Deluxe', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(5, 'Double Deluxe', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(6, 'Executive', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(7, 'VIP', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(8, 'Hunter Cabin', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(9, 'VIP Double Deluxe', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(10, 'Yellow Cabin', '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(11, 'Blue Cabin', '2025-12-01 15:00:44', '2025-12-02 15:00:44'),
(12, 'VD Cabin 1', NULL, NULL),
(13, 'VD Cabin 2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `last_name`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$cncbgn6gkSZtWO0xT4SQpuasPAI0MiEc7aAtCn0sUvDofpo.K5qTq', 1, NULL, NULL, NULL, NULL, '2025-12-02 06:55:47', '2025-12-02 06:55:47'),
(2, 'Jenecel', 'user@gmail.com', NULL, '$2y$10$TrMTZYeRNF1p2t6xzCUvcOVkNlw6RkIjPD/uBIPlMbe7mVPzMpc8W', 0, 'Molina', '09534412019', NULL, NULL, '2025-12-02 06:55:47', '2025-12-02 07:21:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_images_event_id_foreign` (`event_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_room_id_foreign` (`room_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_room_id_foreign` (`room_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
