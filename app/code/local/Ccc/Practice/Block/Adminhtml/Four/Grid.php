<?php

class Ccc_Practice_Block_Adminhtml_Four_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
        $this->setDefaultSort('attribute_id');
        $this->setDefaultDir('ASC');
    }

     protected function _prepareCollection()
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $productCollection->addAttributeToSelect(array('sku','image','thumbnail','small_image'));

        $data = [];

        foreach ($productCollection as $product) {
            $productId = $product->getId();
            $sku = $product->getSku();
            $image = $product->getImage();
            $thumbnail = $product->getThumbnail();
            $smallImage = $product->getSmallImage();

            $resultArray[] = array(
                'product_id' => $productId,
                'sku' => $sku,
                'image' => $image,
                'thumbnail' => $thumbnail,
                'small_image' => $smallImage
            );
        }
        $collection = new Varien_Data_Collection();

        foreach ($resultArray as $data) {
            $row = new Varien_Object();
            $row->setData($data);
            $collection->addItem($row);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('product_id', array(
            'header'    => Mage::helper('product')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'product_id'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('product')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku'
        ));

        $this->addColumn('image', array(
            'header'    => Mage::helper('product')->__('Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Two_Renderer_Grid'
        ));


        $this->addColumn('thumbnail', array(
            'header'    => Mage::helper('product')->__('Thumbnail'),
            'align'     => 'left',
            'index'     => 'thumbnail',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Two_Renderer_Grid'
        ));

        $this->addColumn('small_image', array(
            'header'    => Mage::helper('product')->__('Small Image'),
            'align'     => 'left',
            'index'     => 'small_image',
            'renderer'  => 'Ccc_Practice_Block_Adminhtml_Two_Renderer_Grid'
        ));
        return parent::_prepareColumns();
    }
}