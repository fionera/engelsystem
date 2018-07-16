<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\Room;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
            'roomList' => array_map([$this->structService, 'getRoomStruct'], $this->getDoctrine()->getRepository(Room::class)->findAll())]);
    }

    /**
     * @Route("/room/create", name="room_create")
     */
    public function create()
    {

    }

    /**
     * @Route("/room/{id}/edit", name="room_edit")
     */
    public function edit(int $id)
    {

    }

    /**
     * @Route("/room/{id}/delete", name="room_delete")
     */
    public function delete(int $id)
    {

    }

    /**
     * @Route("/room/{id}/view", name="room_view")
     */
    public function view(int $id)
    {

    }
}
