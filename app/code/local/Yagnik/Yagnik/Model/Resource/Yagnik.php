<?php

class Yagnik_Yagnik_Model_Resource_Yagnik extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('yagnik/yagnik', 'entity_id');
    }

    
}