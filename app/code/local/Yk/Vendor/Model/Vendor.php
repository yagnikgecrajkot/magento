<?php

class Yk_Vendor_Model_Vendor extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('vendor/vendor');
    }
    

    /**
     * Authenticate the vendor based on provided credentials
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function authenticate($email, $password)
    {
        $vendor = $this->loadByUsername($email);

        if ($vendor->getId()) {
            return true;
        }

        return false;
    }

    /**
     * Load vendor model by email
     *
     * @param string $email
     * @return Vendor_Model_Vendor
     */
    public function loadByUsername($email)
    {
        $vendor = $this->getCollection()
            ->addFieldToFilter('email', $email)
            ->getFirstItem();

        return $vendor;
    }
}