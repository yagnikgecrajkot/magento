<?php

class Yagnik_Brand_Block_Adminhtml_Brand_Edit_Tab_Brand_Renderer_Brand extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $fileName= $row->image;

        $html = "<img src='http://127.0.0.1/2023/magento/magento-mirror/media/brand/".$fileName."'width='80px' height='80px'>";
        return $html;
    }

}