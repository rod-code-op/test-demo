<?php

namespace App\Entity;

use App\Enum\RoomType;
use App\Repository\RoomsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Rooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $roomNumber = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $price = null;

    #[ORM\Column(enumType: RoomType::class)]
    private ?RoomType $type = null;

    #[ORM\OneToOne(mappedBy: 'room_id', cascade: ['persist', 'remove'])]
    private ?Booking $booking = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;



    

    // --- Getters and Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomNumber(): ?string
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(string $roomNumber): static
    {
        $this->roomNumber = $roomNumber;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getType(): ?RoomType
    {
        return $this->type;
    }

    public function setType(RoomType $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): static
    {
        if ($booking === null && $this->booking !== null) {
            $this->booking->setRoomId(null);
        }

        if ($booking !== null && $booking->getRoomId() !== $this) {
            $booking->setRoomId($this);
        }

        $this->booking = $booking;

        return $this;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
        
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

}