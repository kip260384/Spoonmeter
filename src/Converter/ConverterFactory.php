<?php


namespace App\Converter;


use App\Entity\MeasureUnit;
use App\Entity\Substance;
use Exception;

class ConverterFactory
{
    const REGISTERED_CONVERTERS = [
        ConverterWeightVolume::class,
        ConverterVolumeWeight::class,
    ];

    /**
     * @param MeasureUnit $convertFrom
     * @param MeasureUnit $convertTo
     * @param Substance|null $substance
     * @return ConverterInterface
     * @throws Exception
     */
    public static function create(MeasureUnit $convertFrom, MeasureUnit $convertTo, Substance $substance = null): ConverterInterface
    {
        if ($convertFrom->getNature() === $convertTo->getNature()) {
            return new SameNatureConverter($convertFrom, $convertTo);
        }

        $inputNature = $convertFrom->getNature()->getName();
        $outputNature = $convertTo->getNature()->getName();

        /** @var CrossNatureConverterInterface $converterClass */
        foreach (self::REGISTERED_CONVERTERS as $converterClass) {
            if ($converterClass::getInputNature() === $inputNature && $converterClass::getOutputNature() === $outputNature) {
                return new $converterClass($substance, $convertFrom, $convertTo);
            }
        }

        throw new Exception('Converter was not found');
    }
}
