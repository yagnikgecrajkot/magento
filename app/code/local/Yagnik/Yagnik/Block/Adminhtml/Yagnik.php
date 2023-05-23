<?php

class Yagnik_Yagnik_Block_Adminhtml_Yagnik extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'yagnik';
        $this->_controller = 'adminhtml_yagnik';
        $this->_headerText = Mage::helper('yagnik')->__('Manage yagniks');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('yagnik')->__('Add New yagnik'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('yagnik/adminhtml_yagnik/' . $action);
    }

}