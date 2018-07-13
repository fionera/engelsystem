<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\News;
use Engelsystem\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     */
    public function news()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findBy([], null, 10);

        $news = array_map(function (News $news) {
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
        }, $news);

        return $this->render('news/index.html.twig', [
            'newsList' => $news
        ]);
    }

    /**
     * @Route("/news/{page}", name="news_page")
     */
    public function news_page(int $page)
    {
        return $this->render('news/index.html.twig', [
            'newsList' => [
                [
                    'id' => 0,
                    'subject' => 'Test Title',
                    'meeting' => true,
                    'message' => 'Toller Text',
                    'author' => 'admin',
                    'comments' => []
                ]
            ],
        ]);
    }

    /**
     * @Route("/news/{id}/edit", name="news_edit")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_edit(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->find($id);

        $this->denyAccessUnlessGranted('edit', $news);

        return $this->render('news/index.html.twig', [
            'newsList' => [
                [
                    'subject' => 'Test Title',
                    'meeting' => true,
                    'message' => 'Toller Text',
                    'author' => 'admin'
                ]
            ],
        ]);
    }

    /**
     * @Route("/news/{id}/comments", name="news_comments")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function news_comments(int $id)
    {
        return $this->render('news/index.html.twig', [
            'newsList' => [
                [
                    'subject' => 'Test Title',
                    'meeting' => true,
                    'message' => 'Toller Text',
                    'author' => 'admin'
                ]
            ],
        ]);
    }

    private function canPost()
    {
        if ($this->getUser() === null) {
            return false;
        }


        $this->userHasPrivilege($this->getUser(), 'news_post');
    }

    private function userHasPrivilege(User $user, string $searchedPrivilege): bool
    {
        foreach ($user->getGroups() as $group) {
            foreach ($group->getPermissions() as $privilege) {
                if ($privilege->getName() === $searchedPrivilege) {
                    return true;
                }
            }
        }

        return false;
    }
}
