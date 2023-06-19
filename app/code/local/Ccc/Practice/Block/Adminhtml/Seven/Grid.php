<?php
class Ccc_Practice_Block_Adminhtml_Seven_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('PracticeAdminhtmlPracticeGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('category/category')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'renderer' => 'Ccc_Category_Block_Adminhtml_Category_Grid_Renderer_Status'
        ));

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}