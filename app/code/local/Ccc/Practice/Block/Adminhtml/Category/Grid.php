<?php

class Ccc_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryAdminhtmlCategoryGrid');
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

        $this->addColumn('category_id', array(
            'header'    => Mage::helper('category')->__('Category Id'),
            'align'     => 'left',
            'index'     => 'category_id',
        ));

        $this->addColumn('parent_id', array(
            'header'    => Mage::helper('category')->__('Parent_id'),
            'align'     => 'left',
            'index'     => 'parent_id',
        ));

        $this->addColumn('path', array(
            'header'    => Mage::helper('category')->__('Path'),
            'align'     => 'left',
            'index'     => 'path',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'align'     => 'left',
            'index'     => 'status'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('category')->__('Description'),
            'align'     => 'left',
            'index'     => 'description',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('category')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('category')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));

       $this->addColumn('action',
            array(
                'header'    => Mage::helper('category')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('category')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('category_id'))
                        ),
                        'field'   => 'category_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category_id');
         
        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('category')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('category')->__('Are you sure?')
        ));
         
        return $this;
    }


    // protected function _afterLoadCollection()
    // {
    //     $this->getCollection()->walk('afterLoad');
    //     parent::_afterLoadCollection();
    // }

    // protected function _filterStoreCondition($collection, $column)
    // {
    //     if (!$value = $column->getFilter()->getValue()) {
    //         return;
    //     }

    //     $this->getCollection()->addStoreFilter($value);
    // }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}