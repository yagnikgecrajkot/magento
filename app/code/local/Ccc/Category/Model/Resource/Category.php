<?php

class Ccc_Category_Model_Resource_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('category/category', 'category_id');
    }

    
}