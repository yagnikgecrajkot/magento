<?php

class Yagnik_Brand_Block_Adminhtml_Brand_Edit_Tab_Brand extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_brand');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('brand_form', array('legend'=>Mage::helper('brand')->__('Brand information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('brand')->__('Name'),
            'required' => true,
            'name' => 'brand[name]',
        ));

        $fieldset->addField('image', 'file', array(
            'label' => Mage::helper('brand')->__('Brand Image'),
            'required' => true,
            'name' => 'image',
        ));

        $fieldset->addField('banner', 'file', array(
            'label' => Mage::helper('brand')->__('Banner Image'),
            'required' => true,
            'name' => 'banner',
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('brand')->__('Description'),
            'required' => true,
            'name' => 'brand[description]',
        ));

        
        // if ( Mage::getSingleton('adminhtml/session')->getbrandData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getbrandData());
        //     Mage::getSingleton('adminhtml/session')->setbrandData(null);
        // } elseif ( Mage::registry('current_brand') ) {
        //     $form->setValues(Mage::registry('current_brand')->getData());
        // }
        $form->setValues($model->getData());
        return parent::_prepareForm();
        }
}