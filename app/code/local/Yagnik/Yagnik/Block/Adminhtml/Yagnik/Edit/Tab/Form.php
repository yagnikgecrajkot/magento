<?php
class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('yagnik_form',array('legend'=>Mage::helper('yagnik')->__('Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('yagnik')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'yagnik[name]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getyagnikData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getyagnikData());
            Mage::getSingleton('adminhtml/session')->setyagnikData(null);
        } elseif ( Mage::registry('yagnik_data') ) {
            $form->setValues(Mage::registry('yagnik_data')->getData());
        }return parent::_prepareForm();
    }
}