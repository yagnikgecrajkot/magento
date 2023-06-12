<?php

class Yagnik_Yagnik_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Yagnik_Yagnik';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('yagnik/attribute');
    }
}