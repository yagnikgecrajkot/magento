<?php
class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('yagnik')->__('yagnik Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('yagnik')->__('yagnik Information'),
            'title' => Mage::helper('yagnik')->__('yagnik Information'),
            'content' => $this->getLayout()->createBlock('yagnik/adminhtml_yagnik_edit_tab_form')->toHtml()
        ));

        return parent::_beforeToHtml();
    }
}