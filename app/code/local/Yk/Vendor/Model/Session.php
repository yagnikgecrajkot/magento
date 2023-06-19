<?php

class Yk_Vendor_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * dVendor object
     *
     * @var Mage_dVendor_Model_dVendor
     */
    protected $_vendor;

    /**
     * Flag with vendor id validations result
     *
     * @var bool
     */
    protected $_isdVendorIdChecked = null;

    /**
     * Persistent vendor group id
     *
     * @var null|int
     */
    protected $_persistentdVendorGroupId = null;

    /**
     * Retrieve vendor sharing configuration model
     *
     * @return Mage_dVendor_Model_Config_Share
     */
    public function getdVendorConfigShare()
    {
        return Mage::getSingleton('vendor/config_share');
    }

    public function __construct()
    {
        $namespace = 'vendor';
        if ($this->getdVendorConfigShare()->isWebsiteScope()) {
            $namespace .= '_' . (Mage::app()->getStore()->getWebsite()->getCode());
        }

        $this->init($namespace);
        Mage::dispatchEvent('vendor_session_init', array('vendor_session'=>$this));
    }

    /**
     * Set vendor object and setting vendor id in session
     *
     * @param   Mage_dVendor_Model_dVendor $vendor
     * @return  Mage_dVendor_Model_Session
     */
    public function setdVendor($vendor)
    {
        // check if vendor is not confirmed
        if ($vendor->isConfirmationRequired()) {
            if ($vendor->getConfirmation()) {
                return $this->_logout();
            }
        }
        $this->_vendor = $vendor;
        $this->setId($vendor->getId());
        // save vendor as confirmed, if it is not
        return $this;
    }

    /**
     * Retrieve vendor model object
     *
     * @return Mage_dVendor_Model_dVendor
     */
    public function getVendor()
    {
        if ($this->_vendor instanceof Mage_dVendor_Model_dVendor) {
            return $this->_vendor;
        }

        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        if ($this->getId()) {
            $vendor->load($this->getId());
        }

        $this->setdVendor($vendor);
        return $this->_vendor;
    }

    /**
     * Set vendor id
     *
     * @param int|null $id
     * @return Mage_dVendor_Model_Session
     */
    public function setdVendorId($id)
    {
        $this->setData('vendor_id', $id);
        return $this;
    }

    /**
     * Retrieve vendor id from current session
     *
     * @return int|null
     */
    public function getdVendorId()
    {
        if ($this->getData('vendor_id')) {
            return $this->getData('vendor_id');
        }
        return ($this->isLoggedIn()) ? $this->getId() : null;
    }

    /**
     * Set vendor group id
     *
     * @param int|null $id
     * @return Mage_dVendor_Model_Session
     */
    public function setdVendorGroupId($id)
    {
        $this->setData('vendor_group_id', $id);
        return $this;
    }

    /**
     * Get vendor group id
     * If vendor is not logged in system, 'not logged in' group id will be returned
     *
     * @return int
     */
    public function getdVendorGroupId()
    {
        if ($this->getData('vendor_group_id')) {
            return $this->getData('vendor_group_id');
        }
        if ($this->isLoggedIn() && $this->getdVendor()) {
            return $this->getdVendor()->getGroupId();
        }
        return Mage_dVendor_Model_Group::NOT_LOGGED_IN_ID;
    }

    /**
     * Checking vendor login status
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        echo'<pre>';
        print_r($this->checkdVendorId($this->getId()));
        die;
        return (bool)$this->getId() && (bool)$this->checkdVendorId($this->getId());
    }

    /**
     * Check exists vendor (light check)
     *
     * @param int $vendorId
     * @return bool
     */
    public function checkdVendorId($vendorId)
    {
        if ($this->_isdVendorIdChecked === null) {
            $this->_isdVendorIdChecked = Mage::getResourceSingleton('vendor/vendor')->checkdVendorId($vendorId);
        }
        return $this->_isdVendorIdChecked;
    }

    /**
     * dVendor authorization
     *
     * @param   string $email
     * @param   string $password
     * @return  bool
     */
    public function login($email, $password)
    {
        /** @var $vendor Mage_dVendor_Model_dVendor */
        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
            
        if ($vendor->authenticate($email, $password)) {
            $this->setdVendorAsLoggedIn($vendor);
            var_dump($this->setdVendorAsLoggedIn($vendor));
            die;
            return true;
        }
        return false;
    }

    public function setdVendorAsLoggedIn($vendor)
    {
        $this->setdVendor($vendor);
        $this->renewSession();
        Mage::getSingleton('core/session')->renewFormKey();
        Mage::dispatchEvent('vendor_login', array('vendor'=>$vendor));
        return $this;
    }

    /**
     * Authorization vendor by identifier
     *
     * @param   int $vendorId
     * @return  bool
     */
    public function loginById($vendorId)
    {
        $vendor = Mage::getModel('vendor/vendor')->load($vendorId);
        if ($vendor->getId()) {
            $this->setdVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    /**
     * Logout vendor
     *
     * @return Mage_dVendor_Model_Session
     */
    public function logout()
    {
        if ($this->isLoggedIn()) {
            Mage::dispatchEvent('vendor_logout', array('vendor' => $this->getdVendor()) );
            $this->_logout();
        }
        return $this;
    }

    /**
     * Authenticate controller action by login vendor
     *
     * @param   Mage_Core_Controller_Varien_Action $action
     * @param   bool $loginUrl
     * @return  bool
     */
    public function authenticate($action, $loginUrl = null)
    {
        if ($this->isLoggedIn()) {
            return true;
        }

        $this->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
        if (isset($loginUrl)) {
            $action->getResponse()->setRedirect($loginUrl);
        } else {
            $action->setRedirectWithCookieCheck(Mage_dVendor_Helper_Data::ROUTE_ACCOUNT_LOGIN,
                Mage::helper('vendor')->getLoginUrlParams()
            );
        }

        return false;
    }

    /**
     * Set auth url
     *
     * @param string $key
     * @param string $url
     * @return Mage_dVendor_Model_Session
     */
    protected function _setAuthUrl($key, $url)
    {
        $url = Mage::helper('core/url')
            ->removeRequestParam($url, Mage::getSingleton('core/session')->getSessionIdQueryParam());
        // Add correct session ID to URL if needed
        $url = Mage::getModel('core/url')->getRebuiltUrl($url);
        return $this->setData($key, $url);
    }

    /**
     * Logout without dispatching event
     *
     * @return Mage_dVendor_Model_Session
     */
    protected function _logout()
    {
        $this->setId(null);
        $this->setdVendorGroupId(Mage_dVendor_Model_Group::NOT_LOGGED_IN_ID);
        $this->getCookie()->delete($this->getSessionName());
        Mage::getSingleton('core/session')->renewFormKey();
        return $this;
    }

    /**
     * Set Before auth url
     *
     * @param string $url
     * @return Mage_dVendor_Model_Session
     */
    public function setBeforeAuthUrl($url)
    {
        return $this->_setAuthUrl('before_auth_url', $url);
    }

    /**
     * Set After auth url
     *
     * @param string $url
     * @return Mage_dVendor_Model_Session
     */
    public function setAfterAuthUrl($url)
    {
        return $this->_setAuthUrl('after_auth_url', $url);
    }

    /**
     * Reset core session hosts after reseting session ID
     *
     * @return Mage_dVendor_Model_Session
     */
    public function renewSession()
    {
        parent::renewSession();
        Mage::getSingleton('core/session')->unsSessionHosts();

        return $this;
    }
}
