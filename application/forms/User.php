<?php

class Application_Form_User extends Zend_Form
{
    public function init()
    {
        $this->setName('user');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

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

        $PasswordLenghtValidator = new Zend_Validate_StringLength(4, 32);
        
        $pwd = new Zend_Form_Element_Password('password');
        $pwd->setLabel('Password')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator($PasswordLenghtValidator);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'btnSubmit');

        $this->addElements(array($id, $email, $firstname, $lastname, $pwd, $submit));
    }
}