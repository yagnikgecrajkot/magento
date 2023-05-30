<?php


$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('product')};
    CREATE TABLE {$this->getTable('product')} (
      `product_id` int(10) NOT NULL,
      `name` varchar(255) NOT NULL,
      `sku` int(11) NOT NULL,
      `cost` int(11) NOT NULL,
      `price` int(11) NOT NULL,
      `quantity` int(11) NOT NULL,
      `description` varchar(255) NOT NULL,
      `status` tinyint(4) NOT NULL,
      `color` tinyint(4) NOT NULL,
      `material` tinyint(4) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('product')}
        ADD PRIMARY KEY (`product_id`);

    ALTER TABLE {$this->getTable('product')}
        MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT;

");

$installer->endSetup();

?>