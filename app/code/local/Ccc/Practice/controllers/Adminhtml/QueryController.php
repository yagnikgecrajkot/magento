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
                'color' => 'ov.value',
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
            )
            ->joinLeft(
                array('ov' => $resource->getTableName('eav_attribute_option_value')),
                'ov.option_id = pi.value',
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
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('m'=>$resource->getTableName('catalog/product_attribute_media_gallery')),
                'm.entity_id = main_table.entity_id',
                array('image' => 'COUNT(m.value)')
            )
            ->group('main_table.entity_id');   

        echo $select;     
        
    }

    public function viewsixAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('customer_entity')),
                array('entity_id','email')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('customer_entity_varchar')),
                'e.entity_id = main_table.entity_id AND e.attribute_id = 5',
                array('firstname' => 'e.value')
            )
            ->joinLeft(
                array('o'=>$resource->getTableName('sales_flat_order')),
                'o.customer_id = main_table.entity_id',
                array('count' => 'COUNT(o.customer_id)')
            )
            ->group('main_table.entity_id');   

        echo $select;     
    }

    public function viewsevenAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('customer_entity')),
                array('entity_id','email')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('customer_entity_varchar')),
                'e.entity_id = main_table.entity_id AND e.attribute_id = 5',
                array('firstname' => 'e.value')
            )
            ->joinLeft(
                array('o' => $resource->getTableName('sales/order')),
                'o.customer_id = e.entity_id',
                array('order_count' => 'COUNT(o.entity_id)')
            )
            ->joinLeft(
                array('s' => Mage::getSingleton('core/resource')->getTableName('sales_order_status')),
                'o.status = s.status',
                array('order_status' => 's.label')
            )
            ->group('o.status');

        echo $select;
    }

    public function vieweightAction()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $select = $readConnection->select()
            ->from(
                array('main_table'=> $resource->getTableName('catalog_product_entity')),
                array('entity_id','sku')
            )
            ->joinLeft(
                array('e'=>$resource->getTableName('sales_flat_order_item')),
                'e.product_id = main_table.entity_id',
                array('sold_quantity' => 'COALESCE(SUM(e.qty_ordered),0)')
            )
            ->group('main_table.entity_id');

        echo $select;
        
    }

    public function viewnineAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        echo $select = $connection->select()
            ->from(array('e' => 'catalog_product_entity'), array('entity_id AS product_id', 'sku'))
            ->join(
                array('a' => 'eav_attribute'),
                'e.entity_type_id = a.entity_type_id',
                array('attribute_id', 'attribute_code')
            )
            ->joinLeft(
                array('avc' => 'catalog_product_entity_varchar'),
                'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avi' => 'catalog_product_entity_int'),
                'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avd' => 'catalog_product_entity_decimal'),
                'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avt' => 'catalog_product_entity_text'),
                'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
                array()
            )
            ->where('avc.value IS NULL AND avi.value IS NULL AND avd.value IS NULL AND avt.value IS NULL')
            ->where('a.is_user_defined = ?', 1);
   
    }

     public function viewtenAction()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $tablePrefix = Mage::getConfig()->getTablePrefix();

        $select = $connection->select()
            ->from(array('e' => 'catalog_product_entity'), array('entity_id AS product_id', 'sku'))
            ->join(
                array('a' => 'eav_attribute'),
                'e.entity_type_id = a.entity_type_id',
                array('attribute_id', 'attribute_code')
            )
            ->joinLeft(
                array('avc' => 'catalog_product_entity_varchar'),
                'e.entity_id = avc.entity_id AND avc.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avi' => 'catalog_product_entity_int'),
                'e.entity_id = avi.entity_id AND avi.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avd' => 'catalog_product_entity_decimal'),
                'e.entity_id = avd.entity_id AND avd.attribute_id = a.attribute_id',
                array()
            )
            ->joinLeft(
                array('avt' => 'catalog_product_entity_text'),
                'e.entity_id = avt.entity_id AND avt.attribute_id = a.attribute_id',
                array()
            )
            ->where('avc.value is NOT NULL OR avi.value is NOT NULL OR avd.value is NOT NULL OR avt.value is NOT NULL')
            ->where('a.is_user_defined = ?', 1); 

    echo $select->columns(new Zend_Db_Expr("CONCAT_WS(' ', avi.value, avd.value) AS combined_value"));

    }


    
}