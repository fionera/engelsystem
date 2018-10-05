<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;
use Engelsystem\Entity\ShiftType;
use Engelsystem\Form\ShiftFilterType;
use Engelsystem\Form\ShiftTypeType;
use Engelsystem\Service\LaneService;
use Engelsystem\Service\MarkdownService;
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
    public function index()
    {
        $shiftTypes = $this->getDoctrine()->getRepository(ShiftType::class)->findAll();

        return $this->render('shifttype/index.html.twig', [
            'shiftTypes' => array_map([$this->structService, 'getShiftTypeStruct'], $shiftTypes)
        ]);
    }

    /**
     * @Route("/shift_type/{id<\d+>}", name="shift_type_view")
     */
    public function view(int $id)
    {
        $shiftType = $this->getDoctrine()->getRepository(ShiftType::class)->find($id);

        if ($shiftType === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('shifttype/view.html.twig', [
            'shiftType' => $this->structService->getShiftTypeStruct($shiftType)
        ]);
    }

    /**
     * @Route("/shift_type/{id<\d+>}/edit", name="shift_type_edit")
     */
    public function edit(int $id, Request $request)
    {
        $shiftType = $this->getDoctrine()->getRepository(ShiftType::class)->find($id);

        if ($shiftType === null) {
            throw $this->createNotFoundException();
        }

        $shiftTypeForm = $this->createForm(ShiftTypeType::class, $shiftType);

        $shiftTypeForm->handleRequest($request);
        if ($shiftTypeForm->isSubmitted() && $shiftTypeForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shiftType);
            $entityManager->flush();

            return $this->redirectToRoute('shift_type');
        }

        return $this->render('shifttype/edit.html.twig', [
           'shiftTypeForm' => $shiftTypeForm->createView()
        ]);
    }

    /**
     * @Route("/shift_type/create", name="shift_type_create")
     */
    public function create(Request $request)
    {

        $shiftType = new ShiftType();
        $shiftTypeForm = $this->createForm(ShiftTypeType::class, $shiftType);

        $shiftTypeForm->handleRequest($request);
        if ($shiftTypeForm->isSubmitted() && $shiftTypeForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shiftType);
            $entityManager->flush();

            return $this->redirectToRoute('shift_type');
        }

        return $this->render('shifttype/edit.html.twig', [
            'shiftTypeForm' => $shiftTypeForm->createView()
        ]);
    }

    /**
     * @Route("/shift_type/{id}/delete", name="shift_type_delete")
     */
    public function delete(int $id)
    {
        $shiftType = $this->getDoctrine()->getRepository(ShiftType::class)->find($id);

        if ($shiftType === null) {
            throw $this->createNotFoundException();
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($shiftType);
        $manager->flush();
    }
}
