-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-06-25 07:51:39
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `auto coordinater`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `clothes`
--

CREATE TABLE `clothes` (
  `id` int(11) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `divide` varchar(20) NOT NULL,
  `type` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `clothes`
--

INSERT INTO `clothes` (`id`, `owner`, `divide`, `type`, `picture`) VALUES
(7, 'test', 'tops', 't_short', 'cloth_tshirt.png'),
(9, 'test', 'bottoms', 'chino_thin', 'fashion_chinopan.png'),
(12, 'test', 'tops', 'sweat', 'fashion_sweat_shirt.png'),
(15, 'test', 'tops', 'check', 'fashion_nerusyatsu.png'),
(17, 'test', 'tops', 't_long', 'cloth_longt.png'),
(18, 'test', 'tops', 'poro', 'fashion_poloshirt_set.png'),
(20, 'test', 'tops', 'parker', 'fashion_parka.png'),
(21, 'test', 'tops', 'outer_thin', 'fashion_flight_jacket.png'),
(22, 'test', 'tops', 'outer_thick', 'fashion_mods_coat.png'),
(23, 'test', 'tops', 't_short', 'sentaku_tshirt.png'),
(25, 'test', 'bottoms', 'chino_thin', 'cloth_pants.png'),
(26, 'test', 'tops', 'outer_thick', 'fashion_duffle_coat.png'),
(27, 'test', 'tops', 'outer_thin', 'fashion_down_jacket.png'),
(28, 'test', 'tops', 'jijan', 'fashion_jean_jacket.png');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `picture` (`picture`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `clothes`
--
ALTER TABLE `clothes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
