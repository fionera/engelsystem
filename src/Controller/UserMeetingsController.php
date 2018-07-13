<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserMeetingsController extends Controller
{
    /**
     * @Route("/user/meetings", name="user_meetings")
     */
    public function index()
    {
        return $this->render('user_meetings/index.html.twig', [
            'controller_name' => 'UserMeetingsController',
        ]);
    }
}
