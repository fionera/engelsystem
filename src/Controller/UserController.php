<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\User;
use Engelsystem\Entity\UserAngelTypes;
use Engelsystem\Form\EditUserType;
use Engelsystem\Service\StructService;
use Kilik\TableBundle\Components\Column;
use Kilik\TableBundle\Components\Table;
use Kilik\TableBundle\KilikTableBundle;
use Kilik\TableBundle\Services\TableService;
use Kilik\TableBundle\Services\TableServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var StructService
     */
    private $structService;
    /**
     * @var TableServiceInterface
     */
    private $tableService;

    /**
     * UserController constructor.
     * @param StructService $structService
     */
    public function __construct(StructService $structService, TableServiceInterface $tableService)
    {
        $this->structService = $structService;
        $this->tableService = $tableService;
    }

    public function getOrganisationTable()
    {
        $queryBuilder = $this->getDoctrine()->getRepository(User::class)->createQueryBuilder('o')
            ->select('o');

        $table = (new Table())
            ->setRowsPerPage(15)// custom rows per page
            ->setId('tabledemo_organisation_list')
            ->setPath('')
            ->setQueryBuilder($queryBuilder, 'o')
            ->addColumn(
                (new Column())->setLabel('Name')
                    ->setSort(['o.name' => 'asc'])
//                    ->setFilter(
//                        (new Filter())
//                            ->setField('o.name')
//                            ->setName('o_name')
//                    )
            );

        return $table;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $table = $this->getOrganisationTable();

        return $this->render('user/index.html.twig', [
            'table' => $this->tableService->createFormView($table),
        ]);
    }

    /**
     * @Route("/user/{id<\d+>}", name="user_view")
     */
    public function view(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('user/view.html.twig', [
            'user' => $this->structService->getUserStruct($user)
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function edit(int $id, Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $userForm = $this->createForm(EditUserType::class, $user);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $userAngelTypeCollection = new ArrayCollection();
            /** @var AngelType $angelType */
            foreach ($userForm->get('angelTypes')->getData() as $angelType) {
                if ($angelType->getNoSelfSignup()) {
                    continue;
                }

                $userAngelType = new UserAngelTypes();
                $userAngelType->setUser($user);
                $userAngelType->setAngelType($angelType);

                if (!$angelType->getRestricted()) {
                    $userAngelType->setConfirmUser($user);
                }

                $userAngelTypeCollection->add($userAngelType);
            }
            $user->setUserAngelTypes($userAngelTypeCollection);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', array(
            'userForm' => $userForm->createView(),
        ));
    }

    /**
     * @Route("/user/{id}/arrived", name="user_arrived")
     */
    public function arrived(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $user->setArrived(true);
        $user->setArrivalDate(new \DateTime());

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
    }

    /**
     * @Route("/user/{id}/unarrived", name="user_unarrived")
     */
    public function unarrived(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $user->setArrived(false);
        $user->setArrivalDate(null);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
    }

    /**
     * @Route("/user/{id}/add_voucher", name="user_add_voucher")
     */
    public function addVoucher(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $user->setVoucher($user->getVoucher() + 1);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
    }

    /**
     * @Route("/user/{id}/remove_voucher", name="user_remove_voucher")
     */
    public function removeVoucher(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        if ($user->getVoucher() <= 0) {
            $user->setVoucher(0);
        } else {
            $user->setVoucher($user->getVoucher() - 1);
        }


        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
    }

    /**
     * @Route("/user/{id}/resetApiKey", name="user_reset_api_key")
     */
    public function reset_apiKey(int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $user->resetApiKey();

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_view', ['id' => $user->getId()]);
    }
}
