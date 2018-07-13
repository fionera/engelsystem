<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AngeltypesController extends Controller
{
    /**
     * @Route("/angeltypes", name="angeltypes")
     */
    public function index()
    {
        return $this->render('angeltypes/index.html.twig', [
            'controller_name' => 'AngeltypesController',
        ]);
    }
}
