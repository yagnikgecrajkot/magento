<?php

class Ccc_Salesman_Model_Resource_Salesman_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('salesman/salesman_address', 'address_id');
    }

    
}