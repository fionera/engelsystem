<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\NeededAngelTypes;
use Engelsystem\Entity\Room;
use Engelsystem\Form\RoomType;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;

    /**
     * RoomController constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService)
    {
        $this->structService = $structService;
    }


    /**
     * @Route("/room", name="room")
     */
    public function index()
    {
        return $this->render('room/index.html.twig', [
            'roomList' => array_map([$this->structService, 'getRoomStruct'], $this->getDoctrine()->getRepository(Room::class)->findAll())
        ]);
    }

    /**
     * @Route("/room/create", name="room_create")
     */
    public function create(Request $request)
    {
        $room = new Room();

        $neededAngelTypeCollection = new ArrayCollection();
        foreach ($this->getDoctrine()->getRepository(AngelType::class)->findAll() as $angelType) {
            $neededAngelType = new NeededAngelTypes();
            $neededAngelType->setRoom($room);
            $neededAngelType->setAngelType($angelType);
            $neededAngelType->setCount(0);

            $neededAngelTypeCollection->add($neededAngelType);
        }

        $room->setNeededAngelTypes($neededAngelTypeCollection);

        $roomForm = $this->createForm(RoomType::class, $room);

        $angelTypeList = $this->getDoctrine()->getRepository(AngelType::class)->findAll();

        $roomForm->handleRequest($request);
        if ($roomForm->isSubmitted() && $roomForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room');
        }

        return $this->render('room/edit.html.twig', [
            'room' => $this->structService->getRoomStruct($room),
            'roomForm' => $roomForm->createView(),
            'angelTypeNameList' => array_map(function (NeededAngelTypes $neededAngelTypes) {
                return $neededAngelTypes->getAngelType()->getName();
            }, $neededAngelTypeCollection->toArray())
        ]);
    }

    /**
     * @Route("/room/{id}/edit", name="room_edit")
     */
    public function edit(int $id, Request $request)
    {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);

        if ($room === null) {
            throw $this->createNotFoundException();
        }

        $neededAngelTypeCollection = $room->getNeededAngelTypes() ?? new ArrayCollection();

        $existingAngelTypes = [];
        /** @var NeededAngelTypes $neededAngelType */
        foreach ($neededAngelTypeCollection->toArray() as $neededAngelType) {
            $existingAngelTypes[] = $neededAngelType->getAngelType();
        }

        $angelTypeList = $this->getDoctrine()->getRepository(AngelType::class)->findAll();
        foreach ($angelTypeList as $angelType) {
            if (in_array($angelType, $existingAngelTypes, true)) {
                continue;
            }

            $neededAngelTypeCollection->add($this->getNeededAngelTypesEntity($angelType, $room));
        }

        $room->setNeededAngelTypes($neededAngelTypeCollection);

        $roomForm = $this->createForm(RoomType::class, $room);

        $roomForm->handleRequest($request);
        if ($roomForm->isSubmitted() && $roomForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room');
        }

        return $this->render('room/create.html.twig', [
            'room' => $this->structService->getRoomStruct($room),
            'roomForm' => $roomForm->createView(),
            'angelTypeNameList' => array_map(function (NeededAngelTypes $neededAngelTypes) {
                return $neededAngelTypes->getAngelType()->getName();
            }, $neededAngelTypeCollection->toArray())
        ]);
    }

    /**
     * @Route("/room/{id}/delete", name="room_delete")
     */
    public function delete(int $id)
    {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);

        if ($room === null) {
            throw $this->createNotFoundException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($room);
        $entityManager->flush();

        return $this->redirectToRoute('room');
    }

    /**
     * @Route("/room/{id}/view", name="room_view")
     */
    public function view(int $id)
    {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);

        if ($room === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('room/view.html.twig', [
            'room' => $this->structService->getRoomStruct($room),
            'currentDay' => '',
            'days' => [],
            'shifts' => []
        ]);
    }

    private function getNeededAngelTypesEntity(AngelType $angelType, Room $room)
    {
        $neededAngelType = new NeededAngelTypes();
        $neededAngelType->setRoom($room);
        $neededAngelType->setAngelType($angelType);
        $neededAngelType->setCount(0);

        return $neededAngelType;
    }
}
