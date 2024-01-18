<?php

namespace App\Entity;

use App\Repository\ShareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShareRepository::class)]
class Share
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resource $resource = null;

    #[ORM\ManyToOne(inversedBy: 'shares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $share_by = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'shares_to')]
    private Collection $share_to;

    public function __construct()
    {
        $this->share_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getShareBy(): ?User
    {
        return $this->share_by;
    }

    public function setShareBy(?User $share_by): static
    {
        $this->share_by = $share_by;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getShareTo(): Collection
    {
        return $this->share_to;
    }

    public function addShareTo(User $shareTo): static
    {
        if (!$this->share_to->contains($shareTo)) {
            $this->share_to->add($shareTo);
        }

        return $this;
    }

    public function removeShareTo(User $shareTo): static
    {
        $this->share_to->removeElement($shareTo);

        return $this;
    }
}
