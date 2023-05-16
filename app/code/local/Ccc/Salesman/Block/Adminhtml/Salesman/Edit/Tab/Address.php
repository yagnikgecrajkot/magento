<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $modelAddress = Mage::registry('salesman_address');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('address_form',array('legend'=>Mage::helper('salesman')->__('salesman Address Information')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('salesman')->__('Address'),
            'required' => true,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('salesman')->__('City'),
            'required' => true,
            'name' => 'address[city]',
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('salesman')->__('State'),
            'required' => true,
            'name' => 'address[state]',
        ));

        $fieldset->addField('country', 'text', array(
            'label' => Mage::helper('salesman')->__('Country'),
            'required' => true,
            'name' => 'address[country]',
        ));

        $fieldset->addField('zip_code', 'text', array(
            'label' => Mage::helper('salesman')->__('Zip Code'),
            'required' => true,
            'name' => 'address[zip_code]',
        ));

        // if ( Mage::getSingleton('adminhtml/session')->getsalesmanData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getsalesmanData());
        //     Mage::getSingleton('adminhtml/session')->setsalesmanData(null);
        // } elseif ( Mage::registry('current_salesman') ) {
        //     $form->setValues(Mage::registry('current_salesman')->getData());
        // }
        $form->setValues($modelAddress->getData());
        return parent::_prepareForm();
        }
}