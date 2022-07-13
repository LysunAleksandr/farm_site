<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
#[ApiResource (
   attributes: ["security" => "is_granted('ROLE_ADMIN')"],
   collectionOperations: [
    "get" => ["security" => "is_granted('ROLE_ADMIN')"],
    "post" => ["security" => "is_granted('ROLE_ADMIN')"],
   ],
   itemOperations: [
    "get" => ["security" => "is_granted('ROLE_ADMIN')"],
    "delete" => ["security" => "is_granted('ROLE_ADMIN')"],
   ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Assert\NotBlank]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[Assert\NotBlank]
    private ?string $username;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Assert\NotBlank]
    private ?string $password;

    /**
     * @ORM\OneToMany(targetEntity=RentBeds::class, mappedBy="Ğrenter")
     */
    private $rentBeds;

    public function __construct()
    {
        $this->rentBeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    /**
     * @return Collection|RentBeds[]
     */
    public function getRentBeds(): Collection
    {
        return $this->rentBeds;
    }

    public function addRentBed(RentBeds $rentBed): self
    {
        if (!$this->rentBeds->contains($rentBed)) {
            $this->rentBeds[] = $rentBed;
            $rentBed->setĞrenter($this);
        }

        return $this;
    }

    public function removeRentBed(RentBeds $rentBed): self
    {
        if ($this->rentBeds->removeElement($rentBed)) {
            // set the owning side to null (unless already changed)
            if ($rentBed->getĞrenter() === $this) {
                $rentBed->setĞrenter(null);
            }
        }

        return $this;
    }

}
