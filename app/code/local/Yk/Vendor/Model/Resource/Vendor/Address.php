<?php

class Yk_Vendor_Model_Resource_Vendor_Address extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('vendor/vendor_address', 'address_id');
    }

    
}