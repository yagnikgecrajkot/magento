<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('import_product_idx')};
    CREATE TABLE {$this->getTable('import_product_idx')} (
      `index` int(10) NOT NULL,
      `product_id` int(11) NOT NULL,
      `sku` varchar(255) NOT NULL,
      `name` varchar(255) NOT NULL,
      `price` int(11) NOT NULL,
      `cost` int(11) NOT NULL,
      `quantity` int(11) NOT NULL,
      `brand` varchar(255) NOT NULL,
      `brand_id` int(11) NOT NULL,
      `collection` varchar(255) NOT NULL,
      `collection_id` int(11) NOT NULL,
      `description` varchar(255) NOT NULL,
      `status` tinyint(4) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('import_product_idx')}
        ADD PRIMARY KEY (`index`);

    ALTER TABLE {$this->getTable('import_product_idx')}
        MODIFY `index` int(10) NOT NULL AUTO_INCREMENT;

");

$installer->endSetup();

?>