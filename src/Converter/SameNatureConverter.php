<?php


namespace App\Converter;


class SameNatureConverter extends AbstractConverter
{
    public function convert($amount)
    {
        return $amount * $this->convertFrom->getMultiplier() / $this->convertTo->getMultiplier();
    }
}