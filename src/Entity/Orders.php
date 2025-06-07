<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Each order is placed by one customer
    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    // Each order is for one pizza
    #[ORM\ManyToOne(targetEntity: Pizzas::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pizzas $pizza = null;

    // Size of the pizza
    #[ORM\ManyToOne(targetEntity: Sizes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sizes $size = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customerComment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;
        return $this;
    }

    public function getPizza(): ?Pizzas
    {
        return $this->pizza;
    }

    public function setPizza(?Pizzas $pizza): static
    {
        $this->pizza = $pizza;
        return $this;
    }

    public function getSize(): ?Sizes
    {
        return $this->size;
    }

    public function setSize(?Sizes $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function getCustomerComment(): ?string
    {
        return $this->customerComment;
    }

    public function setCustomerComment(?string $comment): static
    {
        $this->customerComment = $comment;
        return $this;
    }
}
