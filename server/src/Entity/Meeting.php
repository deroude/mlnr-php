<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeetingRepository")
 */
class Meeting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MeetingRequest", mappedBy="meeting", orphanRemoval=true)
     */
    private $meetingRequests;

    public function __construct()
    {
        $this->meetingRequests = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $meetingRequest->setMeeting($this);
        }

        return $this;
    }

    public function removeMeetingRequest(MeetingRequest $meetingRequest): self
    {
        if ($this->meetingRequests->contains($meetingRequest)) {
            $this->meetingRequests->removeElement($meetingRequest);
            // set the owning side to null (unless already changed)
            if ($meetingRequest->getMeeting() === $this) {
                $meetingRequest->setMeeting(null);
            }
        }

        return $this;
    }
}
