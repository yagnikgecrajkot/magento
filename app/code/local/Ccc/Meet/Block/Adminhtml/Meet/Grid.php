<?php 

class Ccc_Meet_Block_Adminhtml_Meet_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct(){
		parent::__construct();
		$this->setId('meetId');
		$this->setDefaultSort('entity_Id');
		$this->setDeafultDir('DESC');
		$this->setSaveParametersInSession(true);
		$this->setVarNameFilter('meet_filter');
	}

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('meet/meet')->getCollection()
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname')
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('phoneNo')
            ->addAttributeToSelect('price_attribute');

        $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
       
        $collection->joinAttribute(
            'id',
            'meet/entity_id',
            'entity_id',
            null,
            'inner',
            $adminStore
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

	protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('meet')->__('id'),
                'width'  => '50px',
                'index'  => 'id',
            ));
        $this->addColumn('firstname',
            array(
                'header' => Mage::helper('meet')->__('First Name'),
                'width'  => '50px',
                'index'  => 'firstname',
            ));

        $this->addColumn('lastname',
            array(
                'header' => Mage::helper('meet')->__('Last Name'),
                'width'  => '50px',
                'index'  => 'lastname',
            ));

        $this->addColumn('email',
            array(
                'header' => Mage::helper('meet')->__('Email'),
                'width'  => '50px',
                'index'  => 'email',
            ));
        
        parent::_prepareColumns();
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id'    => $row->getId())
        );
    }
}