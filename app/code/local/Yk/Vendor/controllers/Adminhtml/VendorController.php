<?php

class Yk_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action
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
        try {
            if ($data = $this->getRequest()->getPost()) {

                $model = Mage::getModel('vendor/vendor');
                $vendorId = $this->getRequest()->getParam('vendor_id');
                if ($data['vendor']['password'] == 'auto') {
                    $newName = substr($data['vendor']['name'],0,4);
                    $newstring = substr($data['vendor']['mobile'], 6);
                    $autoPassword = $newName.$newstring;
                    $data['vendor']['password'] = $autoPassword;
                }
                $model->setData($data['vendor'])->setId($vendorId);
                if ($model->vendor_id == NULL) {
                    $model->created_at = now();
                } else {
                    $model->updated_at = now();
                }
                if ($model->save()) {
                    if ($vendorId) {
                        $modelAddress = Mage::getModel('vendor/vendor_address')->load($vendorId,'vendor_id');
                        $modelAddress->updated_at = now();
                    }else{
                        $modelAddress = Mage::getModel('vendor/vendor_address');
                        $modelAddress->created_at = now();
                    }
                    
                    $modelAddress->vendor_id = $model->getId();
                    $modelAddress->setData(array_merge($modelAddress->getData(),$data['address']));
                    $modelAddress->save();
                    
                }
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('vendor_id' => $this->getRequest()->getParam('vendor_id')));
            return;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Vendor was successfully saved');
        $this->_redirect('*/*/');
    }

    public function saveAndContinueEditAction()
    {
        
    }

    public function massStatusAction()
    {
        $vendorsId = $this->getRequest()->getPost('vendor_id');
        if(!is_array($vendorsId)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select vendor(s).'));
        } else {
            try {
                $vendor = Mage::getModel('vendor/vendor');
                foreach ($vendorsId as $vendorId) {
                    $vendor
                        ->load($vendorId)
                        ->setStatus($this->getRequest()->getPost('status'))
                        ->save();
                }
                // print_r($vendor);die;
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were Status Updated.', count($vendorsId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');

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

    public function updateStateOptionsAction()
    {

        $countryId = $this->getRequest()->getParam('country_id');
        Mage::log($countryId,null,'country.log');
        $options = array();

        // print_r($countryId);die;
        // Retrieve the state options for the selected country
        $states = Mage::getModel('directory/region')->getResourceCollection()
            ->addCountryFilter($countryId)
            ->load();
        
        // Build the options array
        foreach ($states as $state) {
            $options[] = array(
                'value' => $state->getId(),
                'label' => $state->getName()
            );
        }
        
        // Return the options as JSON response
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($options));
    }


}