<?php

class Ccc_Practice_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{

    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        
        $this->removeColumn('qty');
        $this->removeColumn('name');
    }

}
