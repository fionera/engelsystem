<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        if ($this->getUser() === null) {
            return $this->forward('Engelsystem\\Controller\\LoginController::login');
        }

        return $this->redirectToRoute('news');
    }
}
