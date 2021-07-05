<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as HttpFoundationFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isShared;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @Vich\UploadableField(mapping="project_file", fileNameProperty="name")
     * @var File
     */
    private $projectFile;

    public function __toString()
    {
        return $this->name ? $this->name : 'Vide';
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();

    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();

    }

    public function getIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(bool $isShared): self
    {
        $this->isShared = $isShared;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    /**
     * @return HttpFoundationFile
     */
    public function getProjectFile(): ?HttpFoundationFile
    {
        return $this->projectFile;
    }

    /**
     * @param HttpFoundationFile $projectFile
     */
    public function setProjectFile(HttpFoundationFile $projectFile = null)
    {
        $this->projectFile = $projectFile;
        if ($projectFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }
}
