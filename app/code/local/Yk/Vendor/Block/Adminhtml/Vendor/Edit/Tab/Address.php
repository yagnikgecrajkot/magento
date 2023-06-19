<?php

class Yk_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $modelAddress = Mage::registry('vendor_address');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('address_form',array('legend'=>Mage::helper('vendor')->__('Vendor Address Information')));

        $fieldset->addField('address', 'text', array(
            'label'      => Mage::helper('vendor')->__('Address'),
            'required'   => true,
            'name'       => 'address[address]',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => true,
            'name' => 'address[city]',
        ));

        $fieldset->addField('country', 'select', array(
            'name'      => 'address[country]',
            'label'     => Mage::helper('vendor')->__('Country'),
            'required'  => true,
            'values'    => Mage::getModel('directory/country')->getResourceCollection()
                            ->loadByStore()
                            ->toOptionArray(),
            'onchange'  => 'updateStateOptions(this.value)',
        ));

        $fieldset->addField('state', 'select', array(
            'name'      => 'address[state]',
            'label'     => Mage::helper('vendor')->__('State'),
            'required'  => true,
            'values'    => Mage::getModel('directory/region')->getResourceCollection()
                            ->addCountryFilter($countryId)
                            ->load()
                            ->toOptionArray()
        ));
        
        $script = '
            <script>
            function updateStateOptions(countryId) {
                console.log(countryId);
                var url = "' . $this->getUrl('*/*/updateStateOptions') . '"; // Replace with your controller action URL
                new Ajax.Request(url, {
                    method: "post",
                    parameters: { country_id: countryId },
                    onSuccess: function(transport) {
                        var response = transport.responseText.evalJSON();
                        var stateField = $("state");
                        stateField.update("");
                        response.each(function(option) {
                            stateField.insert(new Element("option", { value: option.value }).update(option.label));
                        });
                    }
                });
            }
            </script>';

            
        $fieldset->addField('ajax_script', 'note', array(
            'text'     => $script,
            'after_element_html' => '',
        ));

        $fieldset->addField('postal_code', 'text', array(
            'label' => Mage::helper('vendor')->__('Postal Code'),
            'required' => true,
            'name' => 'address[postal_code]',
        ));

        $form->setValues($modelAddress->getData());
        return parent::_prepareForm();
        }
}