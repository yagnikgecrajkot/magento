<?php

class Yagnik_Brand_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('brand/brand', 'brand_id');
    }

    
}