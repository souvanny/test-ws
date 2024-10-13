<?php

namespace App\Database\Entity;

class Shop
{
    private ?int $id;
    private ?string $name;
    private ?int $isDeleted;

    public function __construct(int $id = null, string $name = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isDeleted = $isDeleted;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getIsDeleted(): ?int
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?int $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

}
