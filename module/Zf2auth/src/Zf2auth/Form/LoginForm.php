<?php

namespace Zf2auth\Form;

use Zend\Form\Form;
use \Zend\Form\Element;

class LoginForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('users');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('method', 'post');
        $this->setAttribute('novalidate', true);

        $email = new Element\Email('email');
        $email->setLabel('Email')
                ->setAttribute('class', 'form-control')
                ->setAttribute('maxlength', '200')
                ->setAttribute('required', true)
                ->setAttribute('placeholder', 'Email address');


        $password = new Element\Password('password');
        $password->setLabel('Password')
                ->setAttribute('class', 'form-control')
                ->setAttribute('maxlength', '200')
                ->setAttribute('required', true)
                ->setAttribute('placeholder', 'Password');

        $rememberme = new Element\Checkbox('rememberme');
        $rememberme->setLabel('remember me')
                ->setAttribute('class', '')
                ->setValue('1');

        $submit = new Element\Submit('submit');
        $submit->setValue('Log in')
                ->setAttribute('class', 'btn btn-lg btn-primary btn-block');

        $this->add($email);
        $this->add($password);
        $this->add($rememberme);
        $this->add($submit);
    }

}

