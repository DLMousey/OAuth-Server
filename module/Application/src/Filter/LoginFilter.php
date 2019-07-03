<?php

namespace Application\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
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
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ]
        ]);
    }
}
