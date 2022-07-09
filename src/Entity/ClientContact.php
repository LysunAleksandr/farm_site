<?php

namespace App\Entity;

use App\Repository\ClientContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientContactRepository::class)
 */
class ClientContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private ?string $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $adress;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="clientContact")
     */
    private  $OrderId;

    public function __construct()
    {
        $this->OrderId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderId(): Collection
    {
        return $this->OrderId;
    }

    public function addOrderId(Order $orderId): self
    {
        if (!$this->OrderId->contains($orderId)) {
            $this->OrderId[] = $orderId;
            $orderId->setClientContact($this);
        }

        return $this;
    }

    public function removeOrderId(Order $orderId): self
    {
        if ($this->OrderId->removeElement($orderId)) {
            // set the owning side to null (unless already changed)
            if ($orderId->getClientContact() === $this) {
                $orderId->setClientContact(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return  $this->id . ' |     ' . $this->telephone . ' |     ' . $this->getName()   ;
    }
}
