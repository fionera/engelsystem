<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\Collection;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Shift;
use Engelsystem\Entity\ShiftType;
use Engelsystem\Entity\UserAngelTypes;
use Engelsystem\Form\AngelTypeType;
use Engelsystem\Service\LaneService;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AngeltypesController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;
    /**
     * @var LaneService
     */
    private $laneService;

    /**
     * AngeltypesController constructor.
     */
    public function __construct(StructService $structService, LaneService $laneService)
    {
        $this->structService = $structService;
        $this->laneService = $laneService;
    }

    /**
     * @Route("/angeltypes", name="angeltypes")
     */
    public function index()
    {
        return $this->render('angeltypes/index.html.twig', [
            'angelTypeList' => $this->getAngeltypes()
        ]);
    }

    /**
     * @Route("/angeltypes/{id<\d+>}", name="angeltypes_view")
     */
    public function view(int $id)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        /** @var Collection $shiftTypes */
        $shiftTypes = $angelType->getShiftTypes();

        $shifts = [];
        /** @var ShiftType $shiftType */
        foreach ($shiftTypes->getIterator() as $shiftType) {
            /** @var Shift $shift */
            foreach ($shiftType->getShifts()->getIterator() as $shift) {
                $shifts[] = $shift;
            }
        }

        return $this->render('angeltypes/view.html.twig', [
            'angelType' => $this->structService->getAngeltypeStruct($angelType),
            'multiDayLaneView' => $this->laneService->createMultiDayLaneView($shifts),
        ]);
    }

    /**
     * @Route("/angeltypes/{id<\d+>}/edit", name="angeltypes_edit")
     */
    public function edit(int $id, Request $request)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $angelTypeForm = $this->createForm(AngelTypeType::class, $angelType);

        $angelTypeForm->handleRequest($request);
        if ($angelTypeForm->isSubmitted() && $angelTypeForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($angelType);
            $entityManager->flush();

            return $this->redirectToRoute('angeltypes_view', ['id' => $angelType->getId()]);
        }

        return $this->render('angeltypes/edit.html.twig', [
            'angelTypeForm' => $angelTypeForm->createView(),
            'angelType' => $this->structService->getAngeltypeStruct($angelType)
        ]);
    }

    /**
     * @Route("/angeltypes/create", name="angeltypes_create")
     */
    public function create(Request $request)
    {
        $angelType = new AngelType();
        $angelTypeForm = $this->createForm(AngelTypeType::class, $angelType);

        $angelTypeForm->handleRequest($request);
        if ($angelTypeForm->isSubmitted() && $angelTypeForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($angelType);
            $entityManager->flush();

            return $this->redirectToRoute('angeltypes_view', ['id' => $angelType->getId()]);
        }

        return $this->render('angeltypes/create.html.twig', [
            'angelTypeForm' => $angelTypeForm->createView()
        ]);
    }

    /**
     * @Route("/angeltypes/{id<\d+>}/delete", name="angeltypes_delete")
     */
    public function delete(int $id)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($angelType);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('angeltypes');
    }

    /**
     * @Route("/angeltypes/{id<\d+>}/add_angel", name="angeltypes_add")
     */
    public function add(int $id)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($angelType);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('angeltypes');
    }

    /**
     * @Route("/angeltypes/{angelTypeId<\d+>}/remove/{userId<\d+>}", name="angeltypes_remove_angel")
     */
    public function remove(int $angelTypeId, int $userId, Request $request)
    {
        $userAngelType = $this->getDoctrine()->getRepository(UserAngelTypes::class)->findOneBy(['angelType' => $angelTypeId, 'user' => $userId]);

        if ($userAngelType === null) {
            throw $this->createNotFoundException();
        }


        $this->getDoctrine()->getManager()->remove($userAngelType);
        $this->getDoctrine()->getManager()->flush();

        $redirectUrl = $request->get('redirect', null);

        if ($redirectUrl !== null) {
            return $this->redirect($redirectUrl);
        }

        return $this->redirectToRoute('angeltypes');
    }

    /**
     * @Route("/angeltypes/{id<\d+>}/join", name="angeltypes_join")
     */
    public function join(int $id, Request $request)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $userAngelType = new UserAngelTypes();
        $userAngelType->setUser($this->getUser());
        $userAngelType->setAngelType($angelType);

        if ($angelType->getNoSelfSignup() === false) {
            $userAngelType->setConfirmUser($this->getUser());
        }

        $this->getDoctrine()->getManager()->persist($userAngelType);
        $this->getDoctrine()->getManager()->flush();

        $redirectUrl = $request->get('redirect', null);

        if ($redirectUrl !== null) {
            return $this->redirect($redirectUrl);
        }

        return $this->redirectToRoute('angeltypes');
    }

    /**
     * @Route("/angeltypes/{id<\d+>}/leave", name="angeltypes_leave")
     */
    public function leave(int $id, Request $request)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $userAngelType = $this->getDoctrine()->getRepository(UserAngelTypes::class)->findOneBy(['angelType' => $angelType, 'user' => $this->getUser()]);

        $this->getDoctrine()->getManager()->remove($userAngelType);
        $this->getDoctrine()->getManager()->flush();

        $redirectUrl = $request->get('redirect', null);

        if ($redirectUrl !== null) {
            return $this->redirect($redirectUrl);
        }

        return $this->redirectToRoute('angeltypes');
    }

    protected function getAngeltypes()
    {
        $angelTypes = $this->getDoctrine()->getRepository(AngelType::class)->findAll();

        return array_map([$this->structService, 'getAngeltypeStruct'], $angelTypes);
    }
}
