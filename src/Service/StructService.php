<?php

namespace Engelsystem\Service;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\Group;
use Engelsystem\Entity\Meeting;
use Engelsystem\Entity\MeetingComment;
use Engelsystem\Entity\NeededAngelTypes;
use Engelsystem\Entity\News;
use Engelsystem\Entity\NewsComment;
use Engelsystem\Entity\Question;
use Engelsystem\Entity\Room;
use Engelsystem\Entity\Shift;
use Engelsystem\Entity\ShiftEntry;
use Engelsystem\Entity\ShiftType;
use Engelsystem\Entity\User;
use Engelsystem\Entity\UserAngelTypes;
use Engelsystem\Structs\EventConfig;
use Engelsystem\Structs\Lane;
use Engelsystem\Structs\LaneView;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class StructService
{
    /**
     * @var MarkdownService
     */
    private $markdownService;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * StructService constructor.
     * @param MarkdownService $markdownService
     */
    public function __construct(MarkdownService $markdownService, ContainerInterface $container)
    {
        $this->markdownService = $markdownService;
        $this->container = $container;
    }

    public function getAngeltypeStruct(AngelType $angelType, bool $withUserAngelTypes = true)
    {
        $angelTypeStruct = [
            'id' => $angelType->getId(),
            'name' => $angelType->getName(),
            'description' => $this->markdownService->parse($angelType->getDescription()),
            'contactName' => $angelType->getContactName(),
            'contactDECT' => $angelType->getContactDect(),
            'contactEmail' => $angelType->getContactEmail(),
            'noSelfSignup' => $angelType->getNoSelfSignup(),
            'requiresDriverLicense' => $angelType->getRequiresDriverLicense(),
            'restricted' => $angelType->getRestricted(),
        ];

        if ($withUserAngelTypes) {
            $angelTypeStruct['userAngelTypes'] = array_map([$this, 'getUserAngelTypeStruct'], $angelType->getUserAngelTypes()->toArray());
        }

        $currentUserMemberStatus = $this->isUserMember(null, null);
        if (null !== $token = $this->container->get('security.token_storage')->getToken()) {
            /** @var UserInterface $user */
            $user = $token->getUser();

            if ($user instanceof User) {
                $currentUserMemberStatus = $this->isUserMember($user, $angelType);
            }
        }

        return array_merge($angelTypeStruct, $currentUserMemberStatus);
    }

    public function getUserAngelTypeStruct(UserAngelTypes $userAngelTypes, bool $withAngelType = false, bool $withUser = true, bool $withConfirmUser = true)
    {
        $userAngelTypeStruct = [
            'coordinator' => $userAngelTypes->isCoordinator(),
        ];

        if ($withAngelType) {
            $userAngelTypeStruct['angelType'] = $this->getAngeltypeStruct($userAngelTypes->getAngelType(), false);
        }

        if ($withUser) {
            $userAngelTypeStruct['user'] = $this->getUserStruct($userAngelTypes->getUser());
        }

        if ($withConfirmUser) {
            $userAngelTypeStruct['confirmUser'] = $this->getUserStruct($userAngelTypes->getConfirmUser());
        }

        return $userAngelTypeStruct;
    }

    /**
     * @param User $user
     * @param AngelType $angelType
     * @return array ['member' => true, 'memberAwait' => true, 'coordinator' => true]
     */
    public function isUserMember(?User $user, ?AngelType $angelType): array
    {
        $memberState = [
            'member' => false,
            'memberAwait' => false,
            'coordinator' => false
        ];

        if ($user === null || $angelType === null) {
            return $memberState;
        }

        /** @var UserAngelTypes $userAngelType */
        foreach ($user->getUserAngelTypes()->toArray() as $userAngelType) {
            if ($userAngelType->getAngelType() === $angelType) {
                $memberState['member'] = true;

                if ($userAngelType->getConfirmUser() === null && $userAngelType->isCoordinator() !== true) {
                    $memberState['memberAwait'] = true;
                }

                if ($userAngelType->isCoordinator() === true) {
                    $memberState['coordinator'] = true;
                }

                return $memberState;
            }
        }

        return $memberState;
    }

    public function getNewsStruct(News $news): array
    {
        return
            [
                'id' => $news->getId(),
                'subject' => $news->getSubject(),
                'message' => $this->markdownService->parse($news->getMessage()),
                'author' => $news->getAuthor()->getUsername(),
                'comments' => array_map([$this, 'getNewsCommentStruct'], $news->getComments()->toArray()),
                'date' => $news->getPostDate()
            ];
    }

    public function getNewsCommentStruct(NewsComment $newsComment)
    {
        return
            [
                'id' => $newsComment->getId(),
                'message' => $this->markdownService->parse($newsComment->getMessage()),
                'author' => $newsComment->getAuthor()->getUsername(),
                'date' => $newsComment->getDate()
            ];
    }


    public function getMeetingStruct(Meeting $meeting): array
    {
        return
            [
                'id' => $meeting->getId(),
                'subject' => $meeting->getSubject(),
                'message' => $this->markdownService->parse($meeting->getMessage()),
                'author' => $meeting->getAuthor()->getUsername(),
                'comments' => array_map([$this, 'getMeetingCommentStruct'], $meeting->getComments()->toArray()),
                'date' => $meeting->getPostDate()
            ];
    }

    public function getMeetingCommentStruct(MeetingComment $meetingComment)
    {
        return
            [
                'id' => $meetingComment->getId(),
                'message' => $this->markdownService->parse($meetingComment->getMessage()),
                'author' => $meetingComment->getAuthor()->getUsername(),
                'date' => $meetingComment->getPostDate()
            ];
    }

    public function getUserStruct(?User $user)
    {
        if ($user === null) {
            return [];
        }

        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'dect' => $user->getDect(),
            'prename' => $user->getPrename(),
            'surname' => $user->getSurname(),
            'arrived' => $user->getArrived(),
            'plannedArrivalDate' => $user->getPlannedArrivalDate(),
            'arrivalDate' => $user->getArrivalDate(),
            'lastLogin' => $user->getLastLogin(),
            'vouchers' => $user->getVoucher(),
            'userAngelTypes' => array_map(function (UserAngelTypes $userAngelTypes) {
                return $this->getUserAngelTypeStruct($userAngelTypes, true, false, false);
            }, $user->getUserAngelTypes()->toArray()),
            'groups' => array_map([$this, 'getGroupStruct'], $user->getGroups()->toArray()),
            'apiKey' => $user->getApiKey(),
            'active' => $user->getActive(),
            'forceActive' => $user->getForceActive(),
            'tshirt' => $user->getTShirt(),
            'size' => $user->getSize(),
            'freeloads' => array_sum(array_map(function (ShiftEntry $shiftEntry) {
                if ($shiftEntry->getFreeloaded()) {
                    return $shiftEntry->getShift()->getStart()->diff($shiftEntry->getShift()->getEnd())->h;
                }

                return 0;
            }, $user->getShiftEntries()->toArray())),
            'free' => true, //TODO: Search for shift
        ];
    }

    public function getGroupStruct(Group $group)
    {
        return [
            'id' => $group->getId(),
            'name' => $group->getName(),
            'displayName' => $group->getDisplayName()
        ];
    }

    public function getRoomStruct(Room $room)
    {
        return [
            'id' => $room->getId(),
            'name' => $room->getName(),
            'description' => $room->getDescription(),
            'mapUrl' => $room->getMapUrl(),
            'fromFrab' => $room->getFromFrab(),
            'neededAngelTypes' => array_map([$this, 'getNeededAngelTypeStruct'], $room->getNeededAngelTypes()->toArray())
        ];
    }

    public function getShiftStruct(Shift $shift)
    {
        $diff = $shift->getEnd()->diff($shift->getStart());

        $length = $diff->h * 4;
        $length += $diff->i / 15;

        return [
            'id' => $shift->getId(),
            'name' => $shift->getName(),
            'start' => $shift->getStart(),
            'end' => $shift->getEnd(),
            'length' => $length,
            'neededHelper' => 1,
            'shiftType' => $this->getShiftTypeStruct($shift->getShiftType()),
            'neededAngelTypes' => array_map([$this, 'getNeededAngelTypeStruct'], $shift->getNeededAngelTypes()->toArray()),
            'room' => $this->getRoomStruct($shift->getRoom()),
            'shiftEntryList' => [],
            'createdAt' => $shift->getCreatedAtTimestamp(),
            'createdBy' => $this->getUserStruct($shift->getCreatedByUser()),
        ];
    }

    public function getShiftTypeStruct(ShiftType $shiftType)
    {
        return [
            'id' => $shiftType->getId(),
            'name' => $shiftType->getName(),
            'description' => $this->markdownService->parse($shiftType->getDescription()),
            'angelType' => $this->getAngeltypeStruct($shiftType->getAngelType())
        ];
    }

    public function getLaneStruct(Lane $lane)
    {
        return [
            'shifts' => array_map([$this, 'getShiftStruct'], $lane->getShifts()),
            'ticks' => $lane->getTicks()
        ];
    }

    public function getLaneViewStruct(LaneView $laneView)
    {
        $lanes = [];
        foreach ($laneView->getLanes() as $lane) {

            $struct = [];
            foreach ($lane['entries'] as $entry) {
                if ($entry instanceof Shift) {
                    $struct['shifts'][] = $this->getShiftStruct($entry);
                } else {
                    $struct['shifts'][] = $entry;
                }
            }

            $struct['room'] = $this->getRoomStruct($lane['room']);

            $lanes[] = $struct;
        }

        return [
            'lanes' => $lanes,
            'shiftHours' => $laneView->getShiftHours(),
        ];
    }

    public function getNeededAngelTypeStruct(NeededAngelTypes $neededAngelTypes, bool $withRoom = false)
    {
        $neededAngelTypeStruct = [
            'id' => $neededAngelTypes->getId(),
            'angelType' => $this->getAngeltypeStruct($neededAngelTypes->getAngelType()),
            'count' => $neededAngelTypes->getCount(),
        ];

        if ($withRoom) {
            $neededAngelTypeStruct['room'] = $neededAngelTypes->getRoom();
        }

        return $neededAngelTypeStruct;
    }

    public function getEventConfigStruct(EventConfig $eventConfig)
    {
        return [
            'eventName' => $eventConfig->getEventName(),
            'buildupStartDate' => $eventConfig->getBuildupStartDate(),
            'eventStartDate' => $eventConfig->getEventStartDate(),
            'eventEndDate' => $eventConfig->getEventEndDate(),
            'teardownEndDate' => $eventConfig->getTeardownEndDate(),
            'contactMail' => $eventConfig->getContactMail(),
            'raw' => $eventConfig->getConfig(),
        ];
    }

    public function getQuestionStruct(Question $question) {
        return [
            'id' => $question->getId(),
            'question' => $question->getQuestion(),
            'askUser' => $this->getUserStruct($question->getAskUser()),
            'answer' => $question->getAnswer(),
            'answerUser' => $this->getUserStruct($question->getAnswerUser()),
        ];
    }
}