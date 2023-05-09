<?php

class Ccc_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {
        $this->_title($this->__('Salesman'))
             ->_title($this->__('Manage Salesman'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman'));
        $this->renderLayout();
    }

   
    public function editAction(){
        $id = $this->getRequest()->getParam('salesman_id');
        $model = Mage::getModel('salesman/salesman')->load($id);
        $modelAddress = Mage::getModel('salesman/salesman_address')->load($id, 'salesman_id');

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('current_salesman', $model);
            Mage::register('salesman_address', $modelAddress);
                 
            $this->loadLayout();
            $this->_setActiveMenu('salesman/items');
             
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('salesman Manager'), Mage::helper('adminhtml')->__('salesman Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('salesman News'), Mage::helper('adminhtml')->__('salesman News'));
             
            $this->_addContent($this->getLayout()->createBlock(' salesman/adminhtml_salesman_edit'))
            ->_addLeft($this->getLayout()->createBlock('salesman/adminhtml_salesman_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('salesman does not exist'));
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
            $model = Mage::getModel('salesman/salesman');
            $salesmanId = $this->getRequest()->getParam('salesman_id');
            $model->setData($data['salesman'])->setId($salesmanId);
            try {
                if ($model->salesman_id == NULL) {
                    $model->created_at = now();
                } else {
                    $model->updated_at = now();
                }
                if ($model->save()) {
                    if ( $salesmanId) {
                        $modelAddress = Mage::getModel('salesman/salesman_address')->load($salesmanId,'salesman_id');
                    }else{
                        $modelAddress = Mage::getModel('salesman/salesman_address');
                    }
                    
                    $modelAddress->salesman_id = $model->getId();
                    $modelAddress->setData(array_merge($modelAddress->getData(),$data['address']));
                    $modelAddress->save();
                    
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('salesman was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                     
                    
                }
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('salesman_id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('salesman_id' => $this->getRequest()->getParam('salesman_id')));
                return;
            }
        }
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find item to save'));
            $this->_redirect('*/*/');
    }
    

    public function deleteAction() 
    {
        if( $this->getRequest()->getParam('salesman_id') > 0 ) {
            try {
                $model = Mage::getModel('salesman/salesman');
                 
                $model->setId($this->getRequest()->getParam('salesman_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('salesman was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('salesman_id' => $this->getRequest()->getParam('salesman_id')));
            }
        }
        $this->_redirect('*/*/');
    }


    public function massDeleteAction()
    {
        $salesmanId = $this->getRequest()->getParam('salesman_id');
        if(!is_array($salesmanId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman/salesman')->__('Please select tax(es).'));
        } else {
            try {
                $model = Mage::getModel('salesman/salesman');
                foreach ($salesmanId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('salesman/salesman')->__('Total of %d record(s) were deleted.', count($salesmanId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         
        $this->_redirect('*/*/index');
    }


}