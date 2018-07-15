<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\Meeting;
use Engelsystem\Entity\MeetingComment;
use Engelsystem\Form\MeetingCommentType;
use Engelsystem\Form\MeetingType;
use Engelsystem\Service\MarkdownService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends Controller
{
    /**
     * @var MarkdownService
     */
    private $markdownService;

    /**
     * MeetingController constructor.
     */
    public function __construct(MarkdownService $markdownService)
    {
        $this->markdownService = $markdownService;
    }

    /**
     * @Route("/meeting/{page<\d+>?1}", name="meeting")
     */
    public function meeting(int $page, Request $request)
    {
        $meeting = new Meeting();
        $meetingForm = $this->createForm(MeetingType::class, $meeting);

        $meetingForm->handleRequest($request);
        if ($meetingForm->isSubmitted() && $meetingForm->isValid()) {

            $meeting->setAuthor($this->getUser());
            $meeting->setPostDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

            return $this->redirectToRoute('meeting');
        }

        return $this->render('meeting/index.html.twig', [
            'meetingList' => $this->getMeeting(),
            'meetingForm' => $meetingForm->createView()
        ]);
    }

    /**
     * @Route("/meeting/{id}/edit", name="meeting_edit")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meeting_edit(int $id, Request $request)
    {
        $meeting = $this->getDoctrine()->getRepository(Meeting::class)->find($id);

        if ($meeting === null) {
            throw $this->createNotFoundException();
        }

        $meetingForm = $this->createForm(MeetingType::class, $meeting);

        $meetingForm->handleRequest($request);
        if ($meetingForm->isSubmitted() && $meetingForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meeting);
            $entityManager->flush();

            return $this->redirectToRoute('meeting');
        }

        $this->addFlash('success', 'meeting_edit_successfully');

        return $this->render('meeting/edit.html.twig', [
            'meetingForm' => $meetingForm->createView(),
            'meeting' => $this->getMeetingStruct($meeting)
        ]);
    }

    /**
     * @Route("/meeting/{id}/delete", name="meeting_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meeting_delete(int $id)
    {
        $meeting = $this->getDoctrine()->getRepository(Meeting::class)->find($id);

        if ($meeting === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($meeting);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'meeting_deleted_successfully');

        return $this->redirectToRoute('meeting');
    }

    /**
     * @Route("/meeting/{id}/comments", name="meeting_comments")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meeting_comments(int $id, Request $request)
    {
        $meeting = $this->getDoctrine()->getRepository(Meeting::class)->find($id);

        if ($meeting === null) {
            throw $this->createNotFoundException();
        }

        $meetingComment = new MeetingComment();
        $meetingCommentForm = $this->createForm(MeetingCommentType::class, $meetingComment);

        $meetingCommentForm->handleRequest($request);
        if ($meetingCommentForm->isSubmitted() && $meetingCommentForm->isValid()) {

            $meetingComment->setMeeting($meeting);
            $meetingComment->setAuthor($this->getUser());
            $meetingComment->setPostDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meetingComment);
            $entityManager->flush();

            return $this->redirectToRoute('meeting_comments', ['id' => $meeting->getId()]);
        }

        $this->addFlash('success', 'meeting_edit_successfully');

        return $this->render('meeting/comments.html.twig', [
            'meeting' => $this->getMeetingStruct($meeting),
            'meetingCommentForm' => $meetingCommentForm->createView()
        ]);
    }

    /**
     * @Route("/meeting/comments/{id}", name="meeting_comments_edit")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function meeting_comments_edit(int $id = 0, Request $request)
    {
        $meetingComment = $this->getDoctrine()->getRepository(MeetingComment::class)->find($id);

        if ($meetingComment === null) {
            throw $this->createNotFoundException();
        }

        $meetingCommentForm = $this->createForm(MeetingCommentType::class, $meetingComment);

        $meetingCommentForm->handleRequest($request);
        if ($meetingCommentForm->isSubmitted() && $meetingCommentForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meetingComment);
            $entityManager->flush();

            return $this->redirectToRoute('meeting_comments', ['id' => $meetingComment->getMeeting()->getId()]);
        }

        $this->addFlash('success', 'meeting_edit_successfully');

        return $this->render('meeting/comments.html.twig', [
            'meeting' => $this->getMeetingStruct($meetingComment->getMeeting()),
            'meetingCommentForm' => $meetingCommentForm->createView()
        ]);
    }

    private function getMeetingStruct(Meeting $meeting): array
    {
        return
            [
                'id' => $meeting->getId(),
                'subject' => $meeting->getSubject(),
                'message' => $this->markdownService->parse($meeting->getMessage()),
                'author' => $meeting->getAuthor()->getUsername(),
                'comments' => array_map([$this, 'getCommentStruct'], $meeting->getComments()->toArray()),
                'date' => $meeting->getPostDate()
            ];
    }

    private function getCommentStruct(MeetingComment $meetingComment)
    {
        return
            [
                'id' => $meetingComment->getId(),
                'message' => $this->markdownService->parse($meetingComment->getMessage()),
                'author' => $meetingComment->getAuthor()->getUsername(),
                'date' => $meetingComment->getPostDate()
            ];
    }

    protected function getMeeting()
    {
        $meeting = $this->getDoctrine()->getRepository(Meeting::class)->findBy([], ['postDate' => 'desc'], 10);

        return array_map([$this, 'getMeetingStruct'], $meeting);
    }
}
