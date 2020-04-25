<?php


namespace App\Converter;


use App\Entity\MeasureUnit;

abstract class AbstractConverter implements ConverterInterface
{
    /** @var MeasureUnit */
    protected $convertFrom;

    /** @var MeasureUnit */
    protected $convertTo;

    public function __construct(MeasureUnit $convertFrom, MeasureUnit $convertTo)
    {
        $this->convertFrom = $convertFrom;
        $this->convertTo = $convertTo;
    }
}
