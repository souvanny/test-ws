<?php

namespace App\Database\Entity;

/**
 * Décrit l'entité Shop avec tous ses champs
 * ainsi que leur getter setter
 */
class Shop
{
    private ?int $id;
    private ?string $name;
    private ?string $city;

    public function __construct(int $id = null, string $name = null, string $city = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

}
