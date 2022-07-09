<?php

namespace App\Entity;

use App\Repository\IngridientRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ORM\Entity(repositoryClass=IngridientRepository::class)
 */
#[ApiResource (
   collectionOperations: [
    "get",
    "post" => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
   itemOperations: [
    "get",
    "delete" => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
)]
class Ingridient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
