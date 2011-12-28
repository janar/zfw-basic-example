<?php

class Application_Form_Profile extends Zend_Form
{
    public function init()
    {
        $this->setName('user');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty');


        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('Firstname')
               ->addFilter('StripTags')
               ->addFilter('StringTrim');

        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Lastname')
               ->addFilter('StripTags')
               ->addFilter('StringTrim');
               
        $pwd = new Zend_Form_Element_Text('password');
        $pwd->setLabel('Password')
              ->addFilter('StripTags')
              ->addFilter('StringTrim');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'btnSubmit');

        $this->addElements(array($email, $firstname, $lastname, $pwd, $submit));
    }
}