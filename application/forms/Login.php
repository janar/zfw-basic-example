<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName('login');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('EmailAddress')
              ->addValidator('NotEmpty');

        $pwd = new Zend_Form_Element_Password('password');
        $pwd->setLabel('Password')
              ->setRequired(true)
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'btnSubmit');

        $this->addElements(array($id, $email, $pwd, $submit));
    }
}