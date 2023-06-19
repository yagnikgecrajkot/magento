<?php 
class Yagnik_Yagnik_Block_Adminhtml_Yagnik extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'yagnik';
		$this->_controller = 'adminhtml_yagnik';
		$this->_headerText = $this->__('Yagnik Grid');
		$this->_addButtonLabel = $this->__('Add Yagnik');
		parent::__construct();
	}
}