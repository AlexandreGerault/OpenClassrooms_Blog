<?php


namespace AGerault\Blog\Models;


use DateTimeInterface;

class Article
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?string $slug = null,
        protected ?string $chapo = null,
        protected ?string $content = null,
        protected ?User $author = null,
        protected ?DateTimeInterface $createdAt = null,
        protected ?DateTimeInterface $updatedAt = null,
        protected array $comments = []
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function chapo(): string
    {
        return $this->chapo;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): User
    {
        return $this->author;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return array<Comment>
     */
    public function comments(): array
    {
        return $this->comments;
    }

    public static function fromArray(array $inputs): Article
    {
        return new self(
            name: $inputs['title'],
            slug: $inputs['slug'],
            chapo: $inputs['chapo'],
            content: $inputs['content'],
            author: $inputs['user'],
            createdAt: $inputs['createdAt']
        );
    }
}
