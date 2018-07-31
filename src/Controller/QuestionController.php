<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\Question;
use Engelsystem\Form\AnswerQuestionType;
use Engelsystem\Form\AskQuestionType;
use Engelsystem\Service\StructService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;

    /**
     * QuestionController constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService)
    {
        $this->structService = $structService;
    }

    /**
     * @Route("/question", name="question")
     */
    public function index(Request $request)
    {
        $question = new Question();
        $questionForm = $this->createForm(AskQuestionType::class, $question);

        $questionForm->handleRequest($request);
        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question->setAskUser($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($question);
            $manager->flush();

            return $this->redirectToRoute('question');
        }

        $questionList = $this->getDoctrine()->getRepository(Question::class)->findBy(['ask_user' => $this->getUser()]);
        $openQuestions = [];
        $answeredQuestions = [];

        foreach ($questionList as $question) {
            if ($question->getAnswerUser() === null && $question->getAnswer() === null) {
                $openQuestions[] = $this->structService->getQuestionStruct($question);
            } else {
                $answeredQuestions[] = $this->structService->getQuestionStruct($question);
            }
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'AskController',
            'openQuestions' => $openQuestions,
            'answeredQuestions' => $answeredQuestions,
            'questionForm' => $questionForm->createView()
        ]);
    }

    /**
     * @Route("/question/{id<\d+>}/remove", name="question_remove")
     */
    public function remove(int $id)
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->find($id);

        if ($question === null) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($question);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('question');
    }

    /**
     * @Route("/question/answer", name="question_answer")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function answer()
    {
        $questionList = $this->getDoctrine()->getRepository(Question::class)->findAll();
        $openQuestions = [];
        $answeredQuestions = [];

        foreach ($questionList as $question) {
            if ($question->getAnswerUser() === null && $question->getAnswer() === null) {
                $openQuestions[] = array_merge($this->structService->getQuestionStruct($question), [
                    'form' => $this->createForm(AnswerQuestionType::class, null, [
                        'action' => $this->generateUrl('question_answer_post', ['id' => $question->getId()])
                    ])->createView()
                ]);
            } else {
                $answeredQuestions[] = $this->structService->getQuestionStruct($question);
            }
        }

        return $this->render('question/answer.html.twig', [
            'controller_name' => 'AskController',
            'openQuestions' => $openQuestions,
            'answeredQuestions' => $answeredQuestions
        ]);
    }

    /**
     * @Route("/question/answer/{id}", name="question_answer_post", methods={"POST"})
     * @param int|null $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function answerPost(Request $request, int $id)
    {
        $answeredQuestion = $this->getDoctrine()->getRepository(Question::class)->find($id);

        if ($answeredQuestion === null) {
            throw $this->createNotFoundException();
        }

        if ($answeredQuestion->getAnswer() !== null || $answeredQuestion->getAnswerUser() !== null) {
            $this->addFlash('notice', 'Already answered');
            return $this->redirectToRoute('question');
        }

        $questionForm = $this->createForm(AnswerQuestionType::class, $answeredQuestion, [
            'action' => $this->generateUrl('question_answer_post', ['id' => $id])
        ]);

        $questionForm->handleRequest($request);
        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $answeredQuestion->setAnswerUser($this->getUser());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($answeredQuestion);
            $manager->flush();

            return $this->redirectToRoute('question_answer');
        }

        return $this->redirectToRoute('question_answer');
    }
}
