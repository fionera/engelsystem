<?php

namespace Engelsystem\EventSubscriber;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\EventConfig;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Twig\Environment;

class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RequestSubscriber constructor.
     * @param Environment $environment
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Environment $environment, EntityManagerInterface $entityManager)
    {
        $this->environment = $environment;
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $config = [
            'theme' => getenv('DEFAULT_THEME'),
            'locales' => $this->getAvailableLanguages()
//            'atom_link' => ($page == 'news' || $page == 'user_meetings')
//                ? ' <link href="'
//                . page_link_to('atom', $parameters)
//                . '" type = "application/atom+xml" rel = "alternate" title = "Atom Feed">'
//                : '',
//            'start_page_url' => page_link_to('/'),
//            'credits_url' => page_link_to('credits'),
//            'menu' => make_menu(),
//            'content' => msg() . $content,
//            'header_toolbar' => header_toolbar(),
//            'faq_url' => config('faq_url'),
//            'contact_email' => config('contact_email'),
//            'locale' => locale(),
//            'event_info' => EventConfig_info($event_config) . ' <br />'
        ];

        /** @var EventConfig|null $eventConfig */
        $eventConfig = $this->entityManager->getRepository(EventConfig::class)->find(getenv('EVENT_ID'));

        if ($eventConfig !== null) {
            $config['eventConfig'] = [
                'name' => $eventConfig->getEventName(),
                'startDate' => $eventConfig->getEventStartDate(),
                'endDate' => $eventConfig->getEventEndDate(),
            ];
        }

        foreach ($config as $key => $value) {
            $this->environment->addGlobal($key, $value);
        }

//        echo view(__DIR__ . '/../templates/layout.html', [
//            'theme'          => isset($user) ? $user['color'] : config('theme'),
//            'title'          => $title,
//            'atom_link'      => ($page == 'news' || $page == 'user_meetings')
//                ? ' <link href="'
//                . page_link_to('atom', $parameters)
//                . '" type = "application/atom+xml" rel = "alternate" title = "Atom Feed">'
//                : '',
//            'start_page_url' => page_link_to('/'),
//            'credits_url'    => page_link_to('credits'),
//            'menu'           => make_menu(),
//            'content'        => msg() . $content,
//            'header_toolbar' => header_toolbar(),
//            'faq_url'        => config('faq_url'),
//            'contact_email'  => config('contact_email'),
//            'locale'         => locale(),
//            'event_info'     => EventConfig_info($event_config) . ' <br />'
//        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    private function getAvailableLanguages()
    {
        $languageOrder = array();
        if (isset($_SERVER['LANG_ORDER'])) {
            $languageOrder = explode(',', $_SERVER['LANG_ORDER']);
        }
        $translationFiles = scandir(__DIR__.'/../../translations', SCANDIR_SORT_NONE);
        $languages = array();
        $otherLangs = array();
        foreach ($translationFiles as $file) {
            $parts = explode('.', $file);
            if (3 !== \count($parts)) {
                continue;
            }
            if (empty($parts[1])) {
                continue;
            }
            if (\in_array($parts[1], $languageOrder, true)) {
                $position = \array_flip($languageOrder)[$parts[1]];
                $languages[$position] = $parts[1];
            } else {
                $otherLangs[] = $parts[1];
            }
        }
        ksort($languages);
        foreach ($otherLangs as $otherLang) {
            $languages[] = $otherLang;
        }
        return $languages;
    }
}
