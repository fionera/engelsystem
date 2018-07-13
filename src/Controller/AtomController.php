<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AtomController extends Controller
{
    /**
     * @Route("/atom", name="atom")
     */
    public function index()
    {
        return $this->render('atom/index.html.twig', [
            'controller_name' => 'AtomController',
        ]);
    }
}
