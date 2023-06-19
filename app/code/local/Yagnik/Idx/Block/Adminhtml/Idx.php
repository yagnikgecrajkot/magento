<?php

class Yagnik_Idx_Block_Adminhtml_Idx extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'idx';
        $this->_controller = 'adminhtml_idx';
        $this->_headerText = Mage::helper('idx')->__('Manage Idxs');

        parent::__construct();

        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $this->_addButton('import', array(
            'label'   => Mage::helper('idx')->__('Import Idx'),
            'onclick' => "setLocation('{$this->getUrl('*/*/edit')}')",
            'class'   => 'import'
        ));

        $this->_addButton('brand', array(
            'label'   => Mage::helper('idx')->__('Brand'),
            'onclick' => "setLocation('{$this->getUrl('*/*/brand')}')",
            'class'   => 'brand'
        ));

        $this->_addButton('collection', array(
            'label'   => Mage::helper('idx')->__('Collection'),
            'onclick' => "setLocation('{$this->getUrl('*/*/collection')}')",
            'class'   => 'collection'
        ));

        $this->_addButton('product', array(
            'label'   => Mage::helper('idx')->__('Product'),
            'onclick' => "setLocation('{$this->getUrl('*/*/product')}')",
            'class'   => 'product'
        ));

        return parent::_prepareLayout();
    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('idx/adminhtml_idx/' . $action);
    }

}