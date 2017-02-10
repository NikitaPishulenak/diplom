#SKD101|mfx|3|2014.04.15 11:07:09|16|3|13

DROP TABLE IF EXISTS `db_fixation`;
CREATE TABLE `db_fixation` (
  `id_fixation` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `ts` datetime NOT NULL,
  PRIMARY KEY (`id_fixation`)
) ENGINE=InnoDB AUTO_INCREMENT=4 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `db_fixation` VALUES
(1, '2014-04-09 09:40:15', '2014-04-09 09:40:15'),
(2, '2014-04-09 11:10:31', '2014-04-09 11:10:31'),
(3, '2014-04-14 15:33:54', '2014-04-14 15:33:54');

DROP TABLE IF EXISTS `db_fixed_history`;
CREATE TABLE `db_fixed_history` (
  `id_fixed_target` int(11) NOT NULL AUTO_INCREMENT,
  `fixation_id` int(11) NOT NULL,
  `faculty` int(11) NOT NULL,
  `time_form_id` int(11) NOT NULL,
  `edu_form` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `target_type` int(11) NOT NULL,
  `target_cell` int(11) NOT NULL,
  `region_cell` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `delo_name` varchar(10) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id_fixed_target`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `db_fixed_target`;
CREATE TABLE `db_fixed_target` (
  `id_fixed_target` int(11) NOT NULL AUTO_INCREMENT,
  `fixation_id` int(11) NOT NULL,
  `faculty` int(11) NOT NULL,
  `time_form_id` int(11) NOT NULL,
  `edu_form` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `target_type` int(11) NOT NULL,
  `target_cell` int(11) NOT NULL,
  `region_cell` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `delo_name` varchar(10) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id_fixed_target`)
) ENGINE=InnoDB AUTO_INCREMENT=22 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `db_fixed_target` VALUES
(1, 1, 1, 1, 1, 3, 1, 0, 0, 210, 1, 'Л-1', 2),
(2, 1, 1, 1, 1, 1, 1, 1, 5, 210, 3, 'Л-2', 2),
(3, 1, 1, 1, 1, 3, 1, 0, 0, 210, 4, 'Л-2', 1),
(4, 1, 7, 1, 1, 3, 0, 0, 0, 144, 5, 'ПДП-1', 1),
(8, 2, 1, 1, 1, 3, 1, 0, 0, 210, 1, 'Л-1', 2),
(9, 2, 1, 1, 1, 1, 1, 1, 5, 210, 3, 'Л-2', 2),
(10, 2, 1, 1, 1, 3, 1, 0, 0, 210, 4, 'Л-2', 1),
(11, 2, 7, 1, 1, 3, 0, 0, 0, 144, 5, 'ПДП-1', 1),
(15, 3, 1, 1, 1, 3, 1, 0, 0, 210, 1, 'Л-1', 2),
(16, 3, 1, 1, 1, 1, 1, 1, 5, 210, 3, 'Л-2', 2),
(17, 3, 1, 1, 1, 3, 1, 0, 0, 210, 4, 'Л-2', 1),
(18, 3, 7, 1, 1, 3, 0, 0, 0, 144, 5, 'ПДП-1', 1),
(19, 3, 2, 1, 1, 3, 1, 0, 0, 210, 6, 'МП-1', 1);

