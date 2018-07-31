<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CreditsController extends Controller
{
    /**
     * @Route("/credits", name="credits")
     */
    public function index()
    {
        return $this->render('credits/index.html.twig');
    }
}
