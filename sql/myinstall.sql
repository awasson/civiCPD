CREATE TABLE IF NOT EXISTS `civi_cpd_defaults` (
  `name` varchar(45) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `civi_cpd_membership_type` (
  `membership_id` int(11) NOT NULL,
  UNIQUE KEY `membership_id_UNIQUE` (`membership_id`)
) ENGINE=InnoDB;

CREATE  TABLE IF NOT EXISTS civi_cpd_categories (
  id INT NOT NULL AUTO_INCREMENT ,
  category VARCHAR(45) NOT NULL ,
  description VARCHAR(255) NOT NULL ,
  minimum DECIMAL(6,2) NULL ,
  maximum DECIMAL(6,2) NULL ,
  PRIMARY KEY (id) )
ENGINE = InnoDB;

CREATE TABLE `civi_cpd_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `credit_date` datetime NOT NULL,
  `credits` decimal(6,2) NOT NULL,
  `activity` varchar(45) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`contact_id`,`category_id`)) 
ENGINE=InnoDB
