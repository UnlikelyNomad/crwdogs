
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- early_discount
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `early_discount`;

CREATE TABLE `early_discount`
(
    `early_discount_id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_id` INTEGER NOT NULL,
    `end_date` DATE NOT NULL,
    `discount` DECIMAL(6,2) NOT NULL,
    PRIMARY KEY (`early_discount_id`),
    INDEX `discount_event` (`event_id`),
    CONSTRAINT `discount_event`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`event_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- event
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event`
(
    `event_id` INTEGER NOT NULL AUTO_INCREMENT,
    `location_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `include_time` VARCHAR(1) NOT NULL,
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `info` TEXT NOT NULL,
    `reg_start` DATE NOT NULL,
    `reg_end` DATE NOT NULL,
    `reg_cost` DECIMAL(6,2) NOT NULL,
    `paypal_email` VARCHAR(255) NOT NULL,
    `notify_email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`event_id`),
    INDEX `event_location` (`location_id`),
    CONSTRAINT `event_location`
        FOREIGN KEY (`location_id`)
        REFERENCES `location` (`location_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `item_id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_id` INTEGER NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `qty_type` VARCHAR(45) NOT NULL,
    `min_qty` INTEGER NOT NULL,
    `max_qty` INTEGER NOT NULL,
    `event_qty` INTEGER NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `label` VARCHAR(45) NOT NULL,
    `base_cost` DECIMAL(6,2) NOT NULL,
    `multiple_variations` VARCHAR(1) NOT NULL,
    `qty_label` VARCHAR(20) NOT NULL,
    `cost_label` VARCHAR(20) NOT NULL,
    `sort` INTEGER NOT NULL,
    PRIMARY KEY (`item_id`),
    INDEX `item_event` (`event_id`),
    CONSTRAINT `item_event`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`event_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_option
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_option`;

CREATE TABLE `item_option`
(
    `option_id` INTEGER NOT NULL AUTO_INCREMENT,
    `item_id` INTEGER NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `type` VARCHAR(45) NOT NULL,
    `label` VARCHAR(45) NOT NULL,
    `sort` INTEGER NOT NULL,
    PRIMARY KEY (`option_id`),
    INDEX `option_item` (`item_id`),
    CONSTRAINT `option_item`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- location
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location`
(
    `location_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `street` VARCHAR(100) NOT NULL,
    `city` VARCHAR(45) NOT NULL,
    `state` VARCHAR(2) NOT NULL,
    `zip` INTEGER NOT NULL,
    `google_link` VARCHAR(45) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `amenities` TEXT NOT NULL,
    PRIMARY KEY (`location_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- option_value
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `option_value`;

CREATE TABLE `option_value`
(
    `value_id` INTEGER NOT NULL AUTO_INCREMENT,
    `option_id` INTEGER NOT NULL,
    `cost_adj` DECIMAL(6,2) NOT NULL,
    `label` VARCHAR(45) NOT NULL,
    `value` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`value_id`),
    INDEX `value_option` (`option_id`),
    CONSTRAINT `value_option`
        FOREIGN KEY (`option_id`)
        REFERENCES `item_option` (`option_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- payment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment`
(
    `payment_id` INTEGER NOT NULL AUTO_INCREMENT,
    `registration_id` INTEGER NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `txn_id` VARCHAR(45) NOT NULL,
    `txn_type` VARCHAR(45) NOT NULL,
    `recipient` VARCHAR(255) NOT NULL,
    `parent_txn` VARCHAR(45) DEFAULT '' NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `full` TEXT NOT NULL,
    `received` DATETIME NOT NULL,
    PRIMARY KEY (`payment_id`),
    INDEX `payment_registration` (`registration_id`),
    CONSTRAINT `payment_registration`
        FOREIGN KEY (`registration_id`)
        REFERENCES `registration` (`registration_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- purchased_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `purchased_item`;

CREATE TABLE `purchased_item`
(
    `purchase_id` INTEGER NOT NULL AUTO_INCREMENT,
    `registration_id` INTEGER NOT NULL,
    `qty` INTEGER NOT NULL,
    `item_id` INTEGER NOT NULL,
    `unit_cost` DECIMAL(6,2) NOT NULL,
    PRIMARY KEY (`purchase_id`),
    INDEX `purchase_registration` (`registration_id`),
    INDEX `purchase_item` (`item_id`),
    CONSTRAINT `purchase_item`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`),
    CONSTRAINT `purchase_registration`
        FOREIGN KEY (`registration_id`)
        REFERENCES `registration` (`registration_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- question
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `question`;

CREATE TABLE `question`
(
    `question_id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_id` INTEGER NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `label` TEXT NOT NULL,
    `type` VARCHAR(45) NOT NULL,
    `sort` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`question_id`),
    INDEX `question_event` (`event_id`),
    CONSTRAINT `question_event`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`event_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- question_option
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `question_option`;

CREATE TABLE `question_option`
(
    `qopt_id` INTEGER NOT NULL AUTO_INCREMENT,
    `question_id` INTEGER NOT NULL,
    `label` VARCHAR(45) NOT NULL,
    `value` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`qopt_id`),
    INDEX `qopt_question` (`question_id`),
    CONSTRAINT `qopt_question`
        FOREIGN KEY (`question_id`)
        REFERENCES `question` (`question_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- registration
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `registration`;

CREATE TABLE `registration`
(
    `registration_id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`registration_id`),
    INDEX `registration_user` (`user_id`),
    INDEX `registration_event` (`event_id`),
    CONSTRAINT `registration_event`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`event_id`),
    CONSTRAINT `registration_user`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- registration_option
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `registration_option`;

CREATE TABLE `registration_option`
(
    `regopt_id` INTEGER NOT NULL AUTO_INCREMENT,
    `purchase_id` INTEGER NOT NULL,
    `value_id` INTEGER NOT NULL,
    PRIMARY KEY (`regopt_id`),
    INDEX `regopt_purchase` (`purchase_id`),
    INDEX `regopt_value` (`value_id`),
    CONSTRAINT `regopt_purchase`
        FOREIGN KEY (`purchase_id`)
        REFERENCES `purchased_item` (`purchase_id`),
    CONSTRAINT `regopt_value`
        FOREIGN KEY (`value_id`)
        REFERENCES `option_value` (`value_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- response
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `response`;

CREATE TABLE `response`
(
    `response_id` INTEGER NOT NULL AUTO_INCREMENT,
    `question_id` INTEGER NOT NULL,
    `registration_id` INTEGER NOT NULL,
    `value` VARCHAR(255) DEFAULT '' NOT NULL,
    PRIMARY KEY (`response_id`),
    INDEX `response_question` (`question_id`),
    INDEX `response_registration` (`registration_id`),
    CONSTRAINT `response_question`
        FOREIGN KEY (`question_id`)
        REFERENCES `question` (`question_id`),
    CONSTRAINT `response_registration`
        FOREIGN KEY (`registration_id`)
        REFERENCES `registration` (`registration_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(45) NOT NULL,
    `last_name` VARCHAR(45) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `password` VARCHAR(255) DEFAULT '' NOT NULL,
    `location` VARCHAR(255) DEFAULT '' NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
