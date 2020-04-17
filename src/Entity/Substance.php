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
     * @ORM\OneToMany(targetEntity="App\Entity\SubstanceProperties", mappedBy="substance_id", orphanRemoval=true)
     */
    private $aggregation_state_id;

    public function __construct()
    {
        $this->aggregation_state_id = new ArrayCollection();
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
    public function getAggregationStateId(): Collection
    {
        return $this->aggregation_state_id;
    }

    public function addAggregationStateId(SubstanceProperties $aggregationStateId): self
    {
        if (!$this->aggregation_state_id->contains($aggregationStateId)) {
            $this->aggregation_state_id[] = $aggregationStateId;
            $aggregationStateId->setSubstanceId($this);
        }

        return $this;
    }

    public function removeAggregationStateId(SubstanceProperties $aggregationStateId): self
    {
        if ($this->aggregation_state_id->contains($aggregationStateId)) {
            $this->aggregation_state_id->removeElement($aggregationStateId);
            // set the owning side to null (unless already changed)
            if ($aggregationStateId->getSubstanceId() === $this) {
                $aggregationStateId->setSubstanceId(null);
            }
        }

        return $this;
    }
}
