-- -------------------------------------------------------------
-- TablePlus 2.8.2(256)
--
-- https://tableplus.com/
--
-- Database: hitema_m1_m_php1
-- Generation Time: 2019-09-14 16:00:03.3030
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

INSERT INTO `continent` (`id`, `name`, `image`) VALUES ('1', 'Afrique', 'afrique.png'),
('2', 'Europe', 'europe.png'),
('3', 'Asie', 'asie.png'),
('4', 'Amérique du Nord', 'amnord.png'),
('5', 'Amérique du Sud', 'amsud.png'),
('6', 'Océanie', 'oceanie.png');

INSERT INTO `country` (`id`, `continent_id`, `name`, `image`) VALUES ('15', '2', 'France', 'france.png'),
('16', '5', 'Brésil', 'bresil.png'),
('17', '6', 'Australie', 'australie.png'),
('18', '6', 'Nouvelle-Zélande', 'nzelande.png'),
('19', '1', 'Maroc', 'maroc.png'),
('20', '3', 'Dubaï', 'dubai.png'),
('21', '1', 'Sénégal', 'senegal.png'),
('22', '2', 'Portugal', 'portugal.png'),
('23', '4', 'Canada', 'canada.png'),
('24', '4', 'États-Unis', 'usa.png'),
('25', '5', 'Colombie', 'colombie.png'),
('26', '2', 'Italie', 'italie.png'),
('27', '3', 'Russie', 'russia.png'),
('28', '3', 'Japon', 'japon.png'),
('29', '1', 'Algérie', 'algerie.png');


INSERT INTO `city` (`id`, `contry_id`, `name`, `image`) VALUES ('64', '22', 'Lisbonne', 'lisbonne.png'),
('65', '15', 'Paris', 'paris.png'),
('66', '22', 'Faro', 'faro.png'),
('67', '19', 'Casablanca', 'casablanca.png'),
('68', '16', 'Rio de Janeiro', 'rio.png'),
('69', '26', 'Rome', 'rome.png'),
('70', '24', 'New York', 'ny.png'),
('71', '20', 'Dubaï', 'dubaiville.png'),
('72', '28', 'Tokyo', 'tokyo.png'),
('73', '24', 'Los Angeles', 'la.png'),
('74', '15', 'Bordeaux', 'bdx.png'),
('75', '29', 'Alger', 'alger.png'),
('76', '25', 'Bogota', 'bogota.png'),
('77', '17', 'Sydney', 'sydney.png'),
('78', '26', 'Milan', 'milan.png'),
('79', '21', 'Dakar', 'dakar.png'),
('80', '23', 'Vancouver', 'vancouver.png'),
('81', '27', 'Moscou', 'moscou.png'),
('82', '19', 'Marrakech', 'marrakech.png'),
('83', '15', 'Marseille', 'marseille.png'),
('84', '18', 'Wellington', 'wellington.png');

INSERT INTO `activity` (`id`, `city_id`, `duration`, `type`, `description`, `price`) VALUES ('1', '80', NULL, 'Sport', 'Ski à Cypress Mountain', '556'),
('2', '65', NULL, 'Visite', 'Visite de la Tour Eiffel', '25'),
('3', '74', NULL, 'Detente', 'Escape Spa Bordeaux', '79'),
('4', '73', NULL, 'Jeux', 'Holywood Pzrk Casino', '20'),
('5', '82', NULL, 'Visite', 'Camels trip Marrakech', '35'),
('6', '64', NULL, 'Sport', 'Surf Lisboa ', '55');



INSERT INTO `hosting` (`id`, `city_id`, `name`, `address`, `price_per_night`, `type`) VALUES ('1', '66', 'VILA VITA Parc', 'Rua Anneliese Pohl, Alporchinhos · 8400-450 Porches · Portugal', '830', 'All inclusive'),
('2', '71', 'Burj Al Arab Jumeirah', 'Level 5, Building 5\nDubai Design District\nPO Box 73137\nDubai, UAE', '7800', 'All inclusive'),
('3', '65', 'Mandarin Oriental', '251 Rue Saint-Honoré, 75001 Paris', '4500', 'All inclusive'),
('4', '69', 'Al Centro di Roma B&B', 'Piazza di Sant\'Andrea della Valle 3, 00186 Rome Italie', '136', 'Visite'),
('5', '64', 'Hotel Ibis Lisboa Jose Malhoa', 'Avenida Jose Malhoa Lote H, Lisbonne 1070-158 Portugal', '106', 'Visite'),
('6', '68', 'Petit Rio Hotel', 'Rua Artur Bernardes 39, Flamengo Flamengo, Rio de Janeiro', '30', 'Visite'),
('7', '82', 'Royal Mansour', 'Rue Abou Abbas El Sebti، 40000, Maroc', '2500', 'All inclusive'),
('8', '70', 'Baccarat Hotel & Residences', ' 28 W 53rd St, New York, NY 10019, États-Unis', '2000', 'All inclusive'),
('9', '72', 'Sakura Hostel Asakusa', '2-24-2 Asakusa, Asakusa, Taito 111-0032 Préfecture de Tokyo', '45', 'Visite'),
('10', '69', 'Hotel Nizza', 'Via D\'Azeglio, 16, 00184 Roma RM, Italie', '1000', 'All inclusive');

INSERT INTO `month` (`id`, `activity_id`, `name`, `temperature_avg`) VALUES ('1', '1', 'Décembre', '-15');




/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;