<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="`id`",)
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="`email`", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string",name="`password`", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", name="`name`", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", name="`active`",)
     */
    private $active;

    /**
     * @ORM\Column(type="string", name="`role`", length=16)
     */
    private $role;

    /**
     * @ORM\Column(type="string", name="`rank`", length=16)
     */
    private $rank;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MeetingRequest", mappedBy="user", orphanRemoval=true)
     */
    private $meetingRequests;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->meetingRequests = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(string $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function eraseCredentials()
    {}

    public function getSalt()
    {
        return null;
    }

    public function isAccountNonExpired()
    {
        return $this->active;
    }

    public function isAccountNonLocked()
    {
        return $this->active;
    }

    public function isCredentialsNonExpired()
    {
        return $this->active;
    }

    public function isEnabled()
    {
        return $this->active;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MeetingRequest[]
     */
    public function getMeetingRequests(): Collection
    {
        return $this->meetingRequests;
    }

    public function addMeetingRequest(MeetingRequest $meetingRequest): self
    {
        if (!$this->meetingRequests->contains($meetingRequest)) {
            $this->meetingRequests[] = $meetingRequest;
            $meetingRequest->setUser($this);
        }

        return $this;
    }

    public function removeMeetingRequest(MeetingRequest $meetingRequest): self
    {
        if ($this->meetingRequests->contains($meetingRequest)) {
            $this->meetingRequests->removeElement($meetingRequest);
            // set the owning side to null (unless already changed)
            if ($meetingRequest->getUser() === $this) {
                $meetingRequest->setUser(null);
            }
        }

        return $this;
    }

}
