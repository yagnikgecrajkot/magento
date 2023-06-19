<?php 

class Yagnik_Yagnik_Block_Adminhtml_Yagnik_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
        parent::__construct();
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('yagnik')->__('Yagnik Information'));
	}

	public function getYagnik()
    {
        return Mage::registry('current_yagnik');
    }

    protected function _beforeToHtml()
    {
        $yagnik = Mage::registry('current_yagnik');
        $setModel = Mage::getModel('eav/entity_attribute_set');

        if (!($setId = $yagnik->getAttributeSetId())) {
            $setId = $this->getRequest()->getParam('set', null);
        }

        if ($setModel->load($setId)->getAttributeSetId()) {
            
            $yagnikAttributes = Mage::getResourceModel('yagnik/yagnik_attribute_collection');

            if (!$yagnik->getId()) {
                foreach ($yagnikAttributes as $attribute) {
                    $default = $attribute->getDefaultValue();
                    if ($default != '') {
                        $yagnik->setData($attribute->getAttributeCode(), $default);
                    }
                }
            }

            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            $defaultGroupId = 0;
            foreach ($groupCollection as $group) {
                if ($defaultGroupId == 0 or $group->getIsDefault()) {
                    $defaultGroupId = $group->getId();
                }

            }	

            foreach ($groupCollection as $group) {
                $attributes = array();
                foreach ($yagnikAttributes as $attribute) {
                    if ($yagnik->checkInGroup($attribute->getId(),$setId, $group->getId())) {
                        $attributes[] = $attribute;
                    }
                }

                if (!$attributes) {
                    continue;
                }

                $active = $defaultGroupId == $group->getId();
                $block = $this->getLayout()->createBlock('yagnik/adminhtml_yagnik_edit_tab_attributes')
                    ->setGroup($group)
                    ->setAttributes($attributes)
                    ->setAddHiddenFields($active)
                    ->toHtml();

                $this->addTab('group_' . $group->getId(), array(
                    'label'     => Mage::helper('yagnik')->__($group->getAttributeGroupName()),
                    'content'   => $block,
                    'active'    => $active
                ));
            }
        } else {
            $this->addTab('set', array(
                'label'     => Mage::helper('yagnik')->__('Settings'),
                'content'   => $this->_translateHtml($this->getLayout()
                    ->createBlock('yagnik/adminhtml_yagnik_edit_tab_setting')->toHtml()),
                'active'    => true
            ));
        }
      return parent::_beforeToHtml();
    }

    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
}