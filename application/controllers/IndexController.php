<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->title = "Frontpage";
        $this->view->headTitle($this->view->title);
    }

}
