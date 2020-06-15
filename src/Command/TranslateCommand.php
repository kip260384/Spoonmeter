<?php


namespace App\Command;


use App\Repository\RepositoryLocatorTrait;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Google\Cloud\Translate\V2\TranslateClient;

class TranslateCommand extends Command implements LoggerAwareInterface
{
    use RepositoryLocatorTrait, LoggerAwareTrait, LockableTrait;

    protected static $defaultName = 'app:translate';

    /** @var EntityManagerInterface */
    private $em;

    /** @var TranslationRepository */
    private $tr;

    /** @var TranslateClient */
    private $translator;

    private $supportedLocales;

    public function __construct(
        EntityManagerInterface $em,
        TranslateClient $translator,
        $supportedLocales,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->em = $em;
        $this->translator = $translator;
        $this->supportedLocales = $supportedLocales;

        /** @var TranslationRepository $repository */
        $translationRepository = $this->em->getRepository('Gedmo\\Translatable\\Entity\\Translation');
        $this->tr = $translationRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $this->logger->warning('The command is already running in another process.');

            return 0;
        }
        $this->logger->info('Start');

        $substances = $this->getSubstanceRepository()->findAll();

        foreach ($this->supportedLocales as $locale) {
            $this->logger->info('Translating to '.$locale);

            $substancesBatch = [];
            $subsWoTrans = [];
            foreach ($substances as $substance) {
                $substance->setTranslatableLocale('en');
                $this->em->refresh($substance);
                $existingTranslations = $this->tr->findTranslations($substance);
                if (!array_key_exists($locale, $existingTranslations)) {
                    $substancesBatch[] = $substance->getName();
                    $subsWoTrans[] = $substance;
                }
            }

            if (0 == count($substancesBatch)) {
                $this->logger->debug('All entities already translated');
                continue;
            }

            $translations = [];
            if ($locale == 'en') {
                foreach ($substancesBatch as $name) {
                    $translations[] = ['text' => ucfirst($name), 'input' => $name];
                }
            } else {
                $translations = $this->translator->translateBatch($substancesBatch, [
                    'source' => 'en',
                    'target' => $locale,
                ]);
            }

            $inputColumn = array_column($translations, 'input');
            foreach ($subsWoTrans as $key => $substance) {
                $substance->setTranslatableLocale($locale);
                $this->em->refresh($substance);
                $k = array_search($substancesBatch[$key], $inputColumn);
                $text = $translations[$k]['text'] ?? null;
                if ($text) {
                    $substance->setName($this->mb_ucfirst($text));
                    $this->em->persist($substance);
                }
            }
            $this->em->flush();
        }

        $this->logger->info('End');
        $this->release();
        return 0;
    }

    private function mb_ucfirst(string $text): string
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
}
