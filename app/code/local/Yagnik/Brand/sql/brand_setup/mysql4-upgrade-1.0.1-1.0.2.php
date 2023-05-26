<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    
    DROP TABLE IF EXISTS {$this->getTable('salesman_price')};
    CREATE TABLE {$this->getTable('salesman_price')} (
      `price_id` int(10) NOT NULL,
      `salesman_id` int(10) NOT NULL,
      `product_id` int(10) NOT NULL,
      `salesman_price` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE {$this->getTable('salesman_price')}
        ADD PRIMARY KEY (`price_id`);

    ALTER TABLE {$this->getTable('salesman_price')}
        MODIFY `price_id` int(10) NOT NULL AUTO_INCREMENT;

    ALTER TABLE {$this->getTable('salesman_price')} 
        ADD  FOREIGN KEY (`salesman_id`) 
        REFERENCES {$this->getTable('salesman')}(`salesman_id`)
        ON DELETE CASCADE ON UPDATE CASCADE;

    ALTER TABLE {$this->getTable('salesman_price')} 
        ADD  FOREIGN KEY (`product_id`) 
        REFERENCES {$this->getTable('product')}(`product_id`) 
        ON DELETE CASCADE ON UPDATE CASCADE;
");

$installer->endSetup();

?>