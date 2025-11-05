<?php

namespace App\Entity;

use App\Repository\CheckInOutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckInOutRepository::class)]
class CheckInOut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?booking $customer_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $check_in = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $check_out = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCustomerName(): ?booking
    {
        return $this->customer_name;
    }

    public function setCustomerName(?booking $customer_name): static
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getCheckIn(): ?\DateTime
    {
        return $this->check_in;
    }

    public function setCheckIn(\DateTime $check_in): static
    {
        $this->check_in = $check_in;

        return $this;
    }

    public function getCheckOut(): ?\DateTime
    {
        return $this->check_out;
    }

    public function setCheckOut(\DateTime $check_out): static
    {
        $this->check_out = $check_out;

        return $this;
    }
}
