<?php

class Ccc_Vendor_Block_Adminhtml_Vendor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'vendor_id';
        $this->_blockGroup = 'vendor';
        $this->_controller = 'adminhtml_vendor';
        $this->_headerText = Mage::helper('vendor')->__('Edit Container');
        parent::__construct();
         
        $this->_updateButton('save', 'label', Mage::helper('vendor')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('vendor')->__('Delete'));
         
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
    }
     
}