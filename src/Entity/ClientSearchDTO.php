<?php

namespace App\Entity;

use App\Repository\ClientSearchDTORepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientSearchDTORepository::class)]
class ClientSearchDTO
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $searchTerm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchTerm(): ?string
    {
        return $this->searchTerm;
    }

    public function setSearchTerm(?string $searchTerm): static
    {
        $this->searchTerm = $searchTerm;

        return $this;
    }
}
