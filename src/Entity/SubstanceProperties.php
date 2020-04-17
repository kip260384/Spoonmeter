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
     * @ORM\ManyToOne(targetEntity="App\Entity\Substance", inversedBy="aggregation_state_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $substance_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AggregationState")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregation_state_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $density;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubstanceId(): ?Substance
    {
        return $this->substance_id;
    }

    public function setSubstanceId(?Substance $substance_id): self
    {
        $this->substance_id = $substance_id;

        return $this;
    }

    public function getAggregationStateId(): ?AggregationState
    {
        return $this->aggregation_state_id;
    }

    public function setAggregationStateId(?AggregationState $aggregation_state_id): self
    {
        $this->aggregation_state_id = $aggregation_state_id;

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
