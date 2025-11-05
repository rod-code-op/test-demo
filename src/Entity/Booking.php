<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $booked_date = null;

    #[ORM\OneToOne(inversedBy: 'booking', cascade: ['persist', 'remove'])]
    private ?Rooms $room_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getBookedDate(): ?\DateTime
    {
        return $this->booked_date;
    }

    public function setBookedDate(\DateTime $booked_date): static
    {
        $this->booked_date = $booked_date;

        return $this;
    }

    public function getRoomId(): ?Rooms
    {
        return $this->room_id;
    }

    public function setRoomId(?Rooms $room_id): static
    {
        $this->room_id = $room_id;

        return $this;
    }
}
