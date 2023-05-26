<?php

class Ccc_Eav_Block_Adminhtml_Eav extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'eav';
        $this->_controller = 'adminhtml_eav';
        $this->_headerText = Mage::helper('eav')->__('Manage Eav Attribute');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('eav')->__('Add New eav'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('eav/adminhtml_eav/' . $action);
    }

}