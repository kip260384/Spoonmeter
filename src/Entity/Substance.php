<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubstanceRepository")
 */
class Substance
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubstanceProperties", mappedBy="substance", orphanRemoval=true)
     */
    private $substanceProperties;

    public function __construct()
    {
        $this->substanceProperties = new ArrayCollection();
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

    /**
     * @return Collection|SubstanceProperties[]
     */
    public function getSubstanceProperties(): Collection
    {
        return $this->substanceProperties;
    }

    public function addSubstanceProperty(SubstanceProperties $substanceProperty): self
    {
        if (!$this->substanceProperties->contains($substanceProperty)) {
            $this->substanceProperties[] = $substanceProperty;
            $substanceProperty->setSubstance($this);
        }

        return $this;
    }

    public function removeSubstanceProperty(SubstanceProperties $substanceProperty): self
    {
        if ($this->substanceProperties->contains($substanceProperty)) {
            $this->substanceProperties->removeElement($substanceProperty);
            // set the owning side to null (unless already changed)
            if ($substanceProperty->getSubstance() === $this) {
                $substanceProperty->setSubstance(null);
            }
        }

        return $this;
    }
}
