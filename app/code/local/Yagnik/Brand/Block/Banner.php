<?php
class Yagnik_Brand_Block_Banner extends Mage_Core_Block_Template
{
    
    function __construct()
    {
        parent::__construct();   
    }

    public function getCollection()
    {
        $collection = Mage::getModel('brand/brand')->getCollection();

        return $collection->getItems();
    }
}