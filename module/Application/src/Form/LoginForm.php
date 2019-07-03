<?php

namespace Application\Form;

use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login_form');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'Email Address'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'class' => 'btn btn-success',
                'value' => 'Login'
            ]
        ]);
    }
}
