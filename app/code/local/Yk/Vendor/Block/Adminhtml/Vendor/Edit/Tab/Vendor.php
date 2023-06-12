<?php

class Yk_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_vendor');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('vendor')->__('Vendor information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('vendor')->__('Name'),
            'required' => true,
            'name' => 'vendor[name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('vendor')->__('Email'),
            'required' => true,
            'name' => 'vendor[email]',
        ));

        $fieldset->addField('password', 'text', array(
            'label' => Mage::helper('vendor')->__('Password'),
            'required' => true,
            'name' => 'vendor[password]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('vendor')->__('Mobile'),
            'required' => true,
            'name' => 'vendor[mobile]',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('vendor')->__('Status'),
            'required' => true,
            'name' => 'vendor[status]',
            'options'=> array(
                '1'=>Mage::helper('vendor')->__('Active'),
                '2'=>Mage::helper('vendor')->__('Inactive'),
            ),
        ));

        $form->setValues($model->getData());
        return parent::_prepareForm();
        }
}