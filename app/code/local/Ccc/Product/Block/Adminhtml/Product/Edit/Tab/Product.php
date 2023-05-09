<?php
class Ccc_Product_Block_Adminhtml_Product_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_product');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('product_form',array('legend'=>Mage::helper('product')->__('product information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('product')->__('Name'),
            'required' => true,
            'name' => 'product[name]',
        ));

        $fieldset->addField('sku', 'text', array(
            'label' => Mage::helper('product')->__('SKU'),
            'required' => true,
            'name' => 'product[sku]',
        ));

        $fieldset->addField('cost', 'text', array(
            'label' => Mage::helper('product')->__('Cost'),
            'required' => true,
            'name' => 'product[cost]',
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('product')->__('Price'),
            'required' => true,
            'name' => 'product[price]',
        ));

        $fieldset->addField('quantity', 'text', array(
            'label' => Mage::helper('product')->__('Quantity'),
            'required' => true,
            'name' => 'product[quantity]',
        ));

        $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('product')->__('Description'),
            'required' => true,
            'name' => 'product[description]',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('product')->__('Status'),
            'required' => true,
            'name' => 'product[status]',
            'options'=>array(
                '1'=> Mage::helper('product')->__('Active'),
                '2'=> Mage::helper('product')->__('Inactive'),
            ),
        ));

        $fieldset->addField('color', 'select', array(
            'label' => Mage::helper('product')->__('Color'),
            'required' => true,
            'name' => 'product[color]',
            'options'=>array(
                '1'=> Mage::helper('product')->__('Black'),
                '2'=> Mage::helper('product')->__('Blue'),
            ),
        ));

        $fieldset->addField('material', 'select', array(
            'label' => Mage::helper('product')->__('Material'),
            'required' => true,
            'name' => 'product[material]',
            'options'=>array(
                '1'=> Mage::helper('product')->__('Soft'),
                '2'=> Mage::helper('product')->__('Hard'),
            ),
        ));

       
        
        // if ( Mage::getSingleton('adminhtml/session')->getproductData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getproductData());
        //     Mage::getSingleton('adminhtml/session')->setproductData(null);
        // } elseif ( Mage::registry('current_product') ) {
        //     $form->setValues(Mage::registry('current_product')->getData());
        // }
        $form->setValues($model->getData());
        return parent::_prepareForm();
        }
}