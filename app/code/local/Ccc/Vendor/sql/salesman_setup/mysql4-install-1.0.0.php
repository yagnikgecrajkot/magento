<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('salesman')};
    CREATE TABLE {$this->getTable('salesman')} (
      `salesman_id` int(10) NOT NULL,
      `first_name` varchar(100) NOT NULL,
      `last_name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `gender` tinyint(4) NOT NULL,
      `mobile` int(11) NOT NULL,
      `status` tinyint(4) NOT NULL,
      `company` varchar(255) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('salesman')}
        ADD PRIMARY KEY (`salesman_id`);

    ALTER TABLE {$this->getTable('salesman')}
        MODIFY `salesman_id` int(10) NOT NULL AUTO_INCREMENT;

");

$installer->endSetup();

?>