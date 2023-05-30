<?php

class Yagnik_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {
        $this->_title($this->__('Idx'))
             ->_title($this->__('Manage Idxs'));
        $this->loadLayout();
        $this->_setActiveMenu('idx/manage');
        $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx'));
        $this->renderLayout();
    }


    public function massDeleteAction()
    {
        try {
            $idxId = $this->getRequest()->getParam('idx_id');
            if(!is_array($idxId)) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('idx/idx')->__('Please select tax(es).'));
            } else {
                $model = Mage::getModel('idx/idx');
                foreach ($idxId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('idx/idx')->__('Total of %d record(s) were deleted.', count($idxId))
                );
            }
             
            $this->_redirect('*/*/index');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());            
        }
    }

    public function brandAction()
    {
        try {
            if(Mage::getModel('idx/idx')->updateTableColumn(Mage::getModel('brand/brand'), 'brand')){
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Brand Successfully Save'));
            }
            else{
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Brand Already Exists'));
            }
            
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }

    public function collectionAction()
    {
        try {
            if(Mage::getModel('idx/idx')->updateTableColumn(Mage::getModel('collection/collection'), 'collection')){
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Collection Successfully Save'));
            }
            else{
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('idx')->__('Collection Already Exists'));
            }
            
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }



}