<?php
class Yagnik_Brand_Block_Adminhtml_Banner extends Mage_Core_Block_Template
{
    
    function __construct()
    {
        parent::__construct();   
    }

    public function getCollection()
    {
        $id = $this->getRequest()->getParam('id');
        $collection = Mage::getModel('brand/brand')->getCollection()->addFieldToFilter('brand_id',$id);

        return $collection->getItems();
    }

    public function getProduct()
    {
        if ($this->getRequest()->getParam('cat')) 
        {
            $category = '*';
        }
        $category = $this->getRequest()->getParam('cat');
        $brandAttributeCode = 'brand';
        $brandValue = $this->getRequest()->getParam('id'); 
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter($brandAttributeCode, $brandValue)
            ->getAllIds();

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addIdFilter($productCollection)
            ->addCategoryFilter(Mage::getModel('catalog/category')->load($category))
            ->addAttributeToSelect('*');

        return $products;
    }

    public function getCategory()
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addIsActiveFilter();

        return $categories;
    }
}