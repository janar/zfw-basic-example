<?php

class UsersController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->title = "Manage users";
        $this->view->headTitle($this->view->title);
        
        $users = new Application_Model_DbTable_Users();
        $this->view->users = $users->fetchAll();
    }

    public function addAction()
    {
        $this->view->title = "Add user";
        $this->view->headTitle($this->view->title);
        
        $form = new Application_Form_User();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $newUser = array(
                    'email' => $form->getValue('email'),
                    'firstname' => $form->getValue('firstname'),
                    'lastname' => $form->getValue('lastname'),
                    'password' => $form->getValue('password')
                );
                
                $users = new Application_Model_DbTable_Users();
                $users->addUser($newUser);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }

    }

    public function editAction()
    {
        $this->view->title = "Update user";
        $this->view->headTitle($this->view->title);

        $id = $this->_getParam('id', 0);
        
        $form = new Application_Form_User(null, "edit", $id);
        $form->submit->setLabel('Update');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $updateRecord = array(
                    'email' => $form->getValue('email'),
                    'firstname' => $form->getValue('firstname'),
                    'lastname' => $form->getValue('lastname')
                );
                if($form->getValue('password') != ''){
                    $updateRecord['password'] = $form->getValue('password');
                }
                
                $users = new Application_Model_DbTable_Users();
                $users->updateUser($id, $updateRecord);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            if ($id > 0) {
                $users = new Application_Model_DbTable_Users();
                $currentUserRecord = $users->getUser($id);
                unset($currentUserRecord['password']);
                $form->populate($currentUserRecord);
            }
        }

    }

    public function deleteAction()
    {
        $this->view->title = "Delete user";
        $this->view->headTitle($this->view->title);
        
        if ($this->getRequest()->isPost()) {
            $answer = $this->getRequest()->getPost('answer');
            if ($answer == 'yes') {
                $id = $this->getRequest()->getPost('id');
                $users = new Application_Model_DbTable_Users();
                $users->deleteUser($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $users = new Application_Model_DbTable_Users();
            $this->view->user = $users->getUser($id);
        }
    }

}
