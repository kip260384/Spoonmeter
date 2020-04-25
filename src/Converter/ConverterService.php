<?php


namespace App\Converter;


use App\Entity\MeasureUnit;
use App\Entity\Substance;
use App\Repository\MeasureUnitRepository;
use App\Repository\SubstanceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConverterService
{
    /** @var EntityManagerInterface */
    private $objectManager;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function convert($substance, $amount, $from, $to)
    {
        /** @var SubstanceRepository $substanceRepo */
        $substanceRepo = $this->objectManager->getRepository(Substance::class);

        /** @var MeasureUnitRepository $unitRepo */
        $unitRepo = $this->objectManager->getRepository(MeasureUnit::class);

        /** @var Substance $substanceEntity */
        $substanceEntity = $substanceRepo->findOneBy(['name' => $substance]);

        /** @var MeasureUnit $fromEntity */
        $fromEntity = $unitRepo->findOneBy(['uniq_name' => $from]);
        /** @var MeasureUnit $fromEntity */
        $toEntity = $unitRepo->findOneBy(['uniq_name' => $to]);

        $converter = ConverterFactory::create($fromEntity, $toEntity, $substanceEntity);

        return $converter->convert($amount);
    }
}
