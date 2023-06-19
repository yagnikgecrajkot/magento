<?php
class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'yagnik';
        $this->_controller = 'adminhtml_yagnik';
        $this->_headerText = 'Add Yagnik';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}