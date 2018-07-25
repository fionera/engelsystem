<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Room;
use Engelsystem\Form\ShiftFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Routing\Annotation\Route;

class ShiftController extends Controller
{
    /**
     * @Route("/shift", name="shift")
     */
    public function index()
    {
        $filterForm = $this->createForm(ShiftFilterType::class);

        return $this->render('shift/index.html.twig', [
            'filterForm' => $filterForm->createView(),
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
