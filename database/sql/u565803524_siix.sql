
DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@smartpowerph.com|119.94.167.195', 'i:2;', 1747762973),
('admin@smartpowerph.com|119.94.167.195:timer', 'i:1747762973;', 1747762973),
('admin@smartpowerph.com|127.0.0.1', 'i:1;', 1747637217),
('admin@smartpowerph.com|127.0.0.1:timer', 'i:1747637216;', 1747637216),
('admin@smartpowerph.com|136.158.10.191', 'i:2;', 1750329397),
('admin@smartpowerph.com|136.158.10.191:timer', 'i:1750329397;', 1750329397),
('ghowell00@yahoo.com|2a03:b0c0:1:e0::9097:1001', 'i:1;', 1763617955),
('ghowell00@yahoo.com|2a03:b0c0:1:e0::9097:1001:timer', 'i:1763617955;', 1763617955),
('hugolehmann92@outlook.com|2a03:b0c0:1:e0::9097:1001', 'i:1;', 1763617958),
('hugolehmann92@outlook.com|2a03:b0c0:1:e0::9097:1001:timer', 'i:1763617958;', 1763617958),
('james.zarsuelo@indigo21.com|136.158.10.191', 'i:1;', 1747650159),
('james.zarsuelo@indigo21.com|136.158.10.191:timer', 'i:1747650159;', 1747650159),
('katheryn97@twinbash.co|2a03:b0c0:1:e0::9097:1001', 'i:3;', 1763617952),
('katheryn97@twinbash.co|2a03:b0c0:1:e0::9097:1001:timer', 'i:1763617952;', 1763617952),
('mrgabthan@smartpowerph.com|112.200.234.10', 'i:1;', 1751866207),
('mrgabthan@smartpowerph.com|112.200.234.10:timer', 'i:1751866207;', 1751866207),
('mrgabthan@smartpowerph.com|2001:4451:4160:7300:8926:57a7:cb0e:7ff0', 'i:1;', 1751865631),
('mrgabthan@smartpowerph.com|2001:4451:4160:7300:8926:57a7:cb0e:7ff0:timer', 'i:1751865631;', 1751865631),
('mrgbathan@jsmartpowerph.com|2001:4451:4154:2700:bd0e:b269:6d02:7c4f', 'i:2;', 1760060439),
('mrgbathan@jsmartpowerph.com|2001:4451:4154:2700:bd0e:b269:6d02:7c4f:timer', 'i:1760060439;', 1760060439),
('mrgbathan@smarpowerph.com|112.200.234.10', 'i:2;', 1748222836),
('mrgbathan@smarpowerph.com|112.200.234.10:timer', 'i:1748222836;', 1748222836),
('mrgbathan@smartpowerph.com|111.90.198.84', 'i:2;', 1756424212),
('mrgbathan@smartpowerph.com|111.90.198.84:timer', 'i:1756424212;', 1756424212),
('support@indigo21.com|180.190.121.10', 'i:1;', 1744649660),
('support@indigo21.com|180.190.121.10:timer', 'i:1744649660;', 1744649660),
('test@gmail.com|180.190.111.22', 'i:1;', 1759853306),
('test@gmail.com|180.190.111.22:timer', 'i:1759853306;', 1759853306),
('test@indigo21.com|180.190.212.116', 'i:1;', 1759243848),
('test@indigo21.com|180.190.212.116:timer', 'i:1759243848;', 1759243848),
('test@indigo21.com|180.190.73.39', 'i:2;', 1756198055),
('test@indigo21.com|180.190.73.39:timer', 'i:1756198055;', 1756198055),
('test@smartpowerph.com|180.190.121.57', 'i:1;', 1745864617),
('test@smartpowerph.com|180.190.121.57:timer', 'i:1745864617;', 1745864617),
('user@smartpower.com|149.30.138.176', 'i:1;', 1762343278),
('user@smartpower.com|149.30.138.176:timer', 'i:1762343278;', 1762343278),
('user@smartpower.com|210.1.64.194', 'i:1;', 1750397445),
('user@smartpower.com|210.1.64.194:timer', 'i:1750397445;', 1750397445),
('user@smartpower.com|2405:8d40:4483:1521:1840:45b9:261c:27ea', 'i:1;', 1747632825),
('user@smartpower.com|2405:8d40:4483:1521:1840:45b9:261c:27ea:timer', 'i:1747632825;', 1747632825),
('user@smartpowerp.com|111.90.195.6', 'i:2;', 1750643024),
('user@smartpowerp.com|111.90.195.6:timer', 'i:1750643024;', 1750643024),
('user@smartpowerph.com|61.245.23.170', 'i:2;', 1750321434),
('user@smartpowerph.com|61.245.23.170:timer', 'i:1750321434;', 1750321434),
('user1@example.com|210.1.64.194', 'i:1;', 1745371018),
('user1@example.com|210.1.64.194:timer', 'i:1745371018;', 1745371018);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--
DROP TABLE IF EXISTS `failed_jobs`;

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
-- Table structure for table `gateways`
--
DROP TABLE IF EXISTS `gateways`;

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `customer_code` varchar(255) NOT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `gateway_code` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `location_id`, `customer_code`, `gateway`, `gateway_code`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 18, 'SIIX', '1', 'GAT-01', 'Gateway on IIDA', '2025-03-20 22:26:56', '2025-03-20 22:26:56', NULL),
(2, 19, 'SIIX', '2', 'GAT-02', 'Gateway on Canteen', '2025-03-20 22:27:47', '2025-03-20 22:27:47', NULL),
(3, 24, 'SIIX', '3', 'GAT-03', 'Gateway on EOL', '2025-03-20 22:28:08', '2025-03-20 22:28:08', NULL),
(4, 25, 'SIIX', '4', 'GAT-04', 'Gateway on EE Room', '2025-03-20 22:28:37', '2025-03-20 22:28:37', NULL),
(5, 21, 'SIIX', '5', 'GAT-05', 'Gateway on SMT Area', '2025-03-20 22:29:02', '2025-03-20 22:29:02', NULL),
(6, 26, 'SIIX', '6', 'GAT-06', 'Gateway on EE Room EMS Building 1', '2025-04-30 13:43:55', '2025-04-30 13:43:55', NULL),
(7, 8, 'SIIX', '7', 'GAT-07', 'Gateway on EE Room Building 3', '2025-11-26 19:53:32', '2025-11-26 19:53:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--
DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--
DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--
DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_code` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_code`, `location_name`, `pid`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SEP', 'SEP', NULL, '2025-03-02 01:26:56', '2025-03-02 01:26:56', NULL),
(2, 'EMS', 'EMS', '1', '2025-03-02 01:28:08', '2025-03-02 01:28:08', NULL),
(3, 'Injection', 'Injection', '1', '2025-03-02 01:28:59', '2025-03-02 01:28:59', NULL),
(4, 'CIP2', 'CIP2', '1', '2025-03-02 01:29:11', '2025-03-02 01:29:11', NULL),
(5, 'Building 4', 'Building 4', '1', '2025-03-02 01:30:20', '2025-03-02 01:30:20', NULL),
(6, 'Building 1', 'Building 1', '2', '2025-03-02 01:30:32', '2025-03-02 01:30:32', NULL),
(7, 'Building 2', 'Building 2', '2', '2025-03-02 01:31:51', '2025-03-02 01:31:51', NULL),
(8, 'Building 3', 'Building 3', '2', '2025-03-02 01:32:04', '2025-03-02 01:32:04', NULL),
(9, '1st Floor', '1st Floor', '3', '2025-03-02 01:32:30', '2025-03-02 01:32:30', NULL),
(10, '2nd Floor', '2nd Floor', '3', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(11, '1st Floor', '1st Floor', '6', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(12, '2nd Floor', '2nd Floor', '6', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(13, '1st Floor', '1st Floor', '7', '2025-03-02 01:32:30', '2025-03-02 01:32:30', NULL),
(14, '2nd Floor', '2nd Floor', '7', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(15, '1st Floor', '1st Floor', '8', '2025-03-02 01:32:30', '2025-03-02 01:32:30', NULL),
(16, '2nd Floor', '2nd Floor', '8', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(17, 'IIDA line', 'IIDA line', '11', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(18, 'IIDA Office', 'IIDA Office', '11', '2025-03-02 01:32:49', '2025-03-02 01:32:49', NULL),
(19, 'Canteen', 'Canteen', '12', NULL, NULL, NULL),
(20, 'General Office', 'General Office', '12', NULL, NULL, NULL),
(21, 'SMT Area', 'SMT Area', '13', NULL, NULL, NULL),
(22, 'A1 reflow', 'A1 reflow', '25', NULL, '2025-03-23 18:50:54', '2025-03-23 18:50:54'),
(23, 'B5 reflow', 'B5 reflow', '21', NULL, '2025-03-23 18:51:04', '2025-03-23 18:51:04'),
(24, 'EOL', 'EOL', '14', NULL, '2025-03-22 10:29:04', NULL),
(25, 'EE Room', 'EE Room Bldg 2', '13', '2025-03-20 21:16:10', '2025-05-16 19:05:44', NULL),
(26, 'EE Room B1', 'EE Room B1', '6', '2025-04-30 13:39:16', '2025-04-30 13:39:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_29_090253_create_locations_table', 1),
(5, '2025_01_29_090317_create_gateways_table', 1),
(6, '2025_01_29_090335_create_sensor_types_table', 1),
(7, '2025_01_29_090336_create_sensor_models_table', 1),
(8, '2025_01_29_090340_create_sensors_table', 1),
(9, '2025_01_29_090520_create_sensor_logs_table', 1),
(10, '2025_01_30_050145_create_sensor_offlines_table', 1),
(11, '2025_02_14_042309_alter_sensor_offlines_table', 1),
(12, '2025_02_14_045008_alter_gateways_table', 1),
(13, '2025_02_17_071232_create_user_types_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--
DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--
DROP TABLE IF EXISTS `sensors`;

CREATE TABLE `sensors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slave_address` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `sensor_model_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`id`, `slave_address`, `description`, `location_id`, `gateway_id`, `sensor_model_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2', 'IIDA PP-100V', 17, 1, 1, '2025-03-20 22:32:53', '2025-03-20 22:37:17', NULL),
(2, '3', 'IIDA PP-200V', 17, 1, 1, '2025-03-20 22:33:12', '2025-03-20 22:37:24', NULL),
(3, '1', 'IIDA PP-220V', 17, 1, 1, '2025-03-20 22:33:31', '2025-03-20 22:37:32', NULL),
(4, '6', 'IIDA PP-HDA-AP', 17, 1, 1, '2025-03-20 22:33:52', '2025-03-20 22:37:40', NULL),
(5, '4', 'PP-CANTEEN', 19, 2, 1, '2025-03-20 22:37:03', '2025-03-20 22:37:03', NULL),
(6, '5', 'PP-GED/BPO', 19, 2, 1, '2025-03-20 22:38:00', '2025-05-26 11:22:42', NULL),
(7, '7', 'PP-GenOffice', 19, 2, 1, '2025-03-20 22:38:20', '2025-05-26 11:21:39', NULL),
(8, '9', 'EOL MP-100V-2-3', 24, 3, 1, '2025-03-20 22:39:35', '2025-03-22 15:21:55', NULL),
(9, '8', 'EOL MP-2-3', 24, 3, 1, '2025-03-20 22:39:54', '2025-03-22 15:20:43', NULL),
(10, '10', 'SWS Reflow A4', 25, 4, 2, '2025-03-20 22:40:45', '2025-03-23 21:22:20', NULL),
(11, '11', 'B2 Reflow', 25, 4, 2, '2025-03-20 22:41:28', '2025-05-18 10:32:57', NULL),
(12, '12', 'A1 Reflow', 25, 4, 1, '2025-03-20 22:41:48', '2025-03-23 21:22:44', NULL),
(13, '13', 'A2 Reflow', 21, 5, 1, '2025-03-20 22:42:04', '2025-03-26 18:32:13', NULL),
(14, '14', 'A3 Reflow', 21, 5, 1, '2025-03-20 22:42:22', '2025-03-26 18:32:40', NULL),
(15, '20', 'MDP', 26, 6, 1, '2025-04-30 17:12:36', '2025-04-30 17:12:36', NULL),
(16, '30', 'CB1000 - TX1', 25, 4, 2, '2025-11-26 21:33:11', '2025-11-26 22:10:49', NULL),
(17, '31', 'CB1000 - TX2', 25, 4, 2, '2025-11-26 21:33:39', '2025-11-26 22:10:57', NULL),
(18, '32', 'CB2000 - TX3', 25, 4, 2, '2025-11-26 21:34:08', '2025-11-26 22:11:05', NULL),
(19, '33', 'MDP-2', 8, 7, 1, '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_logs`
--
DROP TABLE IF EXISTS `sensor_logs`;

CREATE TABLE `sensor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `sensor_id` bigint(20) UNSIGNED NOT NULL,
  `voltage_ab` double DEFAULT NULL,
  `voltage_bc` double DEFAULT NULL,
  `voltage_ca` double DEFAULT NULL,
  `current_a` double DEFAULT NULL,
  `current_b` double DEFAULT NULL,
  `current_c` double DEFAULT NULL,
  `real_power` double DEFAULT NULL,
  `apparent_power` double DEFAULT NULL,
  `energy` double DEFAULT NULL,
  `temperature` double DEFAULT NULL,
  `humidity` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `flow` double DEFAULT NULL,
  `pressure` double DEFAULT NULL,
  `co2` double DEFAULT NULL,
  `pm25_pm10` double DEFAULT NULL,
  `o2` double DEFAULT NULL,
  `nox` double DEFAULT NULL,
  `co` double DEFAULT NULL,
  `s02` double DEFAULT NULL,
  `datetime_created` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `sensor_models`
--
DROP TABLE IF EXISTS `sensor_models`;

CREATE TABLE `sensor_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sensor_model` varchar(255) NOT NULL,
  `sensor_brand` varchar(255) NOT NULL,
  `sensor_type_id` bigint(20) UNSIGNED NOT NULL,
  `sensor_reg_address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_models`
--

INSERT INTO `sensor_models` (`id`, `sensor_model`, `sensor_brand`, `sensor_type_id`, `sensor_reg_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PM2120', 'Schneider', 2, '3019,3021,3023,2999,3001,3003,3059,3075,2699', '2025-03-19 01:33:52', '2025-03-22 18:24:13', NULL),
(2, 'SDM120', 'Eastron', 2, '200,202,204,6,8,10,52,56,342', '2025-03-22 09:17:04', '2025-03-26 12:55:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_offlines`
--
DROP TABLE IF EXISTS `sensor_offlines`;

CREATE TABLE `sensor_offlines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `query` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_offlines`
--

INSERT INTO `sensor_offlines` (`id`, `query`, `created_at`, `updated_at`, `deleted_at`, `gateway_id`) VALUES
(184, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (30, 25, 4, 1, \'CB1000 - TX1\', \'2025-11-26 21:33:11\', \'2025-11-26 21:33:11\')', '2025-11-26 21:33:11', '2025-11-26 21:33:11', NULL, 7),
(191, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (31, 25, 4, 1, \'CB1000 - TX2: 31\', \'2025-11-26 21:33:39\', \'2025-11-26 21:33:39\')', '2025-11-26 21:33:39', '2025-11-26 21:33:39', NULL, 7),
(198, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (32, 25, 4, 1, \'CB2000 - TX3\', \'2025-11-26 21:34:08\', \'2025-11-26 21:34:08\')', '2025-11-26 21:34:08', '2025-11-26 21:34:08', NULL, 7),
(205, 'update `sensors` set `description` = \'CB1000 - TX2\', `sensors`.`updated_at` = \'2025-11-26 21:34:19\' where `id` = 17', '2025-11-26 21:34:19', '2025-11-26 21:34:19', NULL, 7),
(206, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 1),
(207, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 2),
(208, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 3),
(209, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 4),
(210, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 5),
(211, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 6),
(212, 'insert into `sensors` (`slave_address`, `location_id`, `gateway_id`, `sensor_model_id`, `description`, `updated_at`, `created_at`) values (33, 8, 7, 1, \'MDP-2\', \'2025-11-26 22:09:52\', \'2025-11-26 22:09:52\')', '2025-11-26 22:09:52', '2025-11-26 22:09:52', NULL, 7),
(213, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 1),
(214, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 2),
(215, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 3),
(216, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 4),
(217, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 5),
(218, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 6),
(219, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:49\' where `id` = 16', '2025-11-26 22:10:49', '2025-11-26 22:10:49', NULL, 7),
(220, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 1),
(221, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 2),
(222, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 3),
(223, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 4),
(224, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 5),
(225, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 6),
(226, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:10:57\' where `id` = 17', '2025-11-26 22:10:57', '2025-11-26 22:10:57', NULL, 7),
(227, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 1),
(228, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 2),
(229, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 3),
(230, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 4),
(231, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 5),
(232, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 6),
(233, 'update `sensors` set `sensor_model_id` = 2, `sensors`.`updated_at` = \'2025-11-26 22:11:05\' where `id` = 18', '2025-11-26 22:11:05', '2025-11-26 22:11:05', NULL, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_types`
--
DROP TABLE IF EXISTS `sensor_types`;

CREATE TABLE `sensor_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `sensor_type_code` varchar(255) NOT NULL,
  `sensor_type_parameter` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sensor_types`
--

INSERT INTO `sensor_types` (`id`, `description`, `sensor_type_code`, `sensor_type_parameter`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Single Phase Meter', 'SPM', 'voltage_ab,current_a,real_power,apparent_power,energy', '2025-02-14 01:04:41', '2025-02-14 01:06:28', NULL),
(2, 'Three Phase Meter', 'TPM', 'voltage_ab,voltage_bc,voltage_ca,current_a,current_b,current_c,real_power,apparent_power,energy', '2025-02-14 01:05:34', '2025-02-14 01:06:21', NULL),
(3, 'Temperature & Humidity Sensor', 'THS', 'temperature,humidity', '2025-02-14 01:06:13', '2025-02-14 01:06:13', NULL),
(4, 'Flow Meter', 'FVM', 'volume,flow', '2025-02-14 01:07:05', '2025-02-14 01:07:05', NULL),
(5, 'Pressure Meter Guage', 'PMG', 'pressure', '2025-02-14 01:07:28', '2025-02-14 01:07:28', NULL),
(6, 'Air Quality Meter', 'AQM', 'co2,pm25_pm10,o2,nox,co,s02', '2025-02-14 01:08:48', '2025-02-14 01:08:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0061G0QS2t2vB9sM8fZcEBNcYwtcvfC3j1r4wgnN', 9, '61.245.23.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmoxNGI5amFIcVdJYXpZVzJFV3dickVUa0c1VEFvZ0IyRVBaVnNadyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cHM6Ly9zaWl4LnNtYXJ0cG93ZXJwaC5jb20vbG9jYXRpb25EYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764151063),
('3RSLcEIsD2BRAxfhKPeQXUYh6ytGYipJdj6LRVY2', 1, '180.190.111.22', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUEU2dUc4Sk1sTXhadllYaXFyTW1vS2k5RldtdUdTOU1FOU9Jb3VFUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tL3NlbnNvcnMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1764156888),
('5eGqzeJowhQ9I9ecnlXw7lHd1Uy3mP9EDwAf9hI8', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUw4QlFyS0hYOGdPdjUyS2NrZExVSXYyUnNlVlV3dFVpdE1kaXFveSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764126706),
('5qHI6E20hricPFFUiNlBSQyPiOzoDsqjy8XiDNWM', 1, '180.190.111.22', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVGtZZUtFcEJaRzlucjdEM0ppWlM4dTVNTXNEZ3ppVU4yMFF4SUN1TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tL3NlbnNvcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1764166266),
('8I9xdEea4vrgLtdTuozU5UihigmGWrA9Shkv6olj', NULL, '103.196.9.133', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVlqd1FGN2dhU0Z5ZEhWYUNnUnkzZ3ZHdUpITzJ0S1RQZzN5YW4xUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764147334),
('97jKLt525psGOuYDMRrlox5x10cfsscOmE1J9OvM', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3VYMG9kTHJ5OE45bW00dWVqQ0lQakxoNkpPTlkzUzBWSFBEazdFdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764083037),
('bPJXpawS0lQGVfnuwzjrDdb6h46TrHIEgywMpTwg', 2, '210.1.64.194', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzhjQ0wwRWpESDRtdGtZYTI1eE5TN0haSGhMcUswWTI2bklRS1luNiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cHM6Ly9zaWl4LnNtYXJ0cG93ZXJwaC5jb20vZW5lcmd5Q29uc3VtcHRpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1764147782),
('f02dMcG4Dfm7vvlpqTS1lkImAlBu0rsyqMZAALnS', 2, '210.1.64.194', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXFKMVA0MXVVNmYzMEhKbTJiVEgwcUJRN2Y2VmVPcjBtNXA5eTlDZCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozOToiaHR0cHM6Ly9zaWl4LnNtYXJ0cG93ZXJwaC5jb20vZGFzaGJvYXJkIjt9fQ==', 1764166372),
('fn6QeB1CZbWIsDpWdQxXdgzEi0pLQOTqSse5SF7y', NULL, '136.158.39.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0JHTGdTNG0wQUZiYzdoYU10cXA3M0F3bzdQUzN1cTBvYWZVVndLMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764166326),
('fpR6L1O8Kzm4EGlZ0w5Kx3PGGSC8yC3WbCo123IU', NULL, '136.158.10.12', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1hJZEVHazlEWERERHZadTNaUHJ6Z3FRUmdUV3AwYjlydE9xNGl6SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764154378),
('GRQwzaLIp1vqvnAU1WbvMO2tYmk8nXOqnou63ksI', NULL, '54.83.134.213', 'okhttp/5.3.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmc4WFVtQVR2bUZpdDJ1akMwMDIyUXU0d1RueXZBU2NCWTNnemlMciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764107258),
('IEXfLpj9sFCbeuhMgjfXe6Ex1cV8K5nCjlidVeIX', NULL, '54.83.134.213', 'okhttp/5.3.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibElYOHdrU2ZoYjlqbFRHUDRDVzlzRDJaUmhiaXBxUml0bE5LWHpsTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764107257),
('ILS19LEQtHommcKc9DYk8frpSrVU4JquVCJaWSzk', NULL, '98.82.125.80', 'okhttp/5.3.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjVtRUgxQVBuaFhoVjhEVGFtRTJGaGJCSUFia043NUlWNzB2dkJBZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764108483),
('IMI7AeXZ8h61jw2K6fZMLIByW5v2NPcTY8bOKzkC', 1, '112.209.79.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiajRrMmE5S0JJeEpOVWo4VkpjVFlXYkNodnpocHk4MlhNaHZCaGF0VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764100382),
('LLzKi8GajV05RIKWui6Ooz1YJTWxkiurkMopWXlh', NULL, '137.184.117.51', 'Mozilla/5.0 (X11; Linux x86_64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1BRd2VIMWNiSVNWVzMyR05MNTFFWGdKZ2VNdnB2TmRRcUcwYU5KaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764095699),
('Ob4LY5hunZGRu5iKHFWKS3SzHl1hTCgfzM2ivjGI', NULL, '44.201.255.101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/138.0.7204.23 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUFxM0VKNTRidUMwZm1YVGVWdTJkWTJLbEpTSmtDbDkzckcxNThuTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764107305),
('Q9FmaYW9sHAJJiHvzNuoHgNSpiWEev1IkRCa82jm', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUNwUlR6MEk4WDdwV2xjN1BVYkNlYzlEVFhwQWFCemsxV1habU5oNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764126706),
('TAbnJklv5YK8FqU12kQQSrW7ruhRve1KwdyuRyil', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVpqdlZuQXgxYUxtM1lHQWpoZ3R6c1hGYjh5aEZPbDgwQmtneTNHZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc2lpeC5zbWFydHBvd2VycGguY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764083037),
('tFT1s75N0F7Bc4RUltnkcHcUcxiiTPdOAMIHZZnJ', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHhZb2ZpdWFFdjczMWNRNHdqWFN0Y2ZTSng5Z05pUFQwSzNuYWxZVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764082113),
('TtCDAiBMI2Zz6AHmm3jg8GVW94IivzjzySiYwjBp', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmlla2czR0tOa0VnRzk4bFBGbEdCMXNaQThZRHJESTVOZVR6VEx2cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764082113),
('uB2BFkq4TEQl4vf7L6ckOJN2xGuIEBZpsxXlvLwJ', NULL, '104.252.191.237', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkgyQjVqY01SaDE1NUhHOXJXVlRiRUU0N2xFSVhhRjhjUDhqMEd0aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764147338),
('ucR6qYlYV0h5n5lnYEbHHkJK3f41i9HGkHvCjDWO', NULL, '104.252.191.237', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkY0TG5nR2VrZ0JLNEFpUEl0aVRjNmNVOFNCREZwbU5aeWtaNkRLdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764147334),
('ZukKv7ryLYN1z6Sh2Xip8qRQvzi8gD1eXYeCsuKA', NULL, '98.82.125.80', 'okhttp/5.3.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUg5Qmc4MDFNRWRiTGpUZEowenZaVHFCN2ZmeFNpeHY0ekUzSEg3cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764108484),
('zvZNDZu8dmWsWwmOIee5VZhTQ52XlE2VMkbjBnJc', NULL, '35.85.56.167', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkVyZkl5Rnp2QThLb3RrVU96dkwzdUJRaUFROEdWOEQ0ZEJFU1AxSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vZGV2LXNpaXguc3BwaHBvcnRhbC5zaXRlL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764130612);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `user_type_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'Admin', 1, 'test@example.com', NULL, '$2y$12$F47rUVsa3edWbBRkM3RvxODjDKRgT.TMJiJjCoxoJ3.SA10ize7G.', NULL, '2025-03-18 05:48:11', '2025-04-01 00:56:38', NULL),
(2, 'User', 'SIIX', 2, 'user@smartpowerph.com', NULL, '$2y$12$RiwlX4W.3tXp56cOQQkiVeTV86UW7.97NRcw8aWY3DhsZN0WhsUfG', 'PmfNqObMG1Au9QQRLr3htMwr78F2nNjG5W9e8qccgpCEbOSA5Vri1hAbWEBC', '2025-03-22 11:28:13', '2025-04-01 10:35:03', NULL),
(3, 'Nicole', 'Carillo', 2, 'healer.moebus@gmail.com', NULL, '$2y$12$IKjPHLHNLlIh8PHwV2lwnOrMjmf0rJgInjW/WwzQZgOkcbHWw/1Xa', NULL, '2025-03-30 19:15:17', '2025-03-30 19:15:17', NULL),
(4, '', '', 0, '', NULL, '', NULL, '2025-03-30 19:46:52', '2025-03-30 19:46:52', '2025-03-30 19:46:52'),
(6, 'Gilbert', 'Ollet', 2, 'Gilbert.Ollet@siix-global.com', NULL, '$2y$12$IzaQzXs4OFIladNbQDcoOe8mzbYfvCkdGa7J7XNhfXHH5qN0B4wtC', NULL, '2025-04-09 11:02:27', '2025-04-09 11:02:27', NULL),
(7, 'Sammantha', 'Penalosa', 2, 'Sammantha.Penalosa@siix-global.com', NULL, '$2y$12$fTgdNf.owDPn7eyUS3rw.ejcV9qJqDx.QmDg398ucmrAEYns1nePu', NULL, '2025-04-09 11:05:27', '2025-06-20 17:02:08', NULL),
(8, 'Marvin Ryan', 'Bathan', 2, 'mrgbathan@smartpowerph.com', NULL, '$2y$12$sZoqTGmQNH8Ey64hDkutGOtEA131IKSJRtTTOkQBaSx8zYC4MQE0m', NULL, '2025-04-09 11:10:23', '2025-04-09 11:19:47', NULL),
(9, 'Jessica', 'Beltran', 2, 'Jessica.Beltran@siix-global.com', NULL, '$2y$12$5rhHCwAIUvUCyaPNvMcfdeJPNnBz2jOOxtmA3LiYk9FPEiYlFCGoG', '9FvCmNwNXXAFuL9NWGVD8rZdbVumR1kpX2qxjc8NMZFa1X3LozmI7Gf8x8z6', '2025-04-09 11:24:31', '2025-04-09 11:24:31', NULL),
(10, 'Roland', 'Abad', 2, 'Roland.Abad@siix-global.com', NULL, '$2y$12$5Rl4GIgBTG4C.pcw/qRp5eJX1itGu/Tn656BdsDjn9nTvYakag9Ae', NULL, '2025-04-09 11:27:52', '2025-04-09 11:27:52', NULL),
(11, 'Ems', 'Facility', 2, 'Ems.Facility@siix-global.com', NULL, '$2y$12$JkZpyxKFXy3Zve7ZoU6tz.ftLMtIUMQK068H1U4SV1BGGhBeiNvqu', NULL, '2025-04-09 11:28:59', '2025-04-09 11:28:59', NULL),
(12, 'Kasuyo', 'Matsuo', 2, 'Kasuyo.Matsuo@siix-global.com', NULL, '$2y$12$H5gdQlrak2HKg766npecGe1RdVpkto0OqtjPm7lBgbfetmy89Qje.', NULL, '2025-04-09 11:32:05', '2025-04-09 11:32:05', NULL),
(13, 'Marcial', 'Maglaqui', 2, 'Marcial.Maglaqui@siix-global.com', NULL, '$2y$12$UZlTeEa0esH4nQQ4WzfhzebE6U6yL59mHb0D4NgK/6E7bfyphXBae', NULL, '2025-04-09 11:33:57', '2025-04-09 11:33:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--
DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, NULL, '2025-03-18 05:48:11', '2025-03-18 05:48:11', NULL),
(2, 'User', NULL, NULL, NULL, '2025-03-18 05:48:11', '2025-03-18 05:48:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gateways_gateway_code_unique` (`gateway_code`),
  ADD KEY `gateways_location_id_foreign` (`location_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensors_slave_address_unique` (`slave_address`),
  ADD KEY `sensors_location_id_foreign` (`location_id`),
  ADD KEY `sensors_gateway_id_foreign` (`gateway_id`),
  ADD KEY `sensors_sensor_model_id_foreign` (`sensor_model_id`);

--
-- Indexes for table `sensor_logs`
--
ALTER TABLE `sensor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensor_logs_gateway_id_foreign` (`gateway_id`),
  ADD KEY `sensor_logs_sensor_id_foreign` (`sensor_id`);

--
-- Indexes for table `sensor_models`
--
ALTER TABLE `sensor_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensor_models_sensor_model_unique` (`sensor_model`),
  ADD KEY `sensor_models_sensor_type_id_foreign` (`sensor_type_id`);

--
-- Indexes for table `sensor_offlines`
--
ALTER TABLE `sensor_offlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensor_offlines_gateway_id_foreign` (`gateway_id`);

--
-- Indexes for table `sensor_types`
--
ALTER TABLE `sensor_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sensor_types_sensor_type_code_unique` (`sensor_type_code`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sensor_logs`
--
ALTER TABLE `sensor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022602;

--
-- AUTO_INCREMENT for table `sensor_models`
--
ALTER TABLE `sensor_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sensor_offlines`
--
ALTER TABLE `sensor_offlines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `sensor_types`
--
ALTER TABLE `sensor_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gateways`
--
ALTER TABLE `gateways`
  ADD CONSTRAINT `gateways_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `sensors`
--
ALTER TABLE `sensors`
  ADD CONSTRAINT `sensors_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `gateways` (`id`),
  ADD CONSTRAINT `sensors_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `sensors_sensor_model_id_foreign` FOREIGN KEY (`sensor_model_id`) REFERENCES `sensor_models` (`id`);

--
-- Constraints for table `sensor_logs`
--
ALTER TABLE `sensor_logs`
  ADD CONSTRAINT `sensor_logs_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `gateways` (`id`),
  ADD CONSTRAINT `sensor_logs_sensor_id_foreign` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`);

--
-- Constraints for table `sensor_models`
--
ALTER TABLE `sensor_models`
  ADD CONSTRAINT `sensor_models_sensor_type_id_foreign` FOREIGN KEY (`sensor_type_id`) REFERENCES `sensor_types` (`id`);

--
-- Constraints for table `sensor_offlines`
--
ALTER TABLE `sensor_offlines`
  ADD CONSTRAINT `sensor_offlines_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `gateways` (`id`);
COMMIT;

