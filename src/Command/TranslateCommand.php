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
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Reader\TranslationReaderInterface;
use Symfony\Component\Translation\Writer\TranslationWriterInterface;

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

    /** @var TranslationReaderInterface */
    private $reader;

    /** @var TranslationWriterInterface */
    private $writer;

    public function __construct(
        EntityManagerInterface $em,
        TranslateClient $translator,
        $supportedLocales,
        TranslationReaderInterface $reader,
        TranslationWriterInterface $writer,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->em = $em;
        $this->translator = $translator;
        $this->supportedLocales = $supportedLocales;
        $this->reader = $reader;
        $this->writer = $writer;

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

        $enCatalogue = new MessageCatalogue('en');
        $this->reader->read('translations', $enCatalogue);
        $this->translateMessages($enCatalogue);

        $this->logger->info('Substances');
        $entities = $this->getSubstanceRepository()->findAll();
        $this->translateEntities($entities, 'getName');

        $this->logger->info('Units');
        $entities = $this->getUnitRepository()->findAll();
        $this->translateEntities($entities, 'getName');

        $this->logger->info('End');
        $this->release();
        return 0;
    }

    private function mb_ucfirst(string $text): string
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    private function translateEntities($entities, $nameGetter)
    {
        foreach ($this->supportedLocales as $locale) {
            if ('en' == $locale) {
                continue;
            }
            $this->logger->info('Translating entities to '.$locale);

            $batch = [];
            $subsWoTrans = [];
            foreach ($entities as $entity) {
                $entity->setTranslatableLocale('en');
                $this->em->refresh($entity);
                $existingTranslations = $this->tr->findTranslations($entity);
                if (!array_key_exists($locale, $existingTranslations)) {
                    $batch[] = $entity->$nameGetter();
                    $subsWoTrans[] = $entity;
                }
            }

            if (0 == count($batch)) {
                $this->logger->debug('All entities already translated');
                continue;
            }

            $translations = [];
            if ($locale == 'en') {
                foreach ($batch as $name) {
                    $translations[] = ['text' => ucfirst($name), 'input' => $name];
                }
            } else {
                $translations = $this->translator->translateBatch($batch, [
                    'source' => 'en',
                    'target' => $locale,
                ]);
            }

            $inputColumn = array_column($translations, 'input');
            foreach ($subsWoTrans as $key => $entity) {
                $entity->setTranslatableLocale($locale);
                $this->em->refresh($entity);
                $k = array_search($batch[$key], $inputColumn);
                $text = $translations[$k]['text'] ?? null;
                if ($text) {
                    $entity->setName($this->mb_ucfirst($text));
                    $this->em->persist($entity);
                }
            }
            $this->em->flush();
        }
    }

    private function translateMessages(MessageCatalogue $enCatalogue)
    {
        foreach ($this->supportedLocales as $locale) {
            if ('en' == $locale) {
                continue;
            }

            $this->logger->info('Translating messages to ' . $locale);
            $localeCatalogue = new MessageCatalogue($locale);
            $this->reader->read('translations', $localeCatalogue);

            $enMessages = $enCatalogue->all('messages');
            $localeMessages = $localeCatalogue->all('messages');

            $batch = array_diff_key($enMessages, $localeMessages);

            if (!$batch) {
                $this->logger->info('Nothing to translate');
                continue;
            }

            $translations = $this->translator->translateBatch(array_values($batch), [
                'source' => 'en',
                'target' => $locale,
            ]);

            $batchKeys = array_keys($batch);
            foreach ($batchKeys as $k => $key) {
                $str = $translations[$k]['text'] ?? null;
                if ($str) {
                    $str = $this->mb_ucfirst($str);
                    $batch[$key] = $str;
                } else {
                    unset($batch[$key]);
                }
            }

            $localeCatalogue->add($batch);
            $this->writer->write($localeCatalogue, 'yaml', ['path' => 'translations']);
        }
    }
}
