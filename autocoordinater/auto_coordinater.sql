-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-06-30 07:48:37
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
  `type` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `used_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `clothes`
--

INSERT INTO `clothes` (`id`, `owner`, `type`, `picture`, `used_date`) VALUES
(57, 'test', 't_long', '20200630063936141112280.png', '0000-00-00'),
(58, 'test', 'chino_thin', '202006300640151816169503.png', '0000-00-00'),
(59, 'test', 't_short', '202006300640252011936352.png', '0000-00-00'),
(60, 'test', 'chino_thin', '202006300644451980593057.png', '0000-00-00'),
(61, 'test', 'outer_thin', '202006300644551809210918.png', '0000-00-00'),
(62, 'test', 'outer_thick', '202006300645021008730753.png', '0000-00-00'),
(63, 'test', 'outer_thin', '202006300645091455084889.png', '0000-00-00'),
(64, 'test', 'jijan', '20200630064516445216406.png', '0000-00-00'),
(65, 'test', 'jeans', '20200630064524944217636.png', '0000-00-00'),
(66, 'test', 'outer_thick', '202006300645431231453678.png', '0000-00-00'),
(67, 'test', 'check', '202006300645521406654411.png', '0000-00-00'),
(68, 'test', 'parker', '202006300646061577038175.png', '0000-00-00'),
(69, 'test', 'poro', '202006300646161731669149.png', '0000-00-00'),
(70, 'test', 'trainer', '2020063006462943630393.png', '0000-00-00'),
(71, 'test', 'seta', '202006300646351865803038.png', '0000-00-00'),
(72, 'test', 'inner', '20200630064644160802017.png', '0000-00-00'),
(73, 'test', 't_short', '202006300646511093295181.png', '0000-00-00'),
(77, 'test', 't_short', '202006300742112138219705.png', '0000-00-00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
