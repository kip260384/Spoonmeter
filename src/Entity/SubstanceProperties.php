<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubstancePropertiesRepository")
 */
class SubstanceProperties
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Substance", inversedBy="substanceProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $substance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AggregationState", inversedBy="substanceProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregation_state;

    /**
     * @ORM\Column(type="float")
     */
    private $density;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubstance(): ?Substance
    {
        return $this->substance;
    }

    public function setSubstance(?Substance $substance): self
    {
        $this->substance = $substance;

        return $this;
    }

    public function getAggregationState(): ?AggregationState
    {
        return $this->aggregation_state;
    }

    public function setAggregationState(?AggregationState $aggregation_state): self
    {
        $this->aggregation_state = $aggregation_state;

        return $this;
    }

    public function getDensity(): ?float
    {
        return $this->density;
    }

    public function setDensity(float $density): self
    {
        $this->density = $density;

        return $this;
    }
}
