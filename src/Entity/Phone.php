<?php

namespace App\Entity;

use App\Entity\Agenda\Contact;
use App\Repository\PhoneRepository;
use BcMath\Number;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhoneRepository::class)]
class Phone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $Number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;

    #[ORM\ManyToOne(inversedBy: 'phones', cascade: ['persist'])]
    private ?Contact $contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->Number;
    }

    public function setNumber(?String $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }
}
