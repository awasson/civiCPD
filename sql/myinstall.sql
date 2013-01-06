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

CREATE  TABLE IF NOT EXISTS civi_cpd_activities (
  id INT NOT NULL AUTO_INCREMENT,
  contact_id INT NOT NULL ,
  category_id INT NOT NULL ,
  credit_date DATETIME NOT NULL ,
  credits DECIMAL(6,2) NOT NULL ,
  activity VARCHAR(45) NOT NULL ,
  notes VARCHAR(255) NULL ,
  PRIMARY KEY (id, contact_id, category_id) )
ENGINE = InnoDB;
