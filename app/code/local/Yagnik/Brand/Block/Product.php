<?php
class Yagnik_Brand_Block_Product extends Mage_Core_Block_Template
{
    
    function __construct()
    {
        parent::__construct();   
    }

    public function getCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();

        return $collection->getItems();
    }
}