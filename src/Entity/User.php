<?php

namespace App\Entity;

use _HumbugBoxec8571fe8659\Symfony\Component\Finder\Exception\AccessDeniedException;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @UniqueEntity(fields={"organization"}, message="There can be only one account per organization")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="The email field is not valid")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="The firstname {{ value }} is too long,
     * shouln't exceed {{ limit }} characters")
     * @Assert\Regex(pattern = "/^[a-z]+$/i", htmlPattern = "[a-zA-Z]+", message = "no special characters")

     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="The lastname {{ value }} is too long,
     * shouln't exceed {{ limit }} characters")
     * @Assert\Regex(pattern = "/^[a-z]+$/i", htmlPattern = "[a-zA-Z]+", message = "no special characters")
     */
    private $lastname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Organization::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $organization;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="users")
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="users", cascade={"persist"})
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity=Task::class, inversedBy="users")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="user")
     */
    private $files;

    /**
     * @ORM\ManyToMany(targetEntity=Accomplishment::class, inversedBy="users")
     */
    private $accomplishments;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="receiver", orphanRemoval=true)
     */
    private $receivedMessages;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender", orphanRemoval=true)
     */
    private $sentMessages;

    /**
     * @ORM\OneToMany(targetEntity=Recommendation::class, mappedBy="sender")
     */
    private $sentRecommendations;

    /**
     * @ORM\OneToMany(targetEntity=Recommendation::class, mappedBy="receiver", orphanRemoval=true)
     */
    private $receivedRecommendations;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="user")
     */
    private $participants;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = 1;

    /**
     * @ORM\ManyToMany(targetEntity=Tchat::class, mappedBy="users")
     */
    private $tchats;

    /**
     * @ORM\OneToMany(targetEntity=TchatMessage::class, mappedBy="speaker")
     */
    private $tchatMessages;

    /**
     * @ORM\OneToOne(targetEntity=Avatar::class, mappedBy="owner", cascade={"persist", "remove"})
     * @Assert\Type(type="App\Entity\Avatar")
     * @Assert\Valid
     */
    private ?Avatar $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="receiver", orphanRemoval=true)
     */
    private $notifications;

    public function __toString()
    {
        return $this->firstname;
    }

    /*
    public function __toString(): string
    {
        return $this->getEmail();
    }
    */

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->accomplishments = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->sentMessages = new ArrayCollection();
        $this->sentRecommendations = new ArrayCollection();
        $this->receivedRecommendations = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->tchats = new ArrayCollection();
        $this->tchatMessages = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function hasRecommendationOnThisProject(Project $project): bool
    {
        $hasRecommendationOnThisProject = false;
        $receivedRecommendations = $this->getReceivedRecommendations();
        foreach ($receivedRecommendations as $receivedRecommendation) {
            if ($receivedRecommendation->getProject() === $project) {
                $hasRecommendationOnThisProject = true;
            }
        }

        return $hasRecommendationOnThisProject;
    }

    public function getFullNameIfMemberOrONG(): string
    {
        $fullName = $this->getFirstname() . ' ' . $this->getLastname();
        if ($this->getOrganization()) {
            $fullName = $this->getOrganization()->getName();
        }
        return $fullName;
    }

    public function getFirstnameAndLastname()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    public function isParticipantOn(Project $project): bool
    {
        $isParticipant = false;
        $participations = $project->getParticipants();
        foreach ($participations as $participation) {
            if ($this === $participation->getUser()) {
                $isParticipant = true;
            }
        }
        return $isParticipant;
    }

    public function getParticipationOn(Project $project): Participant
    {
        $participants = $project->getParticipants();

        foreach ($participants as $participant) {
            if ($this === $participant->getUser()) {
                return $participant;
            }
        }
    }

    public function getProjectRoleMessage(Project $project): string
    {
        $projectRole = '';
        $projectRoleMessage = '';
        $participations = $project->getParticipants();
        foreach ($participations as $participation) {
            if ($this === $participation->getUser()) {
                $projectRole = $participation->getRole();
            }
        }
        switch ($projectRole) {
            case Participant::ROLE_WAITING_VOLUNTEER:
                $projectRoleMessage = Participant::MESSAGE_FOR_WAITING_VOLUNTEER;
                break;
            case Participant::ROLE_VOLUNTEER:
                $projectRoleMessage = Participant::MESSAGE_FOR_VOLUNTEER;
                break;
            case Participant::ROLE_PROJECT_OWNER:
                $projectRoleMessage = Participant::MESSAGE_FOR_PROJECT_OWNER;
                break;
            case Participant::ROLE_ORGANIZATION:
                $projectRoleMessage = Participant::MESSAGE_FOR_ORGANIZATION;
                break;
        }
        return $projectRoleMessage;
    }

    public function hasRoles($searchedRole): bool
    {
        $hasRole = false;
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            if ($role === $searchedRole) {
                $hasRole = true;
            }
        }
        return $hasRole;
    }


    public function addRole(string $role)
    {
        return ($this->roles[] = $role);
    }

    public function removeRole($role): self
    {
        $this->roles = array_diff($this->roles, [$role]);
        return $this;
    }

    public function hasRoleAdmin(): bool
    {
        return $this->hasRoles('ROLE_ADMIN');
    }

    public function setHasRoleAdmin($isAdmin)
    {
        if (true === $isAdmin && false === $this->hasRoles('ROLE_ADMIN')) {
            $this->addRole('ROLE_ADMIN');
        }
        if (false === $isAdmin && true == $this->hasRoles('ROLE_ADMIN')) {
            $this->removeRole('ROLE_ADMIN');
        }
        $this->isAdmin = $isAdmin;
    }

    public function getId(): ?int
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
     * @see UserInterface
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

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

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

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
        $this->skills->add($skill);

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

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
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);

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
            $file->setUser($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getUser() === $this) {
                $file->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Accomplishment[]
     */
    public function getAccomplishments(): Collection
    {
        return $this->accomplishments;
    }

    public function addAccomplishment(Accomplishment $accomplishment): self
    {
        if (!$this->accomplishments->contains($accomplishment)) {
            $this->accomplishments[] = $accomplishment;
        }

        return $this;
    }

    public function removeAccomplishment(Accomplishment $accomplishment): self
    {
        $this->accomplishments->removeElement($accomplishment);

        return $this;
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
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $receivedMessage): self
    {
        if (!$this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages[] = $receivedMessage;
            $receivedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): self
    {
        if ($this->receivedMessages->removeElement($receivedMessage)) {
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getReceiver() === $this) {
                $receivedMessage->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getSentMessages(): Collection
    {
        return $this->sentMessages;
    }

    public function addSentMessage(Message $sentMessage): self
    {
        if (!$this->sentMessages->contains($sentMessage)) {
            $this->sentMessages[] = $sentMessage;
            $sentMessage->setSender($this);
        }

        return $this;
    }

    public function removeSentMessage(Message $sentMessage): self
    {
        if ($this->sentMessages->removeElement($sentMessage)) {
            // set the owning side to null (unless already changed)
            if ($sentMessage->getSender() === $this) {
                $sentMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recommendation[]
     */
    public function getSentRecommendations(): Collection
    {
        return $this->sentRecommendations;
    }

    public function addSentRecommendation(Recommendation $sentRecommendation): self
    {
        if (!$this->sentRecommendations->contains($sentRecommendation)) {
            $this->sentRecommendations[] = $sentRecommendation;
            $sentRecommendation->setSender($this);
        }

        return $this;
    }

    public function removeSentRecommendation(Recommendation $sentRecommendation): self
    {
        if ($this->sentRecommendations->removeElement($sentRecommendation)) {
            // set the owning side to null (unless already changed)
            if ($sentRecommendation->getSender() === $this) {
                $sentRecommendation->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recommendation[]
     */
    public function getReceivedRecommendations(): Collection
    {
        return $this->receivedRecommendations;
    }

    public function addReceivedRecommendation(Recommendation $receivedRecommendation): self
    {
        if (!$this->receivedRecommendations->contains($receivedRecommendation)) {
            $this->receivedRecommendations[] = $receivedRecommendation;
            $receivedRecommendation->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedRecommendation(Recommendation $receivedRecommendation): self
    {
        if ($this->receivedRecommendations->removeElement($receivedRecommendation)) {
            // set the owning side to null (unless already changed)
            if ($receivedRecommendation->getReceiver() === $this) {
                $receivedRecommendation->setReceiver(null);
            }
        }

        return $this;
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
            $participant->setUser($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getUser() === $this) {
                $participant->setUser(null);
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
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {

        $this->isActive = $isActive;
    }

    /**
     * @return Collection|Tchat[]
     */
    public function getTchats(): Collection
    {
        return $this->tchats;
    }

    public function addTchat(Tchat $tchat): self
    {
        if (!$this->tchats->contains($tchat)) {
            $this->tchats[] = $tchat;
            $tchat->addUser($this);
        }

        return $this;
    }

    public function removeTchat(Tchat $tchat): self
    {
        if ($this->tchats->removeElement($tchat)) {
            $tchat->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|TchatMessage[]
     */
    public function getTchatMessages(): Collection
    {
        return $this->tchatMessages;
    }

    public function addTchatMessage(TchatMessage $tchatMessage): self
    {
        if (!$this->tchatMessages->contains($tchatMessage)) {
            $this->tchatMessages[] = $tchatMessage;
            $tchatMessage->setSpeaker($this);
        }

        return $this;
    }

    public function removeTchatMessage(TchatMessage $tchatMessage): self
    {
        if ($this->tchatMessages->removeElement($tchatMessage)) {
            // set the owning side to null (unless already changed)
            if ($tchatMessage->getSpeaker() === $this) {
                $tchatMessage->setSpeaker(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar): self
    {
        // set the owning side of the relation if necessary
        if ($avatar->getOwner() !== $this) {
            $avatar->setOwner($this);
        }

        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setReceiver($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getReceiver() === $this) {
                $notification->setReceiver(null);
            }
        }

        return $this;
    }
}
