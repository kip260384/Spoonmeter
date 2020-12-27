<?php


namespace App\Tests\Converter;


use App\Converter\ConverterFactory;
use App\Converter\SameNatureConverter;
use App\Entity\MeasureNature;
use App\Entity\MeasureUnit;
use PHPUnit\Framework\TestCase;

class ConverterFactoryTest extends TestCase
{
    public function testCreate()
    {
        $nature = new MeasureNature();
        $nature->setName('volume');
        $unitFrom = new MeasureUnit();
        $unitFrom->setNature($nature);

        $nature = new MeasureNature();
        $nature->setName('volume');
        $unitTo = new MeasureUnit();
        $unitTo->setNature($nature);

        $converter = ConverterFactory::create($unitFrom, $unitTo);

        $this->assertInstanceOf(SameNatureConverter::class, $converter);
    }
}
