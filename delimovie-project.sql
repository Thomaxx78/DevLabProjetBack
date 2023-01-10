-- -------------------------------------------------------------
-- TablePlus 5.1.2(472)
--
-- https://tableplus.com/
--
-- Database: backend-project
-- Generation Time: 2023-01-10 09:25:13.3440
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `privacy` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `album_film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `film_id` (`film_id`),
  KEY `album_film_ibfk_1` (`album_id`),
  CONSTRAINT `album_film_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `album_film_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `album_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_album` (`id_album`),
  KEY `id_user` (`id_user`),
  KEY `id_owner` (`id_owner`),
  CONSTRAINT `album_share_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `album` (`id`),
  CONSTRAINT `album_share_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `album_share_ibfk_3` FOREIGN KEY (`id_owner`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `likes_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_album` (`album_id`),
  KEY `id_user` (`user_id`),
  CONSTRAINT `likes_album_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`),
  CONSTRAINT `likes_album_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `age` varchar(2) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

INSERT INTO `album` (`id`, `name`, `privacy`, `user_id`) VALUES
(29, 'Visionnés', 'public', 15),
(30, 'Liste Envies', 'public', 15),
(31, 'La Kiffance', 'public', 15),
(32, 'Visionnés', 'public', 16),
(33, 'Liste Envies', 'public', 16),
(34, 'Drill 243', 'private', 16),
(35, 'La malla est gangx', 'public', 16),
(36, 'Visionnés', 'public', 17),
(37, 'Liste Envies', 'public', 17),
(38, 'Apple Music', 'private', 17),
(39, 'Swipe Up', 'public', 17),
(40, 'Visionnés', 'public', 18),
(41, 'Liste Envies', 'public', 18),
(42, 'Public', 'public', 18),
(44, 'Privé', 'private', 18),
(53, 'Tu connais ', 'private', 15),
(55, 'Visionnés', 'public', 20),
(56, 'Liste Envies', 'public', 20);

INSERT INTO `album_film` (`id`, `album_id`, `film_id`) VALUES
(1, 29, 16),
(2, 31, 17),
(3, 29, 18),
(4, 31, 19),
(6, 35, 20),
(7, 35, 21),
(8, 32, 22),
(9, 32, 23),
(10, 38, 24),
(11, 42, 16),
(12, 44, 16),
(15, 53, 18),
(16, 34, 16);

INSERT INTO `album_share` (`id`, `id_album`, `id_user`, `id_owner`, `is_accepted`) VALUES
(1, 34, 15, 16, 1),
(2, 38, 16, 17, 0),
(3, 53, 17, 15, 0);

INSERT INTO `film` (`id`, `film_id`) VALUES
(16, 76600),
(17, 674324),
(18, 593643),
(19, 112581),
(20, 530915),
(21, 1581),
(22, 899112),
(23, 505642),
(24, 361743),
(25, 661374);

INSERT INTO `user` (`id`, `email`, `password`, `username`, `description`, `age`, `logo`) VALUES
(15, 'naps@marseille.com', '0a83f135524148c063a31be9d104689a', 'Naps', 'Faut qu\'j\'quitte la France, elle a fait la petite frange (ouh)\r\nC\'est la kiffance, c\'est la kiffance\r\nQue je dépense, gros joint devant la Défense\r\nC\'est la kiffance, c\'est la kiffance (ouh, ouh)\r\n\r\nOkay okay', '18', 'naps.jpg'),
(16, 'gazo@tacapte.com', '5a6e46679609c7aeba439e1b740d9669', 'Gazo', 'Les bonbonnes sont remplies de cocaïne (baw, flexin\')\r\nDakatine en guise de protéine (wow, banks)\r\nTu connais, chez nous, que la 0.9 (hein)\r\nSi je sors le fer, c\'est pas pour les meufs (hein)\r\nZéro bluff, je dégaine, pousse-toi, grr, paw\r\nJ\'ai pas l\'temps de ken mais tu peux me lehess\r\nAu pire des cas, j\'me casse pendant que tu nehess (tu nehess)\r\nTe-ma la kichta (hey), te-ma la taille d\'la kichta (hey)\r\nTe-ma la kichta (hey), te-ma la taille d\'la kichta (hey)\r\n\r\nT\'as capté ?', '18', 'gazo.jpg'),
(17, 'ninho@retiens.com', 'd2c2a8dc058df39ecb4f12bf8ffb18d5', 'Ninho', 'Saydiq\r\nHÃ©, hÃ©, hÃ©, hÃ©, hÃ©\r\nSam H\r\nMÃ©chant, mÃ©chant\r\nDans la ville j\'revends le cannabis\r\nMaman ne le sait pas\r\nJ\'recompte mes potes, tout prÃ¨s des haramistes\r\nLe canon d\'vant la glace\r\nLes pneus qui crissent, on est revenus tirer sur ces fils de puta\r\nEt j\'sais qu\'Iblis veut pas m\'voir m\'en tirer\r\nFaut qu\'j\'m\'Ã©loigne de tout Ã§a\r\n\r\nSalut c\'est Ninho, Swipe up pour voir ma nouvelle mixtape', '18', 'ninho.jpeg'),
(20, 'test1@gmail.com', 'c3b2fb7847eb1c6c09c20f44d0594e1c', 'test1', 'test', '18', 'IMG_5325.jpeg');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;