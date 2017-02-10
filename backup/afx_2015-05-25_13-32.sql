#SKD101|afx|2|2015.05.25 13:32:42|0

DROP TABLE IF EXISTS `db_fixation`;
CREATE TABLE `db_fixation` (
  `id_fixation` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `ts` datetime NOT NULL,
  PRIMARY KEY (`id_fixation`)
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
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=utf8 */;

