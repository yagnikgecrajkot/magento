<?php
class Yagnik_Brand_Block_Home extends Mage_Core_Block_Template
{
    
    function __construct()
    {
        parent::__construct();   
    }

    public function getCollection()
    {
        $collection = Mage::getModel('brand/brand')->getCollection()->addOrder('sort_order','ASC');

        return $collection->getItems();
    }
}