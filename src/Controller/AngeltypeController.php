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

class AngeltypeController extends Controller
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
     * AngeltypeController constructor.
     * @param StructService $structService
     * @param LaneService $laneService
     */
    public function __construct(StructService $structService, LaneService $laneService)
    {
        $this->structService = $structService;
        $this->laneService = $laneService;
    }

    /**
     * @Route("/angeltype", name="angeltype")
     */
    public function index()
    {
        return $this->render('angeltype/index.html.twig', [
            'angelTypeList' => $this->getAngeltypes()
        ]);
    }

    /**
     * @Route("/angeltype/{id<\d+>}", name="angeltype_view")
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

        return $this->render('angeltype/view.html.twig', [
            'angelType' => $this->structService->getAngeltypeStruct($angelType),
            'multiDayLaneView' => $this->laneService->createMultiDayLaneView($shifts),
        ]);
    }

    /**
     * @Route("/angeltype/{id<\d+>}/edit", name="angeltype_edit")
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

            return $this->redirectToRoute('angeltype_view', ['id' => $angelType->getId()]);
        }

        return $this->render('angeltype/edit.html.twig', [
            'angelTypeForm' => $angelTypeForm->createView(),
            'angelType' => $this->structService->getAngeltypeStruct($angelType)
        ]);
    }

    /**
     * @Route("/angeltype/create", name="angeltype_create")
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

            return $this->redirectToRoute('angeltype_view', ['id' => $angelType->getId()]);
        }

        return $this->render('angeltype/create.html.twig', [
            'angelTypeForm' => $angelTypeForm->createView()
        ]);
    }

    /**
     * @Route("/angeltype/{id<\d+>}/delete", name="angeltype_delete")
     */
    public function delete(int $id)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($angelType);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('angeltype');
    }

    /**
     * @Route("/angeltype/{id<\d+>}/add_angel", name="angeltype_add")
     */
    public function add(int $id)
    {
        $angelType = $this->getDoctrine()->getRepository(AngelType::class)->find($id);

        if ($angelType === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($angelType);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('angeltype');
    }

    /**
     * @Route("/angeltype/{angelTypeId<\d+>}/remove/{userId<\d+>}", name="angeltype_remove_angel")
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

        return $this->redirectToRoute('angeltype');
    }

    /**
     * @Route("/angeltype/{id<\d+>}/join", name="angeltype_join")
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

        return $this->redirectToRoute('angeltype');
    }

    /**
     * @Route("/angeltype/{id<\d+>}/leave", name="angeltype_leave")
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

        return $this->redirectToRoute('angeltype');
    }

    protected function getAngeltypes()
    {
        $angelTypes = $this->getDoctrine()->getRepository(AngelType::class)->findAll();

        return array_map([$this->structService, 'getAngeltypeStruct'], $angelTypes);
    }
}
