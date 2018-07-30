<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;
use Engelsystem\Form\ShiftFilterType;
use Engelsystem\Service\LaneService;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class ShiftTypeController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var LaneService
     */
    private $laneService;
    /**
     * @var StructService
     */
    private $structService;

    /**
     * ShiftController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, LaneService $laneService, StructService $structService)
    {
        $this->entityManager = $entityManager;
        $this->laneService = $laneService;
        $this->structService = $structService;
    }


    /**
     * @Route("/shift_type", name="shift_type")
     */
    public function index(Request $request)
    {

    }

    /**
     * @Route("/shift_type/{id}", name="shift_type_view")
     */
    public function view(int $id)
    {

    }

    /**
     * @Route("/shift_type/{id}/edit", name="shift_type_edit")
     */
    public function edit(int $id)
    {
    }

    /**
     * @Route("/shift_type/{id}/delete", name="shift_type_delete")
     */
    public function delete(int $id)
    {
    }

    /**
     * @Route("/shift_type/{id}/signup/{userID}", name="shift_type_signup")
     */
    public function signup(int $id, $userID = null)
    {
    }
}
