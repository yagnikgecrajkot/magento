<?php

class Yagnik_Yagnik_Model_Resource_Yagnik_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('yagnik/yagnik');
    }

}