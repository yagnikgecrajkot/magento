<?php

class Yagnik_Yagnik_Adminhtml_YagnikController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('yagnik'))
             ->_title($this->__('yagnik'));
        $this->loadLayout();
        $this->_setActiveMenu('yagnik');
        $this->_addContent($this->getLayout()->createBlock('yagnik/adminhtml_yagnik'));
        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('yagnik/yagnik')->load($id);
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('yagnik_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('yagnik/items');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
            $this->_addContent($this->getLayout()->createBlock(' yagnik/adminhtml_yagnik_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('yagnik/adminhtml_yagnik_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('yagnik')->__('Data does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $yagnikModel = Mage::getModel('yagnik/yagnik');
            $yagnikData = $this->getRequest()->getPost('yagnik');
            $yagnikModel->setData($yagnikData)
                ->setId($this->getRequest()->getParam('id'));

            if ($yagnikModel->entity_id == NULL) {
                $yagnikModel->created_at = date("y-m-d H:i:s");
            } else {
                $yagnikModel->updated_at = date("y-m-d H:i:s");
            }

            $yagnikModel->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('yagnik')->__('Data was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(true);

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $yagnikModel->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
    }

    public function massDeleteAction()
    {
        $yagnikIds = $this->getRequest()->getParam('entity_id');
        if(!is_array($yagnikIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('yagnik/yagnik')->__('Please select data(s).'));
        } else {
            try {
                $model = Mage::getModel('yagnik/yagnik');
                foreach ($yagnikIds as $yagnikId) {
                    $model->load($yagnikId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('yagnik')->__(
                    'Total of %d record(s) were deleted.', count($yagnikIds)
                )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }


}