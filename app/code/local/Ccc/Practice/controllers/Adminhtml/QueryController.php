<?php
/**
 * 
 */

class Ccc_Practice_Adminhtml_QueryController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/practice'));
        $this->renderLayout();
    }

    public function oneaAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_one'));
        $this->renderLayout();
    }

    public function oneAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_one'));
        $this->renderLayout();
    }

    public function twoAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_two'));
        $this->renderLayout();
    }

    public function threeAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_three'));
        $this->renderLayout();
    }

    public function fourAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_four'));
        $this->renderLayout();
    }

    public function fiveAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_five'));
        $this->renderLayout();
    }

    public function sixAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_six'));
        $this->renderLayout();
    }

    public function sevenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_seven'));
        $this->renderLayout();
    }

    public function eightAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_eight'));
        $this->renderLayout();
    }

    public function nineAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_nine'));
        $this->renderLayout();
    }

    public function tenAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_ten'));
        $this->renderLayout();
    }

    public function viewoneAction()
    {
        echo "one";
        
    }

    public function viewtwoAction()
    {
        echo "two";
        
    }

    public function viewthreeAction()
    {
        echo "three";
        
    }

    public function viewfourAction()
    {
        echo "four";
        
    }

    public function viewfiveAction()
    {
        echo "five";
        
    }

    public function viewsixAction()
    {
        echo "six";
        
    }

    public function viewsevenAction()
    {
        echo "seven";
        
    }

    public function vieweightAction()
    {
        echo "eight";
        
    }

    public function viewnineAction()
    {
        echo "nine";
        
    }

    public function viewtenAction()
    {
        echo "ten";
        
    }


    
}