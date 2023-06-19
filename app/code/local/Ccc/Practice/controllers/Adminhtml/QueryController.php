<?php

class Ccc_Practice_Adminhtml_QueryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/practice'));
        $this->renderLayout();
    }

    public function oneAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_one'));
        $this->renderLayout();
    }

    public function twoAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_two'));
        $this->renderLayout();
    }

    public function threeAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_three'));
        $this->renderLayout();
    }

    public function fourAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_four'));
        $this->renderLayout();
    }

    public function fiveAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_five'));
        $this->renderLayout();
    }

    public function sixAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_six'));
        $this->renderLayout();
    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function viewoneAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $tableName = $resource->getTableName('catalog/product');
        $select = $readConnection->select()
            ->from(array('p' => $tableName), array(
                'sku' => 'p.sku',
                'name' => 'pv.value',
                'cost' => 'pdc.value',
                'price' => 'pdp.value',
                'color' => 'pi.value',
            ))
            ->joinLeft(
                array('pv' => $resource->getTableName('catalog_product_entity_varchar')),
                'pv.entity_id = p.entity_id AND pv.attribute_id = 73',
                array()
            )
            ->joinLeft(
                array('pdc' => $resource->getTableName('catalog_product_entity_decimal')),
                'pdc.entity_id = p.entity_id AND pdc.attribute_id = 81',
                array()
            )
            ->joinLeft(
                array('pdp' => $resource->getTableName('catalog_product_entity_decimal')),
                'pdp.entity_id = p.entity_id AND pdp.attribute_id = 77',
                array()
            )
            ->joinLeft(
                array('pi' => $resource->getTableName('catalog_product_entity_int')),
                'pi.entity_id = p.entity_id AND pi.attribute_id = 94',
                array()
            );

        echo $select;
    }

    public function viewtwoAction()
    {
        $attributeOptions = [];

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('ao' => $attributeOptionTable),
                array(
                    'attribute_id' => 'ao.attribute_id',
                    'option_id' => 'ao.option_id',
                    'option_name' => 'ov.value',
                )
            )
            ->joinLeft(
                array('ov' => $resource->getTableName('eav_attribute_option_value')),
                'ov.option_id = ao.option_id',
                array()
            )
            ->join(
                array('a' => $attributeTable),
                'a.attribute_id = ao.attribute_id',
                array('attribute_code' => 'a.attribute_code')
            );

        $queryResult = $readConnection->fetchAll($select);
        echo $select;die;

    }

    public function viewthreeAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $attributeOptionTable = $resource->getTableName('eav_attribute_option');
        $attributeTable = $resource->getTableName('eav_attribute');

        $select = $readConnection->select()
            ->from(
                array('main_table' => $attributeTable),
                array(
                    'attribute_id' => 'main_table.attribute_id',
                    'attribute_code' => 'main_table.attribute_code',
                )
            )
            ->joinLeft(
                array('option_count_table' => $attributeOptionTable),
                'option_count_table.attribute_id = main_table.attribute_id',
                array(
                    'option_count' => 'COUNT(option_count_table.option_id)',
                )
            )
            ->group('main_table.attribute_id')
            ->having('COUNT(option_count_table.option_id) > 10', 1);

        echo $select;die;
    }

    public function viewfourAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        echo $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('image'=>$resource->getTableName('catalog_product_entity_varchar')),
                'image.entity_id = main_table.entity_id AND image.attribute_id = 87',
                array('image' => 'image.value')
            )
            ->joinLeft(
                array('thumb'=>$resource->getTableName('catalog_product_entity_varchar')),
                'thumb.entity_id = main_table.entity_id AND thumb.attribute_id = 89',
                array('thumbnail' => 'thumb.value')
            )
            ->joinLeft(
                array('small'=>$resource->getTableName('catalog_product_entity_varchar')),
                'small.entity_id = main_table.entity_id AND small.attribute_id = 88',
                array('small' => 'small.value')
            );
        
    }

    public function viewfiveAction()
    {
        echo "five";
        
    }

    public function viewsixAction()
    {
        echo "six";
        
    }

    public function viewsevenAction()
    {
        echo "seven";
        
    }

    public function vieweightAction()
    {
        echo "eight";
        
    }

    public function viewnineAction()
    {
        echo "nine";
        
    }

    public function viewtenAction()
    {
        echo "ten";
        
    }


    
}