<?php

namespace App\Entity;

use App\Repository\HomeContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeContentRepository::class)
 */
class HomeContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $introTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $introContent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $section1Title;

    /**
     * @ORM\Column(type="text")
     */
    private $section1Content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $section2Title;

    /**
     * @ORM\Column(type="text")
     */
    private $section2Content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $section3Title;

    /**
     * @ORM\Column(type="text")
     */
    private $section3Intro;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $section3Video1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $section3video2;

    /**
     * @ORM\Column(type="text")
     */
    private $section3Video1Content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $section3Video2Content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntroTitle(): ?string
    {
        return $this->introTitle;
    }

    public function setIntroTitle(string $introTitle): self
    {
        $this->introTitle = $introTitle;

        return $this;
    }

    public function getIntroContent(): ?string
    {
        return $this->introContent;
    }

    public function setIntroContent(string $introContent): self
    {
        $this->introContent = $introContent;

        return $this;
    }

    public function getSection1Title(): ?string
    {
        return $this->section1Title;
    }

    public function setSection1Title(string $section1Title): self
    {
        $this->section1Title = $section1Title;

        return $this;
    }

    public function getSection1Content(): ?string
    {
        return $this->section1Content;
    }

    public function setSection1Content(string $section1Content): self
    {
        $this->section1Content = $section1Content;

        return $this;
    }

    public function getSection2Title(): ?string
    {
        return $this->section2Title;
    }

    public function setSection2Title(string $section2Title): self
    {
        $this->section2Title = $section2Title;

        return $this;
    }

    public function getSection2Content(): ?string
    {
        return $this->section2Content;
    }

    public function setSection2Content(string $section2Content): self
    {
        $this->section2Content = $section2Content;

        return $this;
    }

    public function getSection3Title(): ?string
    {
        return $this->section3Title;
    }

    public function setSection3Title(string $section3Title): self
    {
        $this->section3Title = $section3Title;

        return $this;
    }

    public function getSection3Intro(): ?string
    {
        return $this->section3Intro;
    }

    public function setSection3Intro(string $section3Intro): self
    {
        $this->section3Intro = $section3Intro;

        return $this;
    }

    public function getSection3Video1(): ?string
    {
        return $this->section3Video1;
    }

    public function setSection3Video1(string $section3Video1): self
    {
        $this->section3Video1 = $section3Video1;

        return $this;
    }

    public function getSection3video2(): ?string
    {
        return $this->section3video2;
    }

    public function setSection3video2(?string $section3video2): self
    {
        $this->section3video2 = $section3video2;

        return $this;
    }

    public function getSection3Video1Content(): ?string
    {
        return $this->section3Video1Content;
    }

    public function setSection3Video1Content(string $section3Video1Content): self
    {
        $this->section3Video1Content = $section3Video1Content;

        return $this;
    }

    public function getSection3Video2Content(): ?string
    {
        return $this->section3Video2Content;
    }

    public function setSection3Video2Content(?string $section3Video2Content): self
    {
        $this->section3Video2Content = $section3Video2Content;

        return $this;
    }
}
