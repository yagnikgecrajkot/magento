<?php 

class Yk_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Grid_Renderer_Vendor extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

    public function render(Varien_Object $row)
    {
        if ($row->status == 1) {
            return 'Active';
        }
        else if ($row->status == 2) {
            return 'Inactive';
        }
        else{
            return null;
        }
    }
}

?>