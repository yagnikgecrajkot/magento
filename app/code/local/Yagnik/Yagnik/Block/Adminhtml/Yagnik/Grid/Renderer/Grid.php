<?php

class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Grid_Renderer_Grid extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        if ($row->gender == 5) {
            return 'Male';
        }
        else if ($row->gender == 6) {
            return 'Female';
        }
        else{
            return null;
        }
    }

   
}