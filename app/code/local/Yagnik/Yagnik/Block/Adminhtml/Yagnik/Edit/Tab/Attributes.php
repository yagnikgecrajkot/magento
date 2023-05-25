<?php 
class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Widget_Form
{	
    protected function _getAdditionalElementTypes()
    {
        $result = array(
            'price'    => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_price'),
            'gallery'  => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_gallery'),
            'image'    => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_image'),
            'boolean'  => Mage::getConfig()->getBlockClassName('adminhtml/catalog_product_helper_form_boolean'),
            'textarea' => Mage::getConfig()->getBlockClassName('adminhtml/catalog_helper_form_wysiwyg')
        );

        $response = new Varien_Object();
        $response->setTypes(array());
        Mage::dispatchEvent('adminhtml_catalog_product_edit_element_types', array('response' => $response));

        foreach ($response->getTypes() as $typeName => $typeClass) {
            $result[$typeName] = $typeClass;
        }

        return $result;
    }

    protected function _prepareForm()
    {
        $yagnik = Mage::registry('current_yagnik');

        $group = $this->getGroup();
        $attributes = $this->getAttributes();

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $form->setDataObject($yagnik);
        $form->setHtmlIdPrefix('group_' . $group->getId());
        $form->setFieldNameSuffix('account');

        $fieldset = $form->addFieldset('fieldset_group_' . $group->getId(), array(
            'legend'    => Mage::helper('yagnik')->__($group->getAttributeGroupName()),
            'class'     => 'fieldset',
        ));

        $this->_setFieldset($attributes, $fieldset);
        $form->addValues($yagnik->getData());
        return parent::_prepareForm();
    }
}