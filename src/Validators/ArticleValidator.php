<?php

namespace AGerault\Blog\Validators;

use AGerault\Framework\Validation\Rules\StringRule;
use AGerault\Framework\Validation\Validator;
use PDO;

class ArticleValidator extends Validator
{
    public function __construct(array $inputs, protected PDO $PDO)
    {
        parent::__construct($inputs);
    }

    public function rules(): array
    {
        return [
            'title'   => [new StringRule($this->input('title'))],
            'slug'    => [new StringRule($this->input('slug'))],
            'chapo'   => [new StringRule($this->input('chapo'))],
            'content' => [new StringRule($this->input('content'))]
        ];
    }
}
