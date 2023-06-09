<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('brand')};
    CREATE TABLE {$this->getTable('brand')} (
      `brand_id` int(10) NOT NULL,
      `name` varchar(100) NOT NULL,
      `image` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `sort_order` int(11) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('brand')}
        ADD PRIMARY KEY (`brand_id`);

    ALTER TABLE {$this->getTable('brand')}
        MODIFY `brand_id` int(10) NOT NULL AUTO_INCREMENT;

");

$installer->endSetup();

?>