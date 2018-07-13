<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AskController extends Controller
{
    /**
     * @Route("/ask", name="ask")
     */
    public function index()
    {
        return $this->render('ask/index.html.twig', [
            'controller_name' => 'AskController',
        ]);
    }
}
