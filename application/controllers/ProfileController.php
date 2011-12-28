<?php

class ProfileController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->title = "Profile";
        $this->view->headTitle($this->view->title);

        $this->view->userRecord = Zend_Auth::getInstance()->getIdentity();
    }

    public function registerAction()
    {
        $this->view->title = "Register";
        $this->view->headTitle($this->view->title);
        
        $form = new Application_Form_Register();
        $form->submit->setLabel('Register');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $users = new Application_Model_DbTable_Users();
                $users->addUser($formData);
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }
    
    public function loginAction()
    {
        //Redirect if user already logged in
        //in this case ACL should already done that
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_redirect('index');
        }
        
        $this->view->title = "Login";
        $this->view->headTitle($this->view->title);
        
        $message = "";
        $form = new Application_Form_Login();
        $form->submit->setLabel('Login');
        $this->view->form = $form;

        $this->view->headTitle("Login");

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
                $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                $adapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                $adapter->setTableName('users')
                        ->setIdentityColumn('email')
                        ->setCredentialColumn('password')
                        ->setCredentialTreatment('SHA1(?)');
                
                $adapter->setIdentity($formData['email'])
                        ->setCredential($formData['password']);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);

                //if valid user, store login information and redirect to profile
                if($result->isValid())
                {
                    $userInfo = $adapter->getResultRowObject(null, 'password');
                    $storage = $auth->getStorage();
                    $storage->write($userInfo);

                    $this->_redirect('profile');
                }
                else
                {
                    $form->populate($formData);
                    $message = "Wrong username or password provided. Please try again.";
                }
            }
            else
            {
                $form->populate($formData);
                $message = "Form was filled incorrectly. Please try again.";
            }
        }

        $this->view->errorMessage = $message;
    }
    
    public function settingsAction()
    {
        $this->view->title = "Profile settings";
        $this->view->headTitle($this->view->title);

        $session = new Zend_Session_Namespace('profileController');

        $form = new Application_Form_Profile();
        $form->submit->setLabel('Update');
        $this->view->form = $form;

        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $userRecord = Zend_Auth::getInstance()->getIdentity();
        } else {
            $this->_helper->redirector('profile');
        }
        
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $updateRecord = array(
                    'email' => $form->getValue('email'),
                    'firstname' => $form->getValue('firstname'),
                    'lastname' => $form->getValue('lastname')
                );
                if($form->getValue('password') != ''){
                    $updateRecord['password'] = $form->getValue('password');
                }

                $users = new Application_Model_DbTable_Users();
                $users->updateUser($userRecord->id, $updateRecord);
                
                $session->updated = true;
                $this->_helper->redirector('settings', 'profile');
            } else {
                $form->populate($formData);
            }
        } else {
            $users = new Application_Model_DbTable_Users();
            $currentUserRecord = $users->getUser($userRecord->id);
            unset($currentUserRecord['password']);
            $form->populate($currentUserRecord);
        }

        $this->view->updated = false;
        if(isset($session->updated) && $session->updated)
        {
            $this->view->updated = true;
        }
        
        $session->updated = false;
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index');
    }
}
