<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Orders::class, inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $order = null;

    #[ORM\ManyToOne(targetEntity: Pizzas::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pizzas $pizza = null;

    #[ORM\ManyToOne(targetEntity: Sizes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sizes $size = null;

    #[ORM\ManyToMany(targetEntity: Toppings::class)]
    #[ORM\JoinTable(name: "order_item_toppings")]
    private Collection $toppings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    public function __construct()
    {
        $this->toppings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Orders
    {
        return $this->order;
    }

    public function setOrder(?Orders $order): static
    {
        $this->order = $order;
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

    public function getToppings(): Collection
    {
        return $this->toppings;
    }

    public function addTopping(Toppings $topping): static
    {
        if (!$this->toppings->contains($topping)) {
            $this->toppings->add($topping);
        }
        return $this;
    }

    public function removeTopping(Toppings $topping): static
    {
        $this->toppings->removeElement($topping);
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }
}
