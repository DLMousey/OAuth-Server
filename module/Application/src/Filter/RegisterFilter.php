<?php

namespace Application\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'username',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
        ]);

        $this->add([
            'name' => 'first_name',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ]
        ]);

        $this->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ]
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
            'validators' => [
                ['name' => EmailAddress::class]
            ]
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                ['name' => StringLength::class, 'options' => ['minLength' => 6]]
            ]
        ]);

        $this->add([
            'name' => 'date_of_birth',
            'required' => false,
            'validators' => [
                ['name' => Date::class]
            ]
        ]);
    }
}
