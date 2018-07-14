<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\News;
use Engelsystem\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends Controller
{
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
            $news->setDate(new \DateTime());

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
     * @Route("/news/{id}/edit", name="news_edit")
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

            return $this->redirectToRoute('news');
        }

        $this->addFlash('success', 'news_edit_successfully');

        return $this->render('news/edit.html.twig', [
            'newsForm' => $newsForm->createView(),
            'news' => $this->getNewsStruct($news)
        ]);
    }

    /**
     * @Route("/news/{id}/delete", name="news_delete")
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
     * @Route("/news/{id}/comments", name="news_comments")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_comments(int $id)
    {
        return $this->render('news/comments.html.twig', [

        ]);
    }

    private function getNewsStruct(News $news): array
    {
        return
            [
                'id' => $news->getId(),
                'subject' => $news->getSubject(),
                'meeting' => $news->getMeeting(),
                'message' => $news->getMessage(),
                'author' => $news->getAuthor()->getUsername(),
                'commentAmount' => \count($news->getComments()),
                'date' => $news->getDate()
            ];
    }

    private function getNews()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findBy([], null, 10);

        return array_map([$this, 'getNewsStruct'], $news);
    }
}
