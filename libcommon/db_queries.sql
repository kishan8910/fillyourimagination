/***********jan 24,2018*****************/



CREATE TABLE `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `mobile` VARCHAR(45) NULL,
  `email` VARCHAR(100) NULL,
  `address` VARCHAR(400) NULL,
  `pincode` VARCHAR(45) NULL,
  `location` VARCHAR(45) NULL,
  `userType` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));




CREATE TABLE `user_files` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL,
  `filepath` VARCHAR(150) NULL,
  `file_title` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));



CREATE TABLE `model_status` (
  `id` INT(11) NOT NULL,
  `status` VARCHAR(45) NULL,
  `priority` INT(11) NULL,
  `isFinalStage` INT(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));



CREATE TABLE `user_file_status` (
  `id` INT(11) NOT NULL,
  `user_files_id` INT(11) NULL,
  `model_status_id` INT(11) NULL,
  PRIMARY KEY (`id`));



CREATE TABLE `model_payment` (
  `id` INT(11) NOT NULL,
  `userFilesId` VARCHAR(45) NULL,
  `txnId` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));



/***************jan 25 , 2018 *********************/

ALTER TABLE `user_files` 
ADD COLUMN `infill` INT(11) NULL AFTER `file_title`,
ADD COLUMN `layerHeight` INT(11) NULL AFTER `infill`;


ALTER TABLE `user` 
ADD COLUMN `location` VARCHAR(45) NULL AFTER `userType`;


ALTER TABLE `user_files` 
ADD COLUMN `material` VARCHAR(45) NULL AFTER `layerHeight`;


ALTER TABLE `user_files` 
CHANGE COLUMN `layerHeight` `layerHeight` FLOAT NULL DEFAULT NULL ;


/***************jan 25,2018***********************/
ALTER TABLE `user_files` 
ADD COLUMN `filamentUsed` VARCHAR(45) NULL AFTER `material`,
ADD COLUMN `totalTime` VARCHAR(45) NULL AFTER `filamentUsed`;


ALTER TABLE `user` 
ADD COLUMN `password` VARCHAR(100) NULL AFTER `location`;


ALTER TABLE `user` 
ADD UNIQUE INDEX `email_UNIQUE` (`email` ASC);



/**********************jan 26, 2018 ************************/


CREATE TABLE `reviewed_estimation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_files_id` INT(11) NULL,
  `reviewed_time` INT(11) NULL,
  `reviewed_price` INT(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


/*****************jan 28, 2018 *******************************/

ALTER TABLE `user_files` 
ADD COLUMN `estimated_price` VARCHAR(45) NULL AFTER `totalTime`;



/******************jan 30, 2018****************************/
CREATE TABLE `user_model_online_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_files_id` int(11) NOT NULL,
  `txnID` varchar(500) NOT NULL,
  `status` varchar(250) DEFAULT NULL,
  `amount` float(7,2) NOT NULL,
  `transactionDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB;

/*****************jan 30,2018*****************************/
ALTER TABLE `user_model_online_payment` 
CHANGE COLUMN `user_files_id` `user_files_id` VARCHAR(25) NOT NULL ;


ALTER TABLE `user_model_online_payment` 
ADD COLUMN `user_id` INT(11) NULL AFTER `transactionDate`;


/****************jan 31, 2018 *****************************/

CREATE TABLE `forgot_password` (
  `forgetID` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `random_number` varchar(50) NOT NULL,
  PRIMARY KEY (`forgetID`)
) ENGINE=InnoDB;


CREATE TABLE `filament_color` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `color` VARCHAR(45) NULL,
  `color_code` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


ALTER TABLE `user_files` 
ADD COLUMN `filament_color_id` INT(11) NULL AFTER `estimated_price`;


/****************feb 01,2018 ******************************/

ALTER TABLE `user_files` 
ADD COLUMN `lithophane_models_id` INT(11) NULL AFTER `filament_color_id`,
ADD COLUMN `customized_models_id` INT(11) NULL AFTER `lithophane_models_id`,
ADD COLUMN `customized_models_text` VARCHAR(800) NULL AFTER `customized_models_id`;


CREATE TABLE `lithophane_models` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `filepath` VARCHAR(100) NULL,
  `filetitle` VARCHAR(100) NULL,
  `price` INT(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));



CREATE TABLE `customized_models` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `filepath` VARCHAR(100) NULL,
  `filetitle` VARCHAR(100) NULL,
  `price` INT(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));



/********************feb 02, 2018 ****************************/

ALTER TABLE `lithophane_models` 
ADD COLUMN `filedescription` VARCHAR(300) NULL AFTER `price`;

ALTER TABLE `customized_models` 
ADD COLUMN `filedescription` VARCHAR(300) NULL AFTER `price`;


CREATE TABLE `lithophane_models_addons` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `lithophane_models_id` INT(11) NULL,
  `filepath` VARCHAR(100) NULL,
  `title` VARCHAR(100) NULL,
  `description` VARCHAR(200) NULL,
  `is_image` INT(11) NULL,
  `is_text` INT(11) NULL,
  `text_content` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


ALTER TABLE `lithophane_models` 
ADD COLUMN `is_image` INT(11) NULL AFTER `filedescription`;



ALTER TABLE `lithophane_models_addons` 
CHANGE COLUMN `text_content` `is_frame` VARCHAR(45) NULL DEFAULT NULL ;


ALTER TABLE `lithophane_models_addons` 
DROP COLUMN `is_frame`;


ALTER TABLE `lithophane_models` 
ADD COLUMN `is_frame` INT(11) NULL AFTER `is_image`;



CREATE TABLE `user_lithophane_inputs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_files_id` INT(11) NULL,
  `lithophane_models_addons_id` INT(11) NULL,
  `path_or_text` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));



ALTER TABLE `user_lithophane_inputs` 
ADD COLUMN `filament_color_id` INT(11) NULL AFTER `path_or_text`;













