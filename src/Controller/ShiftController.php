<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShiftController extends Controller
{
    /**
     * @Route("/shifts", name="shifts")
     */
    public function index()
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }
}
