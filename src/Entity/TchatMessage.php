<?php

namespace App\Entity;

use App\Repository\TchatMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TchatMessageRepository::class)
 */
class TchatMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tchatMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $speaker;

    /**
     * @ORM\ManyToOne(targetEntity=Tchat::class, inversedBy="messages")
     */
    private $tchat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSpeaker(): ?User
    {
        return $this->speaker;
    }

    public function setSpeaker(?User $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getTchat(): ?Tchat
    {
        return $this->tchat;
    }

    public function setTchat(?Tchat $tchat): self
    {
        $this->tchat = $tchat;

        return $this;
    }
}
