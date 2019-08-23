<?php

namespace Application\Form;

use Zend\Form\Element\File;
use Zend\Form\Element\Image;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class ApplicationForm extends Form
{
    public function __construct()
    {
        parent::__construct('application_form');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Application Name'
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'My Awesome App'
            ]
        ]);

        $this->add([
            'name' => 'description',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Description'
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'A description of my awesome app'
            ]
        ]);

        $this->add([
            'name' => 'avatar',
            'type' => File::class,
            'options' => [
                'label' => 'Application Avatar'
            ],
            'attributes' => [
                'step' => 00,
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'class' => 'btn btn-success',
                'value' => 'Save'
            ]
        ]);
    }
}
