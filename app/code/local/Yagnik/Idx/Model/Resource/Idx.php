<?php

class Yagnik_Idx_Model_Resource_Idx extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('idx/idx', 'index');
    }

    
}