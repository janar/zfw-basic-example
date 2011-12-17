<?php

class ZfwBase_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
    private $_acl = null;

    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        if(Zend_Auth::getInstance()->hasIdentity()){
            $user = Zend_Auth::getInstance()->getIdentity();
            $role = $user->role;
        } else {
            $role = 'guest';
        }

        //For this example, we will use the controller as the resource:
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if(!$this->_acl->isAllowed($role, $controller, $action)) {
            $request->setControllerName('profile')->setActionName('login');
        }
    }
}
