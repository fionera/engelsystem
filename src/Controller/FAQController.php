<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FAQController extends Controller
{
    /**
     * @Route("/FAQ", name="FAQ")
     */
    public function index()
    {
        return $this->render('faq/index.html.twig', [
            'controller_name' => 'FAQController',
        ]);
    }
}
