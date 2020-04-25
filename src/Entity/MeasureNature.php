<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeasureNatureRepository")
 */
class MeasureNature
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MeasureUnit", mappedBy="nature")
     */
    private $measureUnits;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MeasureUnit", inversedBy="measureNature", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $base_unit;

    public function __construct()
    {
        $this->measureUnits = new ArrayCollection();
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
     * @return Collection|MeasureUnit[]
     */
    public function getMeasureUnits(): Collection
    {
        return $this->measureUnits;
    }

    public function addMeasureUnit(MeasureUnit $measureUnit): self
    {
        if (!$this->measureUnits->contains($measureUnit)) {
            $this->measureUnits[] = $measureUnit;
            $measureUnit->setNature($this);
        }

        return $this;
    }

    public function removeMeasureUnit(MeasureUnit $measureUnit): self
    {
        if ($this->measureUnits->contains($measureUnit)) {
            $this->measureUnits->removeElement($measureUnit);
            // set the owning side to null (unless already changed)
            if ($measureUnit->getNature() === $this) {
                $measureUnit->setNature(null);
            }
        }

        return $this;
    }

    public function getBaseUnit(): ?MeasureUnit
    {
        return $this->base_unit;
    }

    public function setBaseUnit(MeasureUnit $base_unit): self
    {
        $this->base_unit = $base_unit;

        return $this;
    }
}
