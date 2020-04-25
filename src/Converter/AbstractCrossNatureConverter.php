<?php


namespace App\Converter;


use App\Entity\MeasureUnit;
use App\Entity\Substance;

abstract class AbstractCrossNatureConverter extends AbstractConverter implements CrossNatureConverterInterface
{
    protected const INPUT_NATURE = null;
    protected const OUTPUT_NATURE = null;

    /** @var Substance */
    protected $substance;

    public function __construct(Substance $substance, MeasureUnit $convertFrom, MeasureUnit $convertTo)
    {
        $this->substance = $substance;
        parent::__construct($convertFrom, $convertTo);
    }

    public static function getInputNature(): string
    {
        return static::INPUT_NATURE;
    }

    public static function getOutputNature(): string
    {
        return static::OUTPUT_NATURE;
    }
}
