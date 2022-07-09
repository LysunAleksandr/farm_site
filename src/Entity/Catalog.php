<?php

namespace App\Entity;

use App\Repository\CatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ORM\Entity(repositoryClass=CatalogRepository::class)
 */
class Catalog
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
    private ?string $title;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoFilename;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description;

    /**
     * @ORM\ManyToMany(targetEntity=Ingridient::class)
     */
    private  $Ingr;



    public function __construct()
    {
        $this->basketPositions = new ArrayCollection();
        $this->Ingr = new ArrayCollection();
    }


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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }


    public function getPhotoFilename(): ?string
    {
        return $this->photoFilename;
    }

    public function setPhotoFilename(?string $photoFilename): self
    {
        $this->photoFilename = $photoFilename;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;// . ' ' . $this->description;
    }

     /**
     * @return Collection|Ingridient[]
     */
    public function getIngr(): Collection
    {
        return $this->Ingr;
    }

    public function addIngr(Ingridient $ingr): self
    {
        if (!$this->Ingr->contains($ingr)) {
            $this->Ingr[] = $ingr;
        }

        return $this;
    }

    public function removeIngr(Ingridient $ingr): self
    {
        $this->Ingr->removeElement($ingr);

        return $this;
    }


}
