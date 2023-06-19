<?php

class Ccc_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    
    function indexAction()
    {
        $this->_title($this->__('Product'))
             ->_title($this->__('Manage Products'));
        $this->loadLayout();
        $this->_setActiveMenu('product/manage');
        $this->_addContent($this->getLayout()->createBlock('product/adminhtml_product'));
        $this->renderLayout();
    }

   
    public function editAction(){
        $id = $this->getRequest()->getParam('product_id');
        $model = Mage::getModel('product/product')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('current_product', $model);
                 
            $this->loadLayout();
            $this->_setActiveMenu('product/items');
             
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('product Manager'), Mage::helper('adminhtml')->__('product Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('product News'), Mage::helper('adminhtml')->__('product News'));
             
            $this->_addContent($this->getLayout()->createBlock(' product/adminhtml_product_edit'))
            ->_addLeft($this->getLayout()
            ->createBlock('product/adminhtml_product_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('product does not exist'));
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
                $model = Mage::getModel('product/product');
                $productId = $this->getRequest()->getParam('product_id');
                $model->setData($data['product'])->setId($productId);

                if ($model->product_id == NULL) {
                    $model->created_at = now();
                } else {
                    $model->updated_at = now();
                }
                if (!$model->save()) {
                    throw new Exception("Product Unable to Save", 1);
                }else{
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('product was successfully saved'));
                }                
            }
            
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() 
    {
        if( $this->getRequest()->getParam('product_id') > 0 ) {
            try {
                $model = Mage::getModel('product/product');
                 
                $model->setId($this->getRequest()->getParam('product_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Product was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('product_id' => $this->getRequest()->getParam('product_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $productId = $this->getRequest()->getParam('product_id');
        if(!is_array($productId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product/product')->__('Please select tax(es).'));
        } else {
            try {
                $model = Mage::getModel('product/product');
                foreach ($productId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('product/product')->__('Total of %d record(s) were deleted.', count($productId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         
        $this->_redirect('*/*/index');
    }


}