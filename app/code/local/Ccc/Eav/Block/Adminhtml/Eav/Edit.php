<?php

class Ccc_Eav_Block_Adminhtml_Eav_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'eav_id';
        $this->_blockGroup = 'eav';
        $this->_controller = 'adminhtml_eav';
        $this->_headerText = Mage::helper('eav')->__('Edit Container');
        parent::__construct();
         
        $this->_updateButton('save', 'label', Mage::helper('eav')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('eav')->__('Delete'));
         
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
    }
     
}