<?php


namespace App\Converter;


use App\Entity\MeasureUnit;
use App\Entity\Substance;
use App\Repository\RepositoryLocatorTrait;
use Doctrine\ORM\EntityManagerInterface;

class ConverterService
{
    use RepositoryLocatorTrait;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->em = $objectManager;
    }

    public function convert($substance, $amount, $from, $to)
    {
        /** @var Substance $substanceEntity */
        $substanceEntity = $this->getSubstanceRepository()->find($substance);

        /** @var MeasureUnit $fromEntity */
        $fromEntity = $this->getUnitRepository()->find($from);
        /** @var MeasureUnit $fromEntity */
        $toEntity = $this->getUnitRepository()->find($to);

        $converter = ConverterFactory::create($fromEntity, $toEntity, $substanceEntity);

        return $converter->convert($amount);
    }
}
