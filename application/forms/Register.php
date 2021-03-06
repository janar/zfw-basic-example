<?php

class Application_Form_Register extends Zend_Form
{
    public function init()
    {
        $this->setName('register');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $emailValidator = new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'users',
                'field' => 'email'
            )
        );
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('EmailAddress')
               ->addValidator('NotEmpty')
               ->addValidator($emailValidator);

        $PasswordLenghtValidator = new Zend_Validate_StringLength(4, 32);
        
        $pwd = new Zend_Form_Element_Password('password');
        $pwd->setLabel('Password')
            ->setRequired(true)
            ->addValidator($PasswordLenghtValidator)
            ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'btnSubmit');
        $submit->setAttrib('class', 'btn btn-primary');

        $this->addElements(array($id, $email, $pwd, $submit));
    }
}