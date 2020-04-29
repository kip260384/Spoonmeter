<?php


namespace App\Repository;


use App\Entity\MeasureUnit;
use App\Entity\Substance;
use Doctrine\ORM\EntityManagerInterface;

trait RepositoryLocatorTrait
{
    /** @var EntityManagerInterface */
    private $em;

    protected function getUnitRepository(): MeasureUnitRepository
    {
        return $this->em->getRepository(MeasureUnit::class);
    }

    protected function getSubstanceRepository(): SubstanceRepository
    {
        return $this->em->getRepository(Substance::class);
    }
}
