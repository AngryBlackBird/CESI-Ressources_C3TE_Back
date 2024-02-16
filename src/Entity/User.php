<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\MeController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: 'user/me',
            controller: MeController::class,
            security: "is_granted('ROLE_USER')",
            read: false,
            name: 'me'
        ),

    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
#[GetCollection(security: "is_granted('ROLE_ADMIN')")]
#[Get]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_USER') and object == user or is_granted('ROLE_ADMIN')",)]
#[Put(security: "is_granted('ROLE_USER') and object == user or is_granted('ROLE_ADMIN')",)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['admin:read'])]
    private ?string $phone = null;

    #[ORM\Column]
    #[Groups(['admin:read'])]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Resource::class)]
    #[Groups(['read'])]
    private Collection $resources;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class, orphanRemoval: true)]
    #[Groups(['read', 'admin:read'])]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Resource::class, inversedBy: 'users')]
    #[Groups(['read'])]
    private Collection $favoris;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Report::class)]
    #[Groups(['read', 'admin:read'])]
    private Collection $reports;

    #[ORM\OneToMany(mappedBy: 'share_by', targetEntity: Share::class, orphanRemoval: true)]
    #[Groups(['admin:read'])]
    private Collection $shares;

    #[ORM\ManyToMany(targetEntity: Share::class, mappedBy: 'share_to')]
    #[Groups(['admin:read'])]
    private Collection $shares_to;

    public function __construct()
    {
        $this->resources = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->shares = new ArrayCollection();
        $this->shares_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(Resource $resource): static
    {
        if (!$this->resources->contains($resource)) {
            $this->resources->add($resource);
            $resource->setAuthor($this);
        }

        return $this;
    }

    public function removeResource(Resource $resource): static
    {
        if ($this->resources->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getAuthor() === $this) {
                $resource->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Resource $favori): static
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(Resource $favori): static
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setAuthor($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getAuthor() === $this) {
                $report->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getShares(): Collection
    {
        return $this->shares;
    }

    public function addShare(Share $share): static
    {
        if (!$this->shares->contains($share)) {
            $this->shares->add($share);
            $share->setShareBy($this);
        }

        return $this;
    }

    public function removeShare(Share $share): static
    {
        if ($this->shares->removeElement($share)) {
            // set the owning side to null (unless already changed)
            if ($share->getShareBy() === $this) {
                $share->setShareBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getSharesTo(): Collection
    {
        return $this->shares_to;
    }

    public function addSharesTo(Share $sharesTo): static
    {
        if (!$this->shares_to->contains($sharesTo)) {
            $this->shares_to->add($sharesTo);
            $sharesTo->addShareTo($this);
        }

        return $this;
    }

    public function removeSharesTo(Share $sharesTo): static
    {
        if ($this->shares_to->removeElement($sharesTo)) {
            $sharesTo->removeShareTo($this);
        }

        return $this;
    }
}
