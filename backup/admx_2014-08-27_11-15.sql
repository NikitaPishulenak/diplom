#SKD101|admx|102|2014.08.27 11:15:48|14797|28|150|21|1078|10|2|2|3|9|1|94|3|2|1|2|2|4|7|3|9|5|4673|2|4|9|7|86|13|111|1|3|7|2|12|331|204|10|3|1830|123|13|282|84|56|3|150|4|10|7|6|2|3|6|160|45|27|5|2|166|2551|2|2|13|10|35|28|7|114|113|1862|2|2|2|4|7|38|105|1|1

DROP TABLE IF EXISTS `db_abby_monid`;
CREATE TABLE `db_abby_monid` (
  `id_abby_monid` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_id` int(11) NOT NULL,
  `time_form_id` int(11) NOT NULL,
  `monid` varchar(50) NOT NULL,
  PRIMARY KEY (`id_abby_monid`),
  UNIQUE KEY `faculty_id` (`faculty_id`,`time_form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 /*!40101 DEFAULT CHARSET=cp1251 */;

