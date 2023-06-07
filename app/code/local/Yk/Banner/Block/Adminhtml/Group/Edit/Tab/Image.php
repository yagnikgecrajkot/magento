<?php
class Yk_Banner_Block_Adminhtml_Group_Edit_Tab_Image extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_form', array('legend'=>Mage::helper('banner')->__('Brand information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('banner')->__('Name'),
            'required' => true,
            'name' => 'banner[name]',
        ));

        $fieldset->addField('image', 'file', array(
            'label' => Mage::helper('banner')->__('Image'),
            'required' => true,
            'name' => 'image',
        ));

        
        // if ( Mage::getSingleton('adminhtml/session')->getbannerData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getbannerData());
        //     Mage::getSingleton('adminhtml/session')->setbannerData(null);
        // } elseif ( Mage::registry('current_banner') ) {
        //     $form->setValues(Mage::registry('current_banner')->getData());
        // }
        
        return parent::_prepareForm();
    }
    
}