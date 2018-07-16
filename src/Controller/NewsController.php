<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\News;
use Engelsystem\Entity\NewsComment;
use Engelsystem\Form\NewsCommentType;
use Engelsystem\Form\NewsType;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;

    /**
     * NewsController constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService)
    {
        $this->structService = $structService;
    }

    /**
     * @Route("/news/{page<\d+>?1}", name="news")
     */
    public function news(int $page, Request $request)
    {
        $news = new News();
        $newsForm = $this->createForm(NewsType::class, $news);

        $newsForm->handleRequest($request);
        if ($newsForm->isSubmitted() && $newsForm->isValid()) {

            $news->setAuthor($this->getUser());
            $news->setPostDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('news');
        }

        return $this->render('news/index.html.twig', [
            'newsList' => $this->getNews(),
            'newsForm' => $newsForm->createView()
        ]);
    }

    /**
     * @Route("/news/{id<\d+>}/edit", name="news_edit")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_edit(int $id, Request $request)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->find($id);

        if ($news === null) {
            throw $this->createNotFoundException();
        }

        $newsForm = $this->createForm(NewsType::class, $news);

        $newsForm->handleRequest($request);
        if ($newsForm->isSubmitted() && $newsForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash('success', 'news_edit_successfully');

            return $this->redirectToRoute('news');
        }


        return $this->render('news/edit.html.twig', [
            'newsForm' => $newsForm->createView(),
            'news' => $this->structService->getNewsStruct($news)
        ]);
    }

    /**
     * @Route("/news/{id<\d+>}/delete", name="news_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_delete(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->find($id);

        if ($news === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($news);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'news_deleted_successfully');

        return $this->redirectToRoute('news');
    }

    /**
     * @Route("/news/{id<\d+>}/comments", name="news_comments")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_comments(int $id, Request $request)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->find($id);

        if ($news === null) {
            throw $this->createNotFoundException();
        }

        $newsComment = new NewsComment();
        $newsCommentForm = $this->createForm(NewsCommentType::class, $newsComment);

        $newsCommentForm->handleRequest($request);
        if ($newsCommentForm->isSubmitted() && $newsCommentForm->isValid()) {

            $newsComment->setNews($news);
            $newsComment->setAuthor($this->getUser());
            $newsComment->setDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsComment);
            $entityManager->flush();

            return $this->redirectToRoute('news_comments', ['id' => $news->getId()]);
        }

        $this->addFlash('success', 'news_edit_successfully');

        return $this->render('news/comments.html.twig', [
            'news' => $this->structService->getNewsStruct($news),
            'newsCommentForm' => $newsCommentForm->createView()
        ]);
    }

    /**
     * @Route("/news/comments/{id<\d+>}", name="news_comments_edit")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_comments_edit(int $id = 0, Request $request)
    {
        $newsComment = $this->getDoctrine()->getRepository(NewsComment::class)->find($id);

        if ($newsComment === null) {
            throw $this->createNotFoundException();
        }

        $newsCommentForm = $this->createForm(NewsCommentType::class, $newsComment);

        $newsCommentForm->handleRequest($request);
        if ($newsCommentForm->isSubmitted() && $newsCommentForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsComment);
            $entityManager->flush();

            return $this->redirectToRoute('news_comments', ['id' => $newsComment->getNews()->getId()]);
        }

        $this->addFlash('success', 'news_edit_successfully');

        return $this->render('news/comments.html.twig', [
            'news' => $this->structService->getNewsStruct($newsComment->getNews()),
            'newsCommentForm' => $newsCommentForm->createView()
        ]);
    }

    protected function getNews()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findBy([], ['postDate' => 'desc'], 10);

        return array_map([$this->structService, 'getNewsStruct'], $news);
    }
}
