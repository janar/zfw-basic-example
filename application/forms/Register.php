<?php

class Application_Form_Register extends Zend_Form
{
    public function init()
    {
        $this->setName('register');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('EmailAddress')
               ->addValidator('NotEmpty');

        $pwd = new Zend_Form_Element_Text('password');
        $pwd->setLabel('Password')
              ->setRequired(true)
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'btnSubmit');

        $this->addElements(array($id, $email, $pwd, $submit));
    }
}