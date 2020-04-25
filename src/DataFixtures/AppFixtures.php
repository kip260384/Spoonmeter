<?php

namespace App\DataFixtures;

use App\Entity\MeasureNature;
use App\Entity\MeasureUnit;
use App\Entity\Substance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->substances($manager);
        $this->units($manager);
        $manager->flush();
        $this->nature($manager);
        $manager->flush();
        $this->fillNature($manager);
        $manager->flush();

//        $manager->flush();
    }

    private function substances(ObjectManager $manager)
    {
        $rows = [
            ['name' => 'water', 'density' => 998000],
            ['name' => 'sugar', 'density' => 845350],
            ['name' => 'salt', 'density' => 2170000],
            ['name' => 'milk', 'density' => 1030000],
        ];

        foreach ($rows as $row) {
            $s = new Substance();
            $s->setName($row['name']);
            $s->setDensity($row['density']);
            $manager->persist($s);
        }
    }

    private function units(ObjectManager $manager)
    {
        $rows = [
            ['uniq_name' => 'g', 'short_name' => 'g', 'name' => 'Gram', 'multiplier' => 1,],
            ['uniq_name' => 'kg', 'short_name' => 'kg', 'name' => 'Kilogram', 'multiplier' => 1000,],
            ['uniq_name' => 'm3', 'short_name' => 'm3', 'name' => 'Cube metre', 'multiplier' => 1,],
            ['uniq_name' => 'l', 'short_name' => 'l', 'name' => 'Litre', 'multiplier' => 0.001,],
            ['uniq_name' => 'ml', 'short_name' => 'ml', 'name' => 'Millilitre', 'multiplier' => 0.000001,],
            ['uniq_name' => 'gls_250', 'short_name' => 'gls_250', 'name' => 'Glass 250ml', 'multiplier' => 0.00025,],
        ];

        foreach ($rows as $row) {
            $s = new MeasureUnit();
            $s->setUniqName($row['uniq_name']);
            $s->setShortName($row['short_name']);
            $s->setName($row['name']);
            $s->setMultiplier($row['multiplier']);
            $manager->persist($s);
        }
    }

    private function nature(ObjectManager $manager)
    {
        $r = $manager->getRepository(MeasureUnit::class);

        $s = new MeasureNature();
        $s->setName('weight');
        $s->setBaseUnit($r->findOneBy(['name' => 'Gram']));
        $manager->persist($s);

        $s = new MeasureNature();
        $s->setName('volume');
        $s->setBaseUnit($r->findOneBy(['name' => 'Cube metre']));
        $manager->persist($s);
    }

    public function fillNature(ObjectManager $manager)
    {
        $r = $manager->getRepository(MeasureUnit::class);
        $mnr = $manager->getRepository(MeasureNature::class);

        $volume = ['Cube metre', 'Millilitre', 'Litre', 'Glass 250ml'];
        $weight = ['Gram', 'Kilogram'];

        $nature = $mnr->findOneBy(['name' => 'volume']);
        foreach ($volume as $name) {
            /** @var MeasureUnit $entity */
            $entity = $r->findOneBy(['name' => $name]);
            $entity->setNature($nature);
            $manager->persist($entity);
        }

        $nature = $mnr->findOneBy(['name' => 'weight']);
        foreach ($weight as $name) {
            /** @var MeasureUnit $entity */
            $entity = $r->findOneBy(['name' => $name]);
            $entity->setNature($nature);
            $manager->persist($entity);
        }
    }
}
