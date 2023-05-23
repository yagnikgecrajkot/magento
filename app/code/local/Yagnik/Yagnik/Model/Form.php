<?php
class Yagnik_Yagnik_Model_Form extends Mage_Eav_Model_Form
{
    protected $_moduleName = 'yagnik';
    protected $_entityTypeCode = 'yagnik';

    protected function _getFormAttributeCollection()
    {
        return parent::_getFormAttributeCollection()
            ->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
    }
}