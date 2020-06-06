<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubstanceRepository")
 */
class Substance implements Translatable
{
    /**
     * @Gedmo\Locale
     */
    private $locale;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $density;

    public function __construct()
    {
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

    public function getDensity(): ?int
    {
        return $this->density;
    }

    public function setDensity(int $density): self
    {
        $this->density = $density;

        return $this;
    }
}
