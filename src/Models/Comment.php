<?php

namespace AGerault\Blog\Models;

use DateTimeInterface;

class Comment
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $email = null,
        private ?string $content = null,
        private ?DateTimeInterface $createdAt = null,
        private ?bool $validated = null,
        private ?Article $article = null
    ) {}

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function createdAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function validated(): ?bool
    {
        return $this->validated;
    }

    public function article(): ?Article
    {
        return $this->article;
    }
}
