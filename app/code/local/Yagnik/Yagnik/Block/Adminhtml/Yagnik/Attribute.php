<?php

class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'yagnik';
		$this->_controller = 'adminhtml_yagnik_attribute';
		$this->_headerText = Mage::helper('vendor')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('vendor')->__('Add New Attribute');
		parent::__construct();
	}
}