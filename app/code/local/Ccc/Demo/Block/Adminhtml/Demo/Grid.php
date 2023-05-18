<?php

class Ccc_Demo_Block_Adminhtml_Demo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('demoAdminhtmlDemoGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('demo/demo')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('attribute_id', array(
            'header'    => Mage::helper('demo')->__('attribute Id'),
            'align'     => 'left',
            'index'     => 'attribute_id',
        ));

        $this->addColumn('entity_type_id', array(
            'header'    => Mage::helper('demo')->__('Entity Type Id'),
            'align'     => 'left',
            'index'     => 'entity_type_id',
        ));

        $this->addColumn('attribute_code', array(
            'header'    => Mage::helper('demo')->__('Attribute Code'),
            'align'     => 'left',
            'index'     => 'attribute_code',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('demo')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

         $this->addColumn('gender', array(
            'header'    => Mage::helper('demo')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender',
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('demo')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

         $this->addColumn('status', array(
            'header'    => Mage::helper('demo')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));

        $this->addColumn('company', array(
            'header'    => Mage::helper('demo')->__('Company'),
            'align'     => 'left',
            'index'     => 'company'
        ));

         $this->addColumn('created_at', array(
            'header'    => Mage::helper('demo')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('demo')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));

       $this->addColumn('action',
            array(
                'header'    => Mage::helper('demo')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('demo')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit',
                            'params'=>array('store'=>$this->getRequest()->getParam('demo_id'))
                        ),
                        'field'   => 'demo_id'
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
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('attribute_id');
         
        $this->getMassactionBlock()->addItem('delete', array(
        'label'=> Mage::helper('demo')->__('Delete'),
        'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
        'confirm' => Mage::helper('demo')->__('Are you sure?')
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
        return $this->getUrl('*/*/edit', array('demo_id' => $row->getId()));
    }
   
}