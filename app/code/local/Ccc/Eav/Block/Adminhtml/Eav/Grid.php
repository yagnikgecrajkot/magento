<?php

class Ccc_Eav_Block_Adminhtml_Eav_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('eavAdminhtmleavGrid');
        $this->setDefaultSort('eav_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('eav/eav')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('eav_id', array(
            'header'    => Mage::helper('eav')->__('eav Id'),
            'align'     => 'left',
            'index'     => 'eav_id',
        ));

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('eav')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name',
        ));


        $this->addColumn('last_name', array(
            'header'    => Mage::helper('eav')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('eav')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

         $this->addColumn('gender', array(
            'header'    => Mage::helper('eav')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender',
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('eav')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

         $this->addColumn('status', array(
            'header'    => Mage::helper('eav')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));

        $this->addColumn('company', array(
            'header'    => Mage::helper('eav')->__('Company'),
            'align'     => 'left',
            'index'     => 'company'
        ));

         $this->addColumn('created_at', array(
            'header'    => Mage::helper('eav')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('eav')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));

       $this->addColumn('action',
            array(
                'header'    => Mage::helper('eav')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('eav')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('eav_id'))
                        ),
                        'field'   => 'eav_id'
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
        $this->setMassactionIdField('eav_id');
        $this->getMassactionBlock()->setFormFieldName('eav_id');
         
        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('eav')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('eav')->__('Are you sure?')
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
        return $this->getUrl('*/*/edit', array('eav_id' => $row->getId()));
    }
   
}