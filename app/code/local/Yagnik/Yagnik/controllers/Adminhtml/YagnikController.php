<?php 

class Yagnik_Yagnik_Adminhtml_YagnikController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_setActiveMenu('yagnik');
		$this->_title('yagnik Grid');
		$this->_addContent($this->getLayout()->createBlock('yagnik/adminhtml_yagnik'));
		$this->renderLayout();
	}

	protected function _initYagnik()
    {
        $this->_title($this->__('yagnik'))
            ->_title($this->__('Manage yagniks'));

        $yagnikId = (int) $this->getRequest()->getParam('id');
        $yagnik   = Mage::getModel('yagnik/yagnik')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($yagnikId);

        if (!$yagnikId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $yagnik->setAttributeSetId($setId);
            }
        }

        Mage::register('current_yagnik', $yagnik);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $yagnik;
    }

	public function newAction(){
		$this->_forward('edit');
	}

	public function editAction(){ 
		$yagnikId = (int) $this->getRequest()->getParam('id');
        $yagnik   = $this->_initYagnik();
        
        if ($yagnikId && !$yagnik->getId()) {
            $this->_getSession()->addError(Mage::helper('yagnik')->__('This yagnik no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($yagnik->getName());

        $this->loadLayout();

        $this->_setActiveMenu('yagnik/yagnik');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
	}

	public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $yagnikData = $this->getRequest()->getPost('account');            
            $yagnik = Mage::getSingleton('yagnik/yagnik');
            $yagnik->setAttributeSetId($setId);

            if ($yagnikId = $this->getRequest()->getParam('id')) {
                if (!$yagnik->load($yagnikId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $yagnik->addData($yagnikData);

            $yagnik->save();

            Mage::getSingleton('core/session')->addSuccess("yagnik data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $yagnikModel = Mage::getModel('yagnik/yagnik');

            if (!($yagnikId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$yagnikModel->load($yagnikId)) {
                throw new Exception('yagnik does not exist');
            }

            if (!$yagnikModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The yagnik has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}