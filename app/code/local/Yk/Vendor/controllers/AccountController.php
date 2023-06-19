<?php

class Yk_Vendor_AccountController extends Mage_Core_Controller_Front_Action
{   
    protected function _getSession()
    {
        return Mage::getSingleton('vendor/session');
    }

    public function _getModel($path, $arguments = array())
    {
        return Mage::getModel($path, $arguments);
    }

    protected function _getHelper($path)
    {
        return Mage::helper($path);
    }

    protected function _isVatValidationEnabled($store = null)
    {
        return  $this->_getHelper('vendor/address')->isVatValidationEnabled($store);
    }

    protected function _validateRegistrationData($data)
    {
        $errors = array();

        // Validate name
        if (empty($data['firstname'])) {
            $errors[] = 'Please enter your first name.';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors[] = 'Please enter your email address.';
        } elseif (!Zend_Validate::is($data['email'], 'EmailAddress')) {
            $errors[] = 'Please enter a valid email address.';
        }


        // Validate telephone (mobile number)
        if (empty($data['mobile'])) {
            $errors[] = 'Please enter your mobile number.';
        } else {
            // Custom mobile number validation rule
            $mobileRegex = '/^[0-9]{10}$/'; // Assuming a 10-digit mobile number is required
            if (!preg_match($mobileRegex, $data['mobile'])) {
                $errors[] = 'Please enter a valid 10-digit mobile number.';
            }
        }

        // Validate password
        if (empty($data['password'])) {
            $errors[] = 'Please enter a password.';
        }

        // Validate password confirmation
        if ($data['password'] !== $data['confirmation']) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function createAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function createPostAction()
    {
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost();
            if (!$postData) {
                $this->_redirect('*/*/create');
                return;
            }

            $errors = array();

            // Validate the posted data
            $validationResult = $this->_validateRegistrationData($postData);
            if ($validationResult !== true) {
                $errors = $validationResult;
            } else {
                $vendor = Mage::getModel('vendor/vendor');
                $vendor->load($postData['email'], 'email'); // Check if the email is already registered as a vendor
                if ($vendor->getId()) {
                    $errors[] = 'Email address is already registered as a vendor.';
                } else {
                    // Create the vendor record
                    if ($postData['middlename']) {
                        $name =  $postData['firstname'].' '.$postData['middlename'].' '.$postData['lastname'];
                    }
                    else{
                        $name =  $postData['firstname'].' '.$postData['lastname'];
                    }
                    $vendor->setData('name', $name);
                    $vendor->setData('email', $postData['email']);
                    $vendor->setData('mobile', $postData['mobile']);
                    $vendor->setData('password', $postData['password']);
                    $vendor->setData('created_at', now());
                    $vendor->setData('status', 0);

                    $vendorId = $vendor->save();
                    $vendorId = $vendor->getId();
                    $vendor = Mage::getModel('vendor/vendor')->load($vendorId);

                    $content = $this->_prepareBodyContent($vendorId);
                    $this->_sendmail($vendor ,$content);
                    // Perform additional vendor registration tasks if needed

                    // Redirect to a success page or perform any other desired action
                    Mage::getSingleton('core/session')->addSuccess('Vendor registration successful.And verify the mail '.$postData['email']);
                    $this->_redirect('*/*/create');
                    return;
                }
            }

            // If there are errors, display them and redirect back to the registration form
            Mage::getSingleton('core/session')->setVendorFormData($postData);
            Mage::getSingleton('core/session')->addError(implode('<br>', $errors));
            $this->_redirect('*/*/create');
        } else {
            Mage::getSingleton('core/session')->addError("Error: Request is not allowed.");
            // Redirect the user to another page or display the error message as needed
            $this->_redirect('*/index/create');
        }
    }

    public function _sendmail($model, $content)
    {
       $vendor = $model;
            $email = $vendor->getEmail();
            // print_r($email);die();
            $vars = array(
                'vendor' => $vendor,
                'message' => 'Hello vendor, hope you have a good day!',
            );

            $emailTemplate = Mage::getModel('core/email_template')->loadDefault('vendor_welcome_email_template');

            $processedTemplate = $emailTemplate->getProcessedTemplate($vars);

            $config = array(
                'ssl' => 'tls',
                'port' => 587,
                'auth' => 'login',
                'username' => 'mailto:kansagrayagnik2938@gmail.com', // Replace with your Gmail email address
                'password' => 'pnubjxpihgtsnvlx', // Replace with your Gmail password or app password
            );

            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($content);
            $mail->setfrom('kansagrayagnik2938@gmail.com', 'Yagnik Kansagra'); // Replace with your Gmail email address and name
            $mail->addTo($email, 'Vendor');
            $mail->setSubject('Welcome Vendor');
            $mail->setBodyText('Hello vendor, hope you have a good day!');

            // echo "<pre>";
            // print_r($emailTemplate);
            // die;
            $mail->send($transport);
            return true;
    }




    public function _prepareBodyContent($id)
    {
        $encryptionKey = 'cybercom'; // Replace with your encryption key
        $hashKey = base64_encode(openssl_encrypt($id, 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16)));

        $mailUrl = Mage::getUrl('*/*/urlVerification');
        $finalUrl = $mailUrl .'key/'.$hashKey;

        $content = 'please verify the user via this url '.$finalUrl;
        return $content;
    }


    public function urlVerificationAction()
    {
        try {
            $hashKey = $this->getRequest()->getParam('key');
            if (!$hashKey) {
                Mage::throwException('Invalid URL. Please verify the mail URL.');
            }

            $encryptionKey = 'cybercom'; // Replace with your encryption key
            $vendorId = openssl_decrypt(base64_decode($hashKey), 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16));
            $vendorModel = Mage::getModel('vendor/vendor')->load($vendorId);
            if (!$vendorModel->getId()) {
                Mage::throwException('Invalid records found. Please contact the admin.');
            }

            $vendorModel->setStatus(1);
            $vendorModel->save();

            Mage::getSingleton('core/session')->addSuccess('Vendor verification successful. Please login.');
            $this->_redirect('*/*/login');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/login');
        }
    }


    public function loginAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function loginpostAction()
    {
        // Get the vendor's username and password from the request
        $login = $this->getRequest()->getPost('login');
        $vendorEmail = $login['email'];
        $vendorPassword = $login['password'];
        // Create a customer session
        $session = Mage::getSingleton('vendor/session');
        
        try {
            // Authenticate the vendor
            if ($session->login($vendorEmail, $vendorPassword)) {
                // Vendor login successful
                $this->_redirect('vendor/account/index');
            } else {
                // Vendor login failed
                $this->_redirect('*/*/login');
            }
        } catch (Exception $e) {
            // Handle any exceptions or errors that occur during login
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/login');
        }
    }

    public function loginpost1Action()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirect('*/*/login');
            return;
        }
        print_r($this->_getSession()->isLoggedIn());
        die;

        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/login');
            return;
        }
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['email']) && !empty($login['password'])) {
                try {
                    $session->login($login['email'], $login['password']);
                    if ($session->getVendor()->getIsJustConfirmed()) {
                        $this->_welcomeVendor($session->getVendor(), true);
                    }
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Vendor_Model_Vendor::EXCEPTION_EMAIL_NOT_CONFIRMED:
                            $value = Mage::helper('vendor')->getEmailConfirmationUrl($login['email']);
                            $message = Mage::helper('vendor')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                            break;
                        case Mage_Vendor_Model_Vendor::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $session->addError($message);
                    $session->setUsername($login['email']);
                } catch (Exception $e) {
                    // Mage::logException($e); // PA DSS violation: this exception log can disclose vendor password
                }
            } else {
                $session->addError($this->__('Login and password are required.'));
            }
        }

        $this->_loginPostRedirect();
    
    }

    protected function _loginPostRedirect()
    {
        $session = $this->_getSession();

        if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::getBaseUrl()) {
            // Set default URL to redirect vendor to
            $session->setBeforeAuthUrl(Mage::helper('vendor')->getAccountUrl());
            // Redirect vendor to the last page visited after logging in
            if ($session->isLoggedIn()) {
                if (!Mage::getStoreConfigFlag(
                    Mage_Vendor_Helper_Data::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD
                )) {
                    $referer = $this->getRequest()->getParam(Mage_Vendor_Helper_Data::REFERER_QUERY_PARAM_NAME);
                    if ($referer) {
                        // Rebuild referer URL to handle the case when SID was changed
                        $referer = $this->_getModel('core/url')
                            ->getRebuiltUrl( Mage::helper('core')->urlDecodeAndEscape($referer));
                        if ($this->_isUrlInternal($referer)) {
                            $session->setBeforeAuthUrl($referer);
                        }
                    }
                } else if ($session->getAfterAuthUrl()) {
                    $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
                }
            } else {
                $session->setBeforeAuthUrl( Mage::helper('vendor')->getLoginUrl());
            }
        } else if ($session->getBeforeAuthUrl() ==  Mage::helper('vendor')->getLogoutUrl()) {
            $session->setBeforeAuthUrl( Mage::helper('vendor')->getDashboardUrl());
        } else {
            if (!$session->getAfterAuthUrl()) {
                $session->setAfterAuthUrl($session->getBeforeAuthUrl());
            }
            if ($session->isLoggedIn()) {
                $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
            }
        }
        $this->_redirectUrl($session->getBeforeAuthUrl(true));
    }


    protected function _welcomeVendor(Mage_Vendor_Model_Vendor $vendor, $isJustConfirmed = false)
    {
        $this->_getSession()->addSuccess(
            $this->__('Thank you for registering with %s.', Mage::app()->getStore()->getFrontendName())
        );
        if ($this->_isVatValidationEnabled()) {
            // Show corresponding VAT message to vendor
            $configAddressType =  $this->_getHelper('vendor/address')->getTaxCalculationAddressType();
            $userPrompt = '';
            switch ($configAddressType) {
                case Mage_Vendor_Model_Address_Abstract::TYPE_SHIPPING:
                    $userPrompt = $this->__('If you are a registered VAT vendor, please click <a href="%s">here</a> to enter you shipping address for proper VAT calculation',
                        $this->_getUrl('vendor/address/edit'));
                    break;
                default:
                    $userPrompt = $this->__('If you are a registered VAT vendor, please click <a href="%s">here</a> to enter you billing address for proper VAT calculation',
                        $this->_getUrl('vendor/address/edit'));
            }
            $this->_getSession()->addSuccess($userPrompt);
        }

        $vendor->sendNewAccountEmail(
            $isJustConfirmed ? 'confirmed' : 'registered',
            '',
            Mage::app()->getStore()->getId(),
            $this->getRequest()->getPost('password')
        );

        $successUrl = $this->_getUrl('*/*/index', array('_secure' => true));
        if ($this->_getSession()->getBeforeAuthUrl()) {
            $successUrl = $this->_getSession()->getBeforeAuthUrl(true);
        }
        return $successUrl;
    }



        

        
}