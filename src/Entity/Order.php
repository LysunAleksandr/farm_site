<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
#[ApiResource (
   attributes: ["security" => "is_granted('ROLE_USER')"],
   collectionOperations: [
    "get" => ["security" => "is_granted('ROLE_USER')"],
    "post" => ["security" => "is_granted('ROLE_USER')"],
    ],
   itemOperations: [
    "get" => ["security" => "is_granted('ROLE_USER')"],
    "delete" => ["security" => "is_granted('ROLE_USER')"],
    ],
   normalizationContext: ['groups' => ['read']],
   denormalizationContext: ['groups' => ['write']],
)]

class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["read", "write"])]
    private ?int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(["read", "write"])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private  $date_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read", "write"])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read", "write"])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read", "write"])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $telehhone;

    /**
     * @ORM\OneToMany(targetEntity=BasketPosition::class, mappedBy="orderN")
     */
    #[Groups(["read"])]
    private $basketposition;

    /**
     * @ORM\ManyToOne(targetEntity=ClientContact::class, inversedBy="OrderId")
     */
    private $clientContact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(["read"])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $sessionID;

    public function __construct()
    {
        $this->basketposition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->date_at;
    }

    public function setDateAt(\DateTimeImmutable $date_at): self
    {
        $this->date_at = $date_at;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTelehhone(): ?string
    {
        return $this->telehhone;
    }

    public function setTelehhone(string $telehhone): self
    {
        $this->telehhone = $telehhone;

        return $this;
    }

    /**
     * @return Collection|BasketPosition[]
     */
    public function getBasketposition(): Collection
    {
        return $this->basketposition;
    }

    public function addBasketposition(BasketPosition $basketposition): self
    {
        if (!$this->basketposition->contains($basketposition)) {
            $this->basketposition[] = $basketposition;
            $basketposition->setOrderN($this);
        }

        return $this;
    }

    public function removeBasketposition(BasketPosition $basketposition): self
    {
        if ($this->basketposition->removeElement($basketposition)) {
            // set the owning side to null (unless already changed)
            if ($basketposition->getOrderN() === $this) {
                $basketposition->setOrderN(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): self
    {
        $this->date_at = new \DateTimeImmutable();

        return $this;
    }

    public function __toString(): string
    {
        return 'Order: ' . $this->id . ' |    at: ' . $this->getDateAt()->format('d/m/Y');
    }

    public function getClientContact(): ?ClientContact
    {
        return $this->clientContact;
    }

    public function setClientContact(?ClientContact $clientContact): self
    {
        $this->clientContact = $clientContact;

        return $this;
    }

    public function getSessionID(): ?string
    {
        return $this->sessionID;
    }

    public function setSessionID(string $sessionID): self
    {
        $this->sessionID = $sessionID;

        return $this;
    }

}
