<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS `category`;
    CREATE TABLE `category` (
      `category_id` int(10) NOT NULL,
      `parent_id` int(11) NOT NULL,
      `path` varchar(100) DEFAULT NULL,
      `name` varchar(255) NOT NULL,
      `status` tinyint(4) NOT NULL,
      `description` varchar(255) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE `category`
        ADD PRIMARY KEY (`category_id`);

    ALTER TABLE `category`
        MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT;

");

$installer->endSetup();

?>