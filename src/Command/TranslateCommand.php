<?php


namespace App\Command;


use App\Entity\Substance;
use App\Repository\RepositoryLocatorTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateCommand extends Command
{
    use RepositoryLocatorTrait;

    protected static $defaultName = 'app:translate';

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $substances = [
            'water' => [
                'en' => 'Water',
                'ru' => 'Вода',
            ],
            'milk' => [
                'en' => 'Milk',
                'ru' => 'Молоко',
            ],
            'salt' => [
                'en' => 'Salt',
                'ru' => 'Соль',
            ],
            'sugar' => [
                'en' => 'Sugar',
                'ru' => 'Сахар',
            ],
        ];

        foreach ($substances as $name => $loc) {
            /** @var Substance $entity */
            $entity = $this->getSubstanceRepository()->findOneBy(['name' => $name]);
            foreach ($loc as $locale => $translation) {
                $entity->setTranslatableLocale($locale);
                $entity->setName($translation);
                $this->em->flush();
            }
        }


        $this->em->persist($entity);

        return 0;
    }
}
