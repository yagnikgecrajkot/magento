<?php

class Yagnik_Brand_Block_Banner extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
    }

    public function getSliderData()
    {
        $groupId = Mage::getStoreConfig('banner/banner/bannergroup');

        $collection = Mage::getModel('banner/banner')->getCollection();//->addFieldToFilter('group_id',$groupId);

        return $collection;
    }

}
