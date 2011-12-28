<?php

class ZfwBase_Acl extends Zend_Acl {
    public function __construct() {

        //Add guest role
        $this->addRole(new Zend_Acl_Role('guest'));

        //Add "user" role, which inherits from guest
        $this->addRole(new Zend_Acl_Role('user'), 'guest');

        //and admin inherits from user
        $this->addRole(new Zend_Acl_Role('admin'), 'user');

        //Add resources (I use controllers as resources)
        $this->add(new Zend_Acl_Resource('users'));
        $this->add(new Zend_Acl_Resource('profile'));
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('index'));

        //allow login and register actions for role guest in profile controller
        $this->allow('guest', 'profile', array('login', 'register'));
        $this->allow('guest', 'index');


        $this->allow('user', 'profile', array('index', 'logout', 'settings'));

        //admin can access everything
        $this->allow('admin');

    }
}
