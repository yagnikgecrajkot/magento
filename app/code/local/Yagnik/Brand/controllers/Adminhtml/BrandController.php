<?php

class Yagnik_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    public function testAction()
    {
        $model = Mage::getModel('brand/brand')->getCollection();
        print_r($model);
    }

    function indexAction()
    {
        $this->_title($this->__('Brand'))
             ->_title($this->__('Manage Brands'));
        $this->loadLayout();
        $this->_setActiveMenu('brand/manage');
        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
        $this->renderLayout();
    }

   
    public function editAction(){
        $id = $this->getRequest()->getParam('brand_id');
        $model = Mage::getModel('brand/brand')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('current_brand', $model);
                 
            $this->loadLayout();
            $this->_setActiveMenu('brand/items');
             
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand News'), Mage::helper('adminhtml')->__('Brand News'));
             
            $this->_addContent($this->getLayout()->createBlock(' brand/adminhtml_brand_edit'))
            ->_addLeft($this->getLayout()->createBlock('brand/adminhtml_brand_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Brand does not exist'));
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
            $model = Mage::getModel('brand/brand');
            $brandId = $this->getRequest()->getParam('brand_id');
            $model->setData($data['brand'])->setId($brandId);
            try {
                if ($model->brand_id == NULL) {
                    $model->created_at = now();
                } else {
                    $model->updated_at = now();
                }
                $model->save();

                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                
                $path = Mage::getBaseDir('media') . DS . 'brand' . DS;
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                if ($uploader->save($path, $model->getId().'.'.$extension)) {
                    $model->image = $model->getId().".".$extension;
                    $model->save();
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Image was successfully uploaded'));
                }

                    
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                 
                    
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('brand_id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('brand_id' => $this->getRequest()->getParam('brand_id')));
                return;
            }
        }
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Unable to find item to save'));
            $this->_redirect('*/*/');
    }
    

    public function deleteAction() 
    {
        if( $this->getRequest()->getParam('brand_id') > 0 ) {
            try {
                $model = Mage::getModel('brand/brand');
                 
                $model->setId($this->getRequest()->getParam('brand_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('brand_id' => $this->getRequest()->getParam('brand_id')));
            }
        }
        $this->_redirect('*/*/');
    }


    public function massDeleteAction()
    {
        $brandId = $this->getRequest()->getParam('brand_id');
        if(!is_array($brandId)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand/brand')->__('Please select tax(es).'));
        } else {
            try {
                $model = Mage::getModel('brand/brand');
                foreach ($brandId as $id) {
                    $model->load($id)->delete();
                }
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('brand/brand')->__('Total of %d record(s) were deleted.', count($brandId))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
         
        $this->_redirect('*/*/index');
    }


}