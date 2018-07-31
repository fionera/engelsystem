<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\EventConfig;
use Engelsystem\Form\EventConfigType;
use Engelsystem\Service\EventConfigService;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;

    /**
     * @var EventConfigService
     */
    private $eventConfigService;

    /**
     * ConfigController constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService, EventConfigService $eventConfigService)
    {
        $this->structService = $structService;
        $this->eventConfigService = $eventConfigService;
    }


    /**
     * @Route("/config", name="config")
     */
    public function index()
    {
        $eventConfig = $this->eventConfigService->getEventConfig();

        return $this->render('config/index.html.twig', [
            'eventConfig' => $this->structService->getEventConfigStruct($eventConfig),
        ]);
    }


    /**
     * @Route("/config/edit/{key}", name="config_edit")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(string $key, Request $request)
    {
        $eventConfig = $this->eventConfigService->getEventConfig();

            switch ($key) {
                case 'buildupStartDate':
                case 'eventStartDate':
                case 'eventEndDate':
                case 'teardownEndDate':
                    $type = DateTimeType::class;
                    break;
                default:
                    $type = TextType::class;
                    break;
            }

        $eventConfigForm = $this->createFormBuilder()->add('key', TextType::class, [
            'disabled' => true,
            'data' => $key
        ])->add('value', $type, [
            'data' => $eventConfig->getConfig()[$key],
            'required' => false
        ])->add('null', CheckboxType::class, [
            'required' => false
        ])->add('save', SubmitType::class)->getForm();

        $eventConfigForm->handleRequest($request);
        if ($eventConfigForm->isSubmitted() && $eventConfigForm->isValid()) {

            if ($eventConfigForm->getData()['null']) {
                $eventConfig->set($key, null);
            } else {
                $eventConfig->set($key, $eventConfigForm->getData()['value']);
            }

            $this->eventConfigService->saveEventConfig($eventConfig);

            return $this->redirectToRoute('config');
        }

        return $this->render('config/edit.html.twig', [
            'eventConfigForm' => $eventConfigForm->createView(),
        ]);
    }
}
