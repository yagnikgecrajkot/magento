<?php
class Ccc_Category_Block_Adminhtml_Category_Edit_Tab_Category extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('current_category');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('category_form',array('legend'=>Mage::helper('category')->__('category information')));

        $fieldset->addField('parent_id', 'text', array(
            'label' => Mage::helper('category')->__('parent_id'),
            'required' => true,
            'name' => 'category[parent_id]',
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('category')->__('Name'),
            'required' => true,
            'name' => 'category[name]',
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('category')->__('Status'),
            'required' => true,
            'name' => 'category[status]',
            'options'=>array(
                '1'=> Mage::helper('category')->__('Active'),
                '2'=> Mage::helper('category')->__('Inactive'),
            ),
        ));

        $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('category')->__('Description'),
            'required' => true,
            'name' => 'category[description]',
        ));

        
        // if ( Mage::getSingleton('adminhtml/session')->getcategoryData() )
        // {
        //     $form->setValues(Mage::getSingleton('adminhtml/session')->getcategoryData());
        //     Mage::getSingleton('adminhtml/session')->setcategoryData(null);
        // } elseif ( Mage::registry('current_category') ) {
        //     $form->setValues(Mage::registry('current_category')->getData());
        // }
        $form->setValues($model->getData());
        return parent::_prepareForm();
        }
}