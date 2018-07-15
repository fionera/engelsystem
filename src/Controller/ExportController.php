<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExportController extends Controller
{
    /**
     * @Route("/export/ical/{apiKey}", name="export_ical")
     */
    public function export_ical(string $apiKey)
    {
        return $this->render('export/index.html.twig', [
            'controller_name' => 'ExportController',
        ]);
    }

    /**
     * @Route("/export/json/{apiKey}", name="export_json")
     */
    public function export_json(string $apiKey)
    {
        return $this->render('export/index.html.twig', [
            'controller_name' => 'ExportController',
        ]);
    }
}
