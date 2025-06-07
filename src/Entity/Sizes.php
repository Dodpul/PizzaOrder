<?php

namespace App\Entity;

use App\Repository\SizesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizesRepository::class)]
class Sizes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $Size = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->Size;
    }

    public function setSize(string $Size): static
    {
        $this->Size = $Size;

        return $this;
    }
}
