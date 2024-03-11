<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InviteRepository::class)]
class Invite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $inv_from = null;

    #[ORM\Column]
    private ?int $inv_to = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvFrom(): ?int
    {
        return $this->inv_from;
    }

    public function setInvFrom(int $inv_from): static
    {
        $this->inv_from = $inv_from;

        return $this;
    }

    public function getInvTo(): ?int
    {
        return $this->inv_to;
    }

    public function setInvTo(int $inv_to): static
    {
        $this->inv_to = $inv_to;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
