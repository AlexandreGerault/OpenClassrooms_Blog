<?php

namespace AGerault\Blog\Validators;

use AGerault\Framework\Validation\Rules\EmailRule;
use AGerault\Framework\Validation\Rules\StringRule;
use AGerault\Framework\Validation\Rules\UniqueRule;
use AGerault\Framework\Validation\Validator;
use PDO;

class CommentValidator extends Validator
{
    public function __construct(
        protected array $inputs,
        protected PDO $PDO
    ) {}

    public function rules(): array
    {
        return [
            'email' => [
                new StringRule($this->input('email')),
                new EmailRule($this->input('email'))
            ],
            'name' => [new StringRule($this->input('name'))],
            'content' => [new StringRule($this->input('content'))]
        ];
    }
}
