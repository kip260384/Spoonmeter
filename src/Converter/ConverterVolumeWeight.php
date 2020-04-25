<?php


namespace App\Converter;


class ConverterVolumeWeight extends AbstractCrossNatureConverter
{
    const INPUT_NATURE = 'volume';
    const OUTPUT_NATURE = 'weight';

    public function convert($amount)
    {
        $density = $this->substance->getDensity();

        $amount = $amount * $this->convertFrom->getMultiplier();
        $convertedAmount = $amount * $density;
        $targetAmount = $convertedAmount / $this->convertTo->getMultiplier();

        return $targetAmount;
    }
}