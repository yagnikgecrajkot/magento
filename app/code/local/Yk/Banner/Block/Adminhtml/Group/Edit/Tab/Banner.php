<?php
class Yk_Banner_Block_Adminhtml_Group_Edit_Tab_Banner extends Mage_Adminhtml_Block_Catalog_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('banner/image.phtml');
    }
    
    public function getBannerCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();
        $collection->addFieldToFilter('group_id', $this->getRequest()->getParam('group_id'));
        $collection->addorder('position','ASC');

        return $collection->getItems();
    }
}