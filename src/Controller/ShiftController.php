<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;
use Engelsystem\Entity\ShiftEntry;
use Engelsystem\Entity\User;
use Engelsystem\Form\ShiftFilterType;
use Engelsystem\Form\ShiftType;
use Engelsystem\Service\LaneService;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShiftController extends Controller
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
     * @Route("/shift", name="shift")
     */
    public function index(Request $request)
    {
        $filterForm = $this->createForm(ShiftFilterType::class);
        $shifts = [];

        $filterForm->handleRequest($request);
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();

            $fromDateTime = $this->convertToDateTime($data['from_date'], $data['from_time']);
            $toDateTime = $this->convertToDateTime($data['to_date'], $data['to_time']);

            $qb = $this->entityManager->createQueryBuilder();

            /** @var Collection $rooms */
            $rooms = $data['rooms'];
            $roomQuery = $this->entityManager->createQueryBuilder()
                ->select('room')
                ->from('Engelsystem:Room', 'room')
                ->where($qb->expr()->in('room.id', array_map(function (Room $room) {
                    return $room->getId();
                }, $rooms->toArray())));

            /** @var Collection $angelTypes */
            $angelTypes = $data['angelTypes'];
            $angelTypeQuery = $this->entityManager->createQueryBuilder()
                ->select('shift_type')
                ->from('Engelsystem:ShiftType', 'shift_type')
                ->join('shift_type.angelType', 'angel_type')
                ->where($qb->expr()->in('angel_type.id', array_map(function (AngelType $angelType) {
                    return $angelType->getId();
                }, $angelTypes->toArray())));

            $shiftEntryQuery = $this->entityManager->createQueryBuilder()
                ->select('(shift_entry.shift)')
                ->from('Engelsystem:ShiftEntry', 'shift_entry');

            $shiftQuery = $this->entityManager->createQueryBuilder()
                ->select('shift_entity')
                ->from('Engelsystem:Shift', 'shift_entity')
                ->where($qb->expr()->lte('shift_entity.start', ':fromTime'))
                ->setParameter('fromTime', $fromDateTime->format('Y-m-d H:i:s'))
                ->andWhere($qb->expr()->lte('shift_entity.end', ':toTime'))
                ->setParameter('toTime', $toDateTime->format('Y-m-d H:i:s'));

            if ($data['occupancy_free'] && !$data['occupancy_occupied']) {
                $shiftQuery = $shiftQuery->andWhere($qb->expr()->notIn('shift_entity', $shiftEntryQuery->getDQL()));
            }

            if ($data['occupancy_occupied'] && !$data['occupancy_free']) {
                $shiftQuery = $shiftQuery->andWhere($qb->expr()->in('shift_entity', $shiftEntryQuery->getDQL()));
            }


            if (\count($data['rooms']) > 0) {
                $shiftQuery = $shiftQuery->andWhere($qb->expr()->in('shift_entity.room', $roomQuery->getDQL()));
            }

            if (\count($data['angelTypes']) > 0) {
                $shiftQuery = $shiftQuery->andWhere($qb->expr()->in('shift_entity.shiftType', $angelTypeQuery->getDQL()));
            }

            $shifts = $shiftQuery->getQuery()->getResult();
        }

        return $this->render('shift/index.html.twig', [
            'filterForm' => $filterForm->createView(),
            'multiDayLaneView' => $this->laneService->createMultiDayLaneView($shifts)
        ]);
    }

    private function convertToDateTime(string $date, \DateTime $time)
    {
        $dateTime = clone $time;

        $dateParts = explode('-', $date);

        $dateTime->setDate($dateParts[0], $dateParts[1], $dateParts[2]);

        return $dateTime;
    }

    /**
     * @Route("/shift/{id}", name="shift_view")
     */
    public function view(int $id)
    {
        $shift = $this->getDoctrine()->getRepository(Shift::class)->find($id);

        if ($shift === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('shift/view.html.twig', [
            'shift' => $this->structService->getShiftStruct($shift),
        ]);
    }

    /**
     * @Route("/shift/create", name="shift_create")
     */
    public function create()
    {
        $shiftForm = $this->createForm(ShiftType::class);

        return $this->render('shift/create.html.twig', [
            'shiftForm' => $shiftForm->createView(),
        ]);
    }

    /**
     * @Route("/shift/{id}/edit", name="shift_edit")
     */
    public function edit(int $id)
    {
        return $this->render('shift/edit.html.twig', [
            'controller_name' => 'ShiftController',
        ]);
    }

    /**
     * @Route("/shift/{id}/delete", name="shift_delete")
     */
    public function delete(int $id)
    {
        return $this->redirectToRoute('shift');
    }

    /**
     * @Route("/shift/{id}/signup/{userID}", name="shift_signup")
     */
    public function signup(int $id, $userID = null)
    {
        $user = null;
        if ($userID !== null) {
            $user = $this->getDoctrine()->getRepository(User::class)->find($userID);

            if ($user === null) {
                throw $this->createNotFoundException();
            }
        }

        if ($user === null) {
            $user = $this->getUser();
        }

        $shift = $this->getDoctrine()->getRepository(Shift::class)->find($id);

        $shiftEntry = new ShiftEntry();
        $shiftEntry->setShift($shift);
        $shiftEntry->setUser($user);
        //$shiftEntry->setAngelType(); TODO: How to get the correct?
        $this->getDoctrine()->getManager()->persist($shiftEntry);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('shift');
    }
}
