<?php

namespace App\Database\Entity;

use App\Database\Database;
use PDO;

class Shop
{
    private ?int $id;
    private ?string $name;

    private ?bool $isDeleted;

    public function __construct(int $id = null, string $name = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isDeleted = $isDeleted;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

}