<?php

namespace AGerault\Blog\Validators;

use AGerault\Framework\Validation\Rules\EmailRule;
use AGerault\Framework\Validation\Rules\ExistRule;
use AGerault\Framework\Validation\Rules\StringRule;
use AGerault\Framework\Validation\Validator;
use PDO;

class LoginValidator extends Validator
{
    public function __construct(array $inputs, protected PDO $PDO)
    {
        $this->inputs = $inputs;
    }

    public function rules(): array
    {
        return [
            'email'    => [
                new StringRule($this->input('email')),
                new EmailRule($this->input('email')),
                new ExistRule($this->input('email'), $this->PDO, 'users', 'email')
            ],
            'password' => [
                new StringRule($this->input('password'))
            ]
        ];
    }
}
