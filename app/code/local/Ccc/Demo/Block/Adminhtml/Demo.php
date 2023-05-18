<?php

class Ccc_Demo_Block_Adminhtml_Demo extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'demo';
        $this->_controller = 'adminhtml_demo';
        $this->_headerText = Mage::helper('demo')->__('Manage Demo');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('demo')->__('Add New demo'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('demo/adminhtml_demo/' . $action);
    }

}