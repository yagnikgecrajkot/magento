<?php

class Yagnik_Eavmgmt_Block_Adminhtml_eavmgmt_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('eavmgmtAdminhtmleavmgmtGrid');
        $this->setDefaultSort('index');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('eavmgmt/eavmgmt_collection');

        $this->setCollection($collection);
        return parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        
        $this->addColumn('attribute_id', array(
            'header'=>Mage::helper('eav')->__('Index'),
            'sortable'=>true,
            'index'=>'attribute_id'
        ));

        $this->addColumn('entity_type_code', array(
            'header'=>Mage::helper('eav')->__('Entity Type Code'),
            'sortable'=>true,
            'index'=>'entity_type_code'
        ));

        parent::_prepareColumns();
     

        $this->addColumnAfter('is_visible', array(
            'header'=>Mage::helper('eavmgmt')->__('Visible'),
            'sortable'=>true,
            'index'=>'is_visible_on_front',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'frontend_label');

        $this->addColumnAfter('is_global', array(
            'header'=>Mage::helper('eavmgmt')->__('Scope'),
            'sortable'=>true,
            'index'=>'is_global',
            'type' => 'options',
            'options' => array(
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE =>Mage::helper('eavmgmt')->__('Store View'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE =>Mage::helper('eavmgmt')->__('Website'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('eavmgmt')->__('Global'),
            ),
            'align' => 'center',
        ), 'is_visible');

        $this->addColumn('is_searchable', array(
            'header'=>Mage::helper('eavmgmt')->__('Searchable'),
            'sortable'=>true,
            'index'=>'is_searchable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_user_defined');

        $this->addColumnAfter('is_filterable', array(
            'header'=>Mage::helper('eavmgmt')->__('Use in Layered Navigation'),
            'sortable'=>true,
            'index'=>'is_filterable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Filterable (with results)'),
                '2' => Mage::helper('eavmgmt')->__('Filterable (no results)'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_searchable');

        $this->addColumnAfter('is_comparable', array(
            'header'=>Mage::helper('eavmgmt')->__('Comparable'),
            'sortable'=>true,
            'index'=>'is_comparable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_filterable');

        $this->addColumnAfter('is_comparable', array(
            'header'=>Mage::helper('eavmgmt')->__('Comparable'),
            'sortable'=>true,
            'index'=>'is_comparable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_filterable');


        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('eavmgmt')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eavmgmt')->__('show options'),
                        'url'       => array('base'=> '*/*/showoption'),
                        'field'     => 'eavmgmt_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('eavmgmt')->__('CSV'));
        return $this;

    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('eavmgmt_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('attribute_id');

        $this->getMassactionBlock()->addItem('import_attribute', array(
             'label'    => Mage::helper('eavmgmt')->__('Export'),
             'url'      => $this->getUrl('*/*/selectedExport'),
             'confirm'  => Mage::helper('eavmgmt')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('import_attribute_options', array(
             'label'    => Mage::helper('eavmgmt')->__('Export Options'),
             'url'      => $this->getUrl('*/*/selectedExportOptions'),
             'confirm'  => Mage::helper('eavmgmt')->__('Are you sure?')
        ));
        return $this;
    }  
   
}