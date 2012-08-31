<?php

class ZfwBase_Controller_Plugin_LayoutVariables extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        $view->acl = new ZfwBase_Acl();

        $view->controller = (string)$request->getParam('controller');
        $view->action = (string)$request->getParam('action');
        $view->hasIdentity = Zend_Auth::getInstance()->hasIdentity();
        $view->showUsersLink = false;

        
        if($view->hasIdentity)
        {
            $role = Zend_Auth::getInstance()->getIdentity()->role;
            $view->showUsersLink = $view->acl->isAllowed(
                $role,
                'users',
                'index');
        }
    }
}
