<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $sentAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiver;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $targetPath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $targetPathFragment;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class)
     */
    private $project;

    public function __construct(
        string $content,
        User $receiver,
        string $targetPath,
        string $targetPathFragment,
        $project = null
    ) {
        $this->setContent($content);
        $this->setReceiver($receiver);
        $this->setTargetPath($targetPath);
        $this->setTargetPathFragment($targetPathFragment);
        $this->setProject($project);
        $this->setSentAt(new \DateTime('now'));
        $this->setIsRead(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getTargetPath(): ?string
    {
        return $this->targetPath;
    }

    public function setTargetPath(string $targetPath): self
    {
        $this->targetPath = $targetPath;

        return $this;
    }

    public function getTargetPathFragment(): ?string
    {
        return $this->targetPathFragment;
    }

    public function setTargetPathFragment(?string $targetPathFragment): self
    {
        $this->targetPathFragment = $targetPathFragment;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
