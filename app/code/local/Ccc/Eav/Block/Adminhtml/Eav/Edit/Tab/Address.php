<?php
class Ccc_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $modelAddress = Mage::registry('vendor_address');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('address_form',array('legend'=>Mage::helper('vendor')->__('Vendor Address Information')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('vendor')->__('Address'),
            'required' => true,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => true,
            'name' => 'address[city]',
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('vendor')->__('State'),
            'required' => true,
            'name' => 'address[state]',
        ));

        $fieldset->addField('country', 'text', array(
            'label' => Mage::helper('vendor')->__('Country'),
            'required' => true,
            'name' => 'address[country]',
        ));

        $fieldset->addField('zip_code', 'text', array(
            'label' => Mage::helper('vendor')->__('Zip Code'),
            'required' => true,
            'name' => 'address[zip_code]',
        ));

        // if ( Mage::getSingleton('adminhtml/session')->getvendorData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getvendorData());
        //     Mage::getSingleton('adminhtml/session')->setvendorData(null);
        // } elseif ( Mage::registry('current_vendor') ) {
        //     $form->setValues(Mage::registry('current_vendor')->getData());
        // }
        $form->setValues($modelAddress->getData());
        return parent::_prepareForm();
        }
}