<?php

class Application_Form_Profile extends Zend_Form
{
    public function init()
    {
        $this->setName('user');

        $emailValidator = new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'users',
                'field' => 'email',
                'exclude' => array(
                    'field' => 'id',
                    'value' => Zend_Auth::getInstance()->getIdentity()->id
                )
            )
        );
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty')
               ->addValidator($emailValidator);


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
        $submit->setAttrib('class', 'btn btn-primary');

        $this->addElements(array($email, $firstname, $lastname, $pwd, $submit));
    }
}