<?php


namespace App\Converter;


use Doctrine\Persistence\ObjectManager;

class ConverterBuilder
{
    /** @var ObjectManager */
    private $dbManager;

    public function __construct(ObjectManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    public function build($substance, $from, $to)
    {

    }
}
