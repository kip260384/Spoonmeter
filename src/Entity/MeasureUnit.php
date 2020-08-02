<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeasureUnitRepository")
 */
class MeasureUnit implements Translatable
{
    /**
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $uniq_name;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $short_name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=16)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MeasureNature", inversedBy="measureUnits")
     */
    private $nature;

    /**
     * @ORM\Column(type="float")
     */
    private $multiplier;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MeasureNature", mappedBy="base_unit", cascade={"persist", "remove"})
     */
    private $measureNature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqName(): ?string
    {
        return $this->uniq_name;
    }

    public function setUniqName(string $uniq_name): self
    {
        $this->uniq_name = $uniq_name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): self
    {
        $this->short_name = $short_name;

        return $this;
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

    public function getNature(): ?MeasureNature
    {
        return $this->nature;
    }

    public function setNature(?MeasureNature $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getMultiplier(): ?float
    {
        return $this->multiplier;
    }

    public function setMultiplier(float $multiplier): self
    {
        $this->multiplier = $multiplier;

        return $this;
    }

    public function getMeasureNature(): ?MeasureNature
    {
        return $this->measureNature;
    }

    public function setMeasureNature(MeasureNature $measureNature): self
    {
        $this->measureNature = $measureNature;

        // set the owning side of the relation if necessary
        if ($measureNature->getBaseUnit() !== $this) {
            $measureNature->setBaseUnit($this);
        }

        return $this;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}
