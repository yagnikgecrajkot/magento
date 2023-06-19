<?php

class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('yagnik_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('yagnik')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('yagnik')->__('Properties'),
            'title'     => Mage::helper('yagnik')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('yagnik/adminhtml_yagnik_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('yagnik')->__('Manage Label / Options'),
            'title'     => Mage::helper('yagnik')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('yagnik/adminhtml_yagnik_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}