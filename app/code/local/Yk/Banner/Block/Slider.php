<?php

class Yk_Banner_Block_Slider extends Mage_Core_Block_Template
{
    function __construct()
    {
        parent::__construct();
    }

    public function getSliderData()
    {
        $groupId = Mage::getStoreConfig('banner/banner/bannergroup');

        $collection = Mage::getModel('banner/banner')->getCollection()->addFieldToFilter('group_id',$groupId);
        // $bannerData = array();
        // foreach ($collection as $banner) {
        //     $bannerData[] = array(
        //         'image' => Mage::getBaseUrl('media'). $banner->getImage(),
        //         // 'alt' => $banner->getAltText(),
        //         'link' => $banner->getLink()
        //     );
        // }

        return $collection;
    }

}
