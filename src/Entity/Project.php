<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\HasLifecycleCallbacks
 */

class Project
{
    public const STATUS_REQUEST_SEND = 0;
    public const STATUS_REQUEST_VALIDATED = 1;
    public const STATUS_OPEN = 2;
    public const STATUS_CLOSED = 3;

    public const TEXT_STATUS_MATRIX = [
        0 => 'Request sent',
        1 => 'Request validated',
        2 => 'Ongoing Project',
        3 => 'Project Done'
    ];

    private string $textStatus;
    private $commonSkillsWithUser;
    private $differentSkillsFromUser;



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255", maxMessage="You enter too many characters. This field cannot exceed {{ limit }} characters")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="project", orphanRemoval=true)
     */
    private $tasks;

    /**
     * @ORM\ManyToMany(targetEntity=Sdg::class, inversedBy="projects")
     */
    private $sdgs;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="projects")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="project", orphanRemoval=true)
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="project")
     *
     */
    private $participants;

    /**
     * @ORM\OneToOne(targetEntity=Tchat::class, mappedBy="project", cascade={"persist", "remove"})
     */
    private $tchat;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->sdgs = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    /**
     * Transform to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId();
    }

    public function __sleep()
    {
        return [];
    }

    public function getProjectOwner(): User
    {
        $participants = $this->getParticipants();
        foreach ($participants as $participant) {
            if ($participant->getRole() === Participant::ROLE_PROJECT_OWNER) {
                return $participant->getUser();
            }
        }
    }

    public function getProjectOwnerAndVolunteers(): array
    {
        $members = [];
        $participants = $this->getParticipants();
        foreach ($participants as $participant) {
            if ($participant->getRole() !== Participant::ROLE_WAITING_VOLUNTEER) {
                $members[] = $participant->getUser();
            }
        }
        return $members;
    }

    public function getVolunteers(): array
    {
        $volunteers = [];
        $projectMembers = $this->getParticipants();
        foreach ($projectMembers as $projectMember) {
            if ($projectMember->getRole() === Participant::ROLE_VOLUNTEER) {
                $volunteers[] = $projectMember;
            }
        }
        return $volunteers;
    }

    public function getParticipantOn(User $user): Participant
    {
        $participants = $user->getParticipants();

        foreach ($participants as $participant) {
            if ($this === $participant->getProject()) {
                return $participant;
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getTextStatus(): string
    {
        return $this->textStatus = $this::TEXT_STATUS_MATRIX[$this->status];
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sdg[]
     */
    public function getSdgs(): Collection
    {
        return $this->sdgs;
    }

    public function addSdg(Sdg $sdg): self
    {
        if (!$this->sdgs->contains($sdg)) {
            $this->sdgs[] = $sdg;
        }

        return $this;
    }

    public function removeSdg(Sdg $sdg): self
    {
        $this->sdgs->removeElement($sdg);

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setProject($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getProject() === $this) {
                $file->setProject(null);
            }
        }

        return $this;
    }
    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Gets triggered only on update
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setProject($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getProject() === $this) {
                $participant->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommonSkillsWithUser()
    {
        return $this->commonSkillsWithUser;
    }

    /**
     * @param mixed $commonSkillsWithUser
     * @return Project
     */
    public function setCommonSkillsWithUser($commonSkillsWithUser): Project
    {
        $this->commonSkillsWithUser = $commonSkillsWithUser;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDifferentSkillsFromUser()
    {
        return $this->differentSkillsFromUser;
    }

    /**
     * @param mixed $differentSkillsFromUser
     * @return Project
     */
    public function setDifferentSkillsFromUser($differentSkillsFromUser)
    {
        $this->differentSkillsFromUser = $differentSkillsFromUser;
        return $this;
    }



    public function getTchat(): ?Tchat
    {
        return $this->tchat;
    }

    public function setTchat(Tchat $tchat): self
    {
        // set the owning side of the relation if necessary
        if ($tchat->getProject() !== $this) {
            $tchat->setProject($this);
        }

        $this->tchat = $tchat;

        return $this;
    }
}
