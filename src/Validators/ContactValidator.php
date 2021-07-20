<?php


namespace AGerault\Blog\Validators;


use AGerault\Framework\Validation\Rules\EmailRule;
use AGerault\Framework\Validation\Rules\StringRule;
use AGerault\Framework\Validation\Validator;

class ContactValidator extends Validator
{
    public function rules(): array
    {
        return [
            'first_name' => [new StringRule($this->input('first_name'))],
            'last_name' => [new StringRule($this->input('last_name'))],
            'email' => [
                new StringRule($this->input('email')),
                new EmailRule($this->input('email'))
            ],
            'subject' => [new StringRule($this->input('subject'))],
            'message' => [new StringRule($this->input('message'))],
        ];
    }
}
