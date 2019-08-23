<?php


namespace Application\Form;

use Zend\Form\Element\Date;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct()
    {
        parent::__construct('register_form');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'username',
            'type' => Text::class,
            'options' => [
                'label' => 'Username'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'first_name',
            'type' => Text::class,
            'options' => [
                'label' => 'First Name'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'last_name',
            'type' => Text::class,
            'options' => [
                'label' => 'Last Name'
            ],
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

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
            'name' => 'date_of_birth',
            'type' => Date::class,
            'options' => [
                'label' => 'Date of birth'
            ],
            'attributes' => [
                'class' => 'form-control',
                'step' => '1'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'class' => 'btn btn-success',
                'value' => 'Register'
            ]
        ]);
    }
}
