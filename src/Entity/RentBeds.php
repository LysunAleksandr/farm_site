<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RentBedsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentBedsRepository::class)
 */
#[ApiResource]
class RentBeds
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $square;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videolink;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rentBeds")
     */
    private $renter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photofilename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=BasketPosition::class, mappedBy="Beds")
     */
    private $basketPositions;

    public function __construct()
    {
        $this->basketPositions = new ArrayCollection();
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

    public function getSquare(): ?int
    {
        return $this->square;
    }

    public function setSquare(int $square): self
    {
        $this->square = $square;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVideolink(): ?string
    {
        return $this->videolink;
    }

    public function setVideolink(string $videolink): self
    {
        $this->videolink = $videolink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRenter()
    {
        return $this->renter;
    }

    /**
     * @param mixed $renter
     */
    public function setRenter($renter): void
    {
        $this->renter = $renter;
    }

    public function getPhotofilename(): ?string
    {
        return $this->photofilename;
    }

    public function setPhotofilename(?string $photofilename): self
    {
        $this->photofilename = $photofilename;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;// . ' ' . $this->description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|BasketPosition[]
     */
    public function getBasketPositions(): Collection
    {
        return $this->basketPositions;
    }

    public function addBasketPosition(BasketPosition $basketPosition): self
    {
        if (!$this->basketPositions->contains($basketPosition)) {
            $this->basketPositions[] = $basketPosition;
            $basketPosition->setBeds($this);
        }

        return $this;
    }

    public function removeBasketPosition(BasketPosition $basketPosition): self
    {
        if ($this->basketPositions->removeElement($basketPosition)) {
            // set the owning side to null (unless already changed)
            if ($basketPosition->getBeds() === $this) {
                $basketPosition->setBeds(null);
            }
        }

        return $this;
    }
}
