<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeetingController extends Controller
{
    /**
     * @Route("/meetings", name="meetings")
     */
    public function index()
    {
        return $this->render('meeting/index.html.twig', [
            'controller_name' => 'MeetingController',
        ]);
    }
}
