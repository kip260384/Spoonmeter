<?php


namespace App\Converter;


interface CrossNatureConverterInterface extends ConverterInterface
{
    public static function getInputNature(): string;

    public static function getOutputNature(): string;
}
