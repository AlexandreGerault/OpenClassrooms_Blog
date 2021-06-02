<?php

namespace AGerault\Blog\Validators;

use AGerault\Framework\Validation\Rules\EmailRule;
use AGerault\Framework\Validation\Rules\InArrayRule;
use AGerault\Framework\Validation\Rules\SameRule;
use AGerault\Framework\Validation\Rules\StringRule;
use AGerault\Framework\Validation\Rules\UniqueRule;
use AGerault\Framework\Validation\Validator;
use PDO;

class RegistrationValidator extends Validator
{
    public function __construct(
        protected array $inputs,
        protected PDO $PDO
    ) {
    }

    public function rules(): array
    {
        return [
            'name'             => [
                new StringRule($this->input('name'))
            ],
            'email'            => [
                new StringRule($this->input('email')),
                new EmailRule($this->input('email')),
                new UniqueRule($this->input('email'), $this->PDO, 'users', 'email')
            ],
            'password'         => [
                new StringRule($this->input('password'))
            ],
            'password_confirm' => [
                new StringRule($this->input('password_confirm')),
                new SameRule($this->input('password_confirm'), $this->input('password'))
            ]
        ];
    }
}
