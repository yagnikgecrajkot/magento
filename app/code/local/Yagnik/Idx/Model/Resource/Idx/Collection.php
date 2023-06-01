<?php

class Yagnik_Idx_Model_Resource_Idx_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('idx/idx');
    }

}