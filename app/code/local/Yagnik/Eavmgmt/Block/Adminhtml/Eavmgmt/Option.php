<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @eavmgmt    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer grid block
 *
 * @eavmgmt   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Yagnik_Eavmgmt_Block_Adminhtml_eavmgmt_Option extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('eavmgmtAdminhtmleavmgmtGrid');
        $this->setDefaultSort('eavmgmt_id');
        $this->setDefaultDir('ASC');
        // $this->removeColumn();
       // echo "<pre>";
       // print_r(get_class_methods($this));
    }

   protected function _prepareCollection()
    {
       
            $id = $this->getRequest()->getParam('eavmgmt_id');
           $collection = Mage::getModel('eav/entity_attribute_option')->getCollection();
           $collection->getSelect() ->join('eav_attribute', 'main_table.attribute_id = eav_attribute.attribute_id', 'attribute_code')
            // ->addFieldToFilter('main_table.attribute_id', array('attribute_id'=>$id));
            ->where('main_table.attribute_id = ?',$id);
        $this->setCollection($collection);
        return parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {
          $this->addColumn('option_id', array(
            'header' => Mage::helper('eavmgmt')->__('Option ID'),
            'index' => 'option_id',
        ));

        $this->addColumn('value', array(
            'header' => Mage::helper('eavmgmt')->__('Option Name'),
            'index' => 'value',
            'renderer' => 'Yagnik_Eavmgmt_Block_Adminhtml_eavmgmt_Option_Renderer_Option'
        ));

        $this->addColumn('attribute_code', array(
            'header' => Mage::helper('eavmgmt')->__('Attribute Name'),
            'index' => 'attribute_code',
        ));

        $this->addColumn('sort_order', array(
            'header' => Mage::helper('eavmgmt')->__('Sort Order'),
            'index' => 'sort_order',
        ));

        return parent::_prepareColumns();
    }
    
}