<?php

namespace App\DataFixtures;

use App\Entity\AggregationState;
use App\Entity\Substance;
use App\Entity\SubstanceProperties;
use App\Entity\Volume;
use App\Entity\VolumeSubject;
use App\Entity\Weight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->substances($manager);
        $this->aggregationState($manager);
        $this->weight($manager);
        $this->volume($manager);
        $this->volumeSubject($manager);
        $manager->flush();

//        $this->substanceProperties($manager);
//        $manager->flush();
    }

    private function substances(ObjectManager $manager)
    {
        $rows = [
            'water', 'sugar', 'salt'
        ];

        foreach ($rows as $row) {
            $s = new Substance();
            $s->setName($row);
            $manager->persist($s);
        }
    }

    private function aggregationState(ObjectManager $manager)
    {
        $rows = [
            'liquid', 'solid', 'powder'
        ];

        foreach ($rows as $row) {
            $s = new AggregationState();
            $s->setName($row);
            $manager->persist($s);
        }
    }

    private function volume(ObjectManager $manager)
    {
        $rows = [
            ['name' => 'Millilitre', 'short_name' => 'ml', 'ml' => 1],
            ['name' => 'Liter', 'short_name' => 'l', 'ml' => 1000],
        ];

        foreach ($rows as $row) {
            $s = new Volume();
            $s->setName($row['name']);
            $s->setShortName($row['short_name']);
            $s->setMl($row['ml']);
            $manager->persist($s);
        }
    }

    private function weight(ObjectManager $manager)
    {
        $rows = [
            ['name' => 'Milligram', 'short_name' => 'mg', 'mg' => 1],
            ['name' => 'Kilogram', 'short_name' => 'kg', 'mg' => 1000000],
            ['name' => 'Gram', 'short_name' => 'g', 'mg' => 1000],
        ];

        foreach ($rows as $row) {
            $s = new Weight();
            $s->setName($row['name']);
            $s->setShortName($row['short_name']);
            $s->setMg($row['mg']);
            $manager->persist($s);
        }
    }

    private function volumeSubject(ObjectManager $manager)
    {
        $rows = [
            ['name' => 'Tea Spoon', 'volume' => 4.92892],
            ['name' => 'Table Spoon', 'volume' => 14.7868],
            ['name' => 'Glass 250ml', 'volume' => 250],
        ];

        foreach ($rows as $row) {
            $s = new VolumeSubject();
            $s->setName($row['name']);
            $s->setVolume($row['volume']);
            $manager->persist($s);
        }
    }

    private function substanceProperties(ObjectManager $manager)
    {
        $sp = new SubstanceProperties();
        $r = $manager->getRepository(Substance::class);
        $s = $r->find(1);
        $sp->setSubstance($s);

        $r = $manager->getRepository(AggregationState::class);
        $s = $r->find(1);
        $sp->setAggregationState($s);

//        kg/m3
        $sp->setDensity(997);
        $manager->persist($sp);
    }
}
