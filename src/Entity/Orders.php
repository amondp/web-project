<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placedby;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderdetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryaddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlacedby(): ?string
    {
        return $this->placedby;
    }

    public function setPlacedby(string $placedby): self
    {
        $this->placedby = $placedby;

        return $this;
    }

    public function getOrderdetails(): ?string
    {
        return $this->orderdetails;
    }

    public function setOrderdetails(string $orderdetails): self
    {
        $this->orderdetails = $orderdetails;

        return $this;
    }

    public function getDeliveryaddress(): ?string
    {
        return $this->deliveryaddress;
    }

    public function setDeliveryaddress(?string $deliveryaddress): self
    {
        $this->deliveryaddress = $deliveryaddress;

        return $this;
    }
}
