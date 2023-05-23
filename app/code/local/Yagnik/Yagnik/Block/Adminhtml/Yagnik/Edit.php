<?php
class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'yagnik';
        $this->_controller = 'adminhtml_yagnik';

        $this->_updateButton('save', 'label', Mage::helper('yagnik')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('yagnik')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
        'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        'onclick' => 'saveAndContinueEdit()',
        'class' => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        return Mage::helper('yagnik')->__('My Form Container');
    }
}