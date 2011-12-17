<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initMain()
    {
        header("Content-type: text/html; charset=utf-8");
        
        //add basic access control
        $acl = new ZfwBase_Acl();
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new ZfwBase_Controller_Plugin_Acl($acl));

        //this will assign needed variables to main layout
        $front->registerPlugin(new ZfwBase_Controller_Plugin_LayoutVariables());

    }

    public function _initRoutes()
    {

    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
}
