<?php

namespace Engelsystem\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShiftController extends Controller
{
    /**
     * @Route("/shift", name="shift")
     */
    public function index()
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }

    /**
     * @Route("/shift/{id}", name="shift_view")
     */
    public function view(int $id)
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }

    /**
     * @Route("/shift/{id}/edit", name="shift_edit")
     */
    public function edit(int $id)
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }

    /**
     * @Route("/shift/{id}/delete", name="shift_delete")
     */
    public function delete(int $id)
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }

    /**
     * @Route("/shift/{id}/signup/{userID}", name="shift_signup")
     */
    public function signup(int $id, $userID = null)
    {
        return $this->render('shift/index.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }
}
