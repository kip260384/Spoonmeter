<?php


namespace App\Converter;


class ConverterWeightVolume extends AbstractCrossNatureConverter
{
    const INPUT_NATURE = 'weight';
    const OUTPUT_NATURE = 'volume';

    public function convert($amount)
    {
        $density = $this->substance->getDensity();

        $amount = $amount * $this->convertFrom->getMultiplier();
        $convertedAmount = $amount / $density;
        $targetAmount = $convertedAmount / $this->convertTo->getMultiplier();

        return $targetAmount;
    }
}
