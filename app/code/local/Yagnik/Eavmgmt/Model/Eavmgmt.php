 <?php

class Yagnik_Eavmgmt_Model_Eavmgmt extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('eav_attribute/eav_attribute');
    }
}
