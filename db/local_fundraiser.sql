ALTER TABLE `ad` ADD `published` ENUM( '0', '1' ) NOT NULL DEFAULT '0';

ALTER TABLE `transaction` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY ( `id` ) ;

ALTER TABLE `transaction` CHANGE `money` `amount` INT NOT NULL ;

ALTER TABLE `transaction` ADD `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '''Anonymous''',
ADD `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
