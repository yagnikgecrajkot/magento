<?php

class Ccc_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {
        $this->_title($this->__('Vendor'))
             ->_title($this->__('Manage Vendors'));
        $this->loadLayout();
        $this->_setActiveMenu('vendor/manage');
        $this->_addContent($this->getLayout()->createBlock('vendor/adminhtml_vendor'));
        $this->renderLayout();
    }

   
    public function editAction(){
        $id = $this->getRequest()->getParam('vendor_id');
        $model = Mage::getModel('vendor/vendor')->load($id);
        $modelAddress = Mage::getModel('vendor/vendor_address')->load($id, 'vendor_id');

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('current_vendor', $model);
            Mage::register('vendor_address', $modelAddress);
                 
            $this->loadLayout();
            $this->_setActiveMenu('vendor/items');
             
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Vendor Manager'), Mage::helper('adminhtml')->__('Vendor Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Vendor News'), Mage::helper('adminhtml')->__('Vendor News'));
             
            $this->_addContent($this->getLayout()->createBlock(' vendor/adminhtml_vendor_edit'))
            ->_addLeft($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Vendor does not exist'));
            $this->_redirect('*/*/');
        }

    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            echo'<pre>';
            $model = Mage::getModel('vendor/vendor');
            $vendorId = $this->getRequest()->getParam('vendor_id');
            $model->setData($data['vendor'])->setId($vendorId);
            try {
                if ($model->vendor_id == NULL) {
                    $model->created_at = now();
                } else {
                    $model->updated_at = now();
                }
                if ($model->save()) {
                    if ( $vendorId) {
                        $modelAddress = Mage::getModel('vendor/vendor_address')->load($vendorId,'vendor_id');
                    }else{
                        $modelAddress = Mage::getModel('vendor/vendor_address');
                    }
                    
                    $modelAddress->vendor_id = $model->getId();
                    $modelAddress->setData(array_merge($modelAddress->getData(),$data['address']));
                    $modelAddress->save();
                    
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('vendor')->__('Vendor was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                     
                    
                }
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('vendor_id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('vendor_id' => $this->getRequest()->getParam('vendor_id')));
                return;
            }
        }
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor')->__('Unable to find item to save'));
            $this->_redirect('*/*/');
    }
    

    public function deleteAction() 
    {
        if( $this->getRequest()->getParam('vendor_id') > 0 ) {
            try {
                $model = Mage::getModel('vendor/vendor');
                 
                $model->setId($this->getRequest()->getParam('vendor_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Vendor was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('vendor_id' => $this->getRequest()->getParam('vendor_id')));
            }
        }
        $this->_redirect('*/*/');
    }


    public function massDeleteAction()
    {
        $vendorId = $this->getRequest()->getParam('vendor_id');
        if(!is_array($vendorId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('vendor/vendor')->__('Please select tax(es).'));
        } else {
            try {
                $model = Mage::getModel('vendor/vendor');
                foreach ($vendorId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vendor/vendor')->__('Total of %d record(s) were deleted.', count($vendorId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         
        $this->_redirect('*/*/index');
    }


}