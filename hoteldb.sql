-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 04:26 PM
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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Jenecel L Molina', 'jhenmolina63@gmail.com', '09534412019', 'Aglipay, Quirino', '2025-08-06 09:24:06', '2025-08-06 09:24:06');

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
(1, 'Weddings', 'Weddings', 'Villa Diana Hotel has been a home to Numerous Weddings.. From Garden Weddings to Lavish Ones.. Celebrate your Dream Wedding surrounded by Trees, Flowers, and everything Nature..! Treat yourself to a hassle free planning by booking everything all at one place. From Food and venue to accommodation, even your wedding dress, we\'ll take care of that! We also have a list of recommended suppliers that would be very helpful to make your dream wedding come true! Contact us today!', NULL, 'events/weddings.jpg', 500, 0, NULL, NULL, NULL),
(2, 'Debuts', 'Debuts', 'Every girl dreams of having a Fairy Tale story. Fulfill your dream by celebrating your Debut here at Villa Diana Hotel.. May it be a themed debut or a simple one, we will help you in finding the services that would suit your requests and needs.. Food, accommodation, and venue won\'t be a problem! We will take care of that one. If you would need other services, we will be able to give you a list of our preferred suppliers. Contact us today!', NULL, 'events/debuts.jpg', 200, 0, NULL, NULL, NULL),
(3, 'Birthdays', 'Birthdays', 'Celebrate your special day with us! Whether it\'s your 60th Birthday Celebration, A Christening or 7th Birthday.. we\'ve got you all covered! From Food, Accommodation, to your event venue! If you would need other services, we will be able to give you a list of our preferred suppliers. Contact us today!', NULL, 'events/birthdays.jpg', 150, 50, NULL, NULL, NULL),
(4, 'Meetings/Seminar', 'Meetings/Seminar', 'We have several spaces for your Meetings/seminars. You can opt for an air conditioned or non airconditioned room. We also offer packages which includes Food, Accommodation & Venue. No need to transfer places. Everything you need is in here! Contact us today! Email events@villadianahotel.com', NULL, 'events/meetings.jpg', 150, 0, NULL, NULL, NULL),
(5, 'Convention', 'Convention', 'You\'ve got a convention coming up? We will take care of all your needs. From accommodation, to food and venue. Contact us today!', NULL, 'events/convention.jpg', 700, 0, NULL, NULL, NULL),
(6, 'Retreat', 'Retreat', 'A Moment of silence & realization.. That\'s what we need when we go to retreats. Far from the crowd, away from the city life, and A real connection to Our Nature\'s Gift. Our huge garden spaces can provide you with all of that. Contact us today!', NULL, 'events/retreat.jpg', 100, 0, NULL, NULL, NULL),
(7, 'Event Venues', 'Event Venues', 'THE ASPEN HALL (Up to 700pax) - NEWLY BUILT GRAND VENUE and Fully Air conditioned. HUNTERY VALLEY HALL (Up to 150pax). THE GRAND PAVILION (Up to 350pax) - Newly Renovated and Fully Air conditioned. CONFERENCE ROOM (Up to 150pax). PATIO DOLORES (Up to 80guests). LORNA\'S GARDEN (Up to 150pax). PERGOLA (Up to 40pax). POOLSIDE (Up to 100pax). VILLA DIANA OPEN FIELD (Up to 1500pax).', NULL, 'events/venues.jpg', 1500, 0, NULL, NULL, NULL),
(8, 'Diana Couture', 'Diana Couture', 'Diana Couture PH - WEDDING DRESS | SPECIAL EVENTS | COCKTAIL DRESS | ENGAGEMENT DRESS | CUSTOM MADE COUTURE DRESSES. For inquiries, please fill up the form. Contact us today!', NULL, 'events/diana_couture.jpg', NULL, NULL, NULL, NULL, NULL);

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
  `rating` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `room_id`, `user_name`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jenecel', 'i dont like it', 1, '2025-08-13 08:12:01', '2025-08-13 08:12:01');

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
(8, '2025_08_06_171212_create_customers_table', 2),
(9, '2025_08_13_140752_add_bed_type_to_rooms_table', 3),
(10, '2025_08_13_155002_create_feedbacks_table', 4),
(11, '2025_08_14_061121_create_events_table', 5),
(13, '2025_08_14_000000_create_event_images_table', 6),
(14, '2025_08_27_071626_create_event_images_table', 7);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `check_in`, `check_out`, `room_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2025-08-19 16:00:00', '2025-08-24 16:00:00', 7, 4, '2025-08-13 07:07:27', '2025-08-13 07:07:27');

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
  `bed_type` varchar(255) DEFAULT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `total_room`, `no_beds`, `price`, `image`, `status`, `desc`, `bed_type`, `room_type_id`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 110, 'img/room-3.jpg', 1, 'Free Coffee', NULL, 1, '2025-08-06 08:53:36', '2025-08-06 08:53:36'),
(2, 3, 1, 184, 'img/room-1.jpg', 1, 'Free Coffee', NULL, 2, '2025-08-06 08:53:36', '2025-08-06 08:53:36'),
(3, 5, 3, 123, 'img/room-1.jpg', 1, 'Free Coffee', NULL, 3, '2025-08-06 08:53:36', '2025-08-06 08:53:36'),
(4, 5, 1, 1595, 'img/superior.jpg', 1, 'Superior Room - 1 SINGLE. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(5, 5, 1, 1995, 'img/single_deluxe.jpg', 1, 'Single Deluxe - 1 QUEEN. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(6, 5, 2, 2495, 'img/double_deluxe.jpg', 1, 'Double Deluxe - 2 TWIN. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(7, 5, 2, 2795, 'img/vip_double_deluxe.jpg', 1, 'VIP Double Deluxe - 2 TWIN. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(8, 5, 1, 2400, 'img/vip_room.jpg', 1, 'VIP Room - 1 QUEEN. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(9, 5, 1, 3195, 'img/executive.jpg', 1, 'Executive Room - 1 QUEEN. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(10, 5, 4, 3895, 'img/family.jpg', 1, 'Family Room - 2 TWIN, 2 SINGLE. ', NULL, 1, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(11, 5, 8, 0, 'img/vd_cabin1.jpg', 1, 'VD Cabin 1 - BUNK BEDS. ', NULL, 2, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(12, 5, 8, 0, 'img/vd_cabin2.jpg', 1, 'VD Cabin 2 - BUNK BEDS. ', NULL, 2, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(13, 5, 8, 8500, 'img/hunter_cabin.jpg', 1, 'Hunter Cabin - BUNK BEDS. ', NULL, 2, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(14, 5, 8, 9500, 'img/yellow_cabin.jpg', 1, 'Yellow Cabin - BUNK BEDS. ', NULL, 2, '2025-08-13 13:25:36', '2025-08-13 13:25:36'),
(15, 5, 8, 8500, 'img/blue_cabin.jpg', 1, 'Blue Cabin - BUNK BEDS. ', NULL, 2, '2025-08-13 13:25:36', '2025-08-13 13:25:36');

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
(1, 'Standard', '2025-08-06 08:53:36', '2025-08-06 08:53:36'),
(2, 'Deluxe', '2025-08-06 08:53:36', '2025-08-06 08:53:36'),
(3, 'Superior', '2025-08-06 08:53:36', '2025-08-06 08:53:36');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `last_name`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Jenecel L Molina', 'jhenmolina63@gmail.com', NULL, '$2y$10$omLs6No189k8sFS7eJq0Re0o60aB5FLOW1vh.tC7.jdf52ZW3.5SS', 0, NULL, NULL, NULL, '2025-08-06 09:01:29', '2025-08-06 09:01:29'),
(4, 'Daniel', 'daniel@gmail.com', NULL, '$2y$10$A9oHdJX/zax.vUzDHCgoEe0t8XhFUG7BA2W3lxsw/gqJf86z7.496', 0, NULL, NULL, NULL, '2025-08-06 09:25:19', '2025-08-06 09:25:19'),
(5, 'Jeri', 'jerichoo@gmail.com', NULL, '$2y$10$4ksLSLdmI0QcGOe5wDXFZOb4Wevy6AUcSIIw40jJ5IuuKbhS9.mHm', 0, NULL, NULL, NULL, '2025-08-13 07:19:22', '2025-08-13 07:19:22'),
(9, 'admin', 'admin@gmail.com', NULL, '$2y$10$3vdsHkC1wfL0C0Rt2YBbH.hRnfamDj5nbaNTTOKUcQJILTw8iEyra', 1, NULL, NULL, NULL, '2025-08-26 23:25:16', '2025-08-26 23:25:16');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
