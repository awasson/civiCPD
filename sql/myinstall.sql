CREATE  TABLE IF NOT EXISTS civi_cpd_defaults (
  id INT NULL AUTO_INCREMENT ,
  name VARCHAR(45) NOT NULL ,
  value VARCHAR(255) NOT NULL ,
  PRIMARY KEY (id) )
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS civi_cpd_categories (
  id INT NULL AUTO_INCREMENT ,
  category VARCHAR(45) NOT NULL ,
  description VARCHAR(255) NOT NULL ,
  minimum DECIMAL(6,2) NULL ,
  maximum DECIMAL(6,2) NULL ,
  PRIMARY KEY (id) )
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS civi_cpd_activities (
  id INT NULL AUTO_INCREMENT,
  contact_id INT NOT NULL ,
  category_id INT NOT NULL ,
  credit_date DATETIME NOT NULL ,
  credits DECIMAL(6,2) NOT NULL ,
  activity VARCHAR(45) NOT NULL ,
  notes VARCHAR(255) NULL ,
  PRIMARY KEY (id, contact_id, category_id) )
ENGINE = InnoDB;
