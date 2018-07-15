<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\User;
use Engelsystem\Entity\UserAngelTypes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AngeltypesController extends Controller
{
    /**
     * @Route("/angeltypes", name="angeltypes")
     */
    public function index()
    {
        return $this->render('angeltypes/index.html.twig', [
            'angelTypeList' => $this->getAngeltypes()
        ]);
    }

    protected function getAngeltypeStruct(AngelType $angelType)
    {
        return array_merge([
            'id' => $angelType->getId(),
            'name' => $angelType->getName(),
            'contactName' => $angelType->getContactName(),
            'contactDECT' => $angelType->getContactDect(),
            'contactEmail' => $angelType->getContactEmail(),
            'noSelfSignup' => $angelType->getNoSelfSignup(),
            'requiresDriverLicense' => $angelType->getRequiresDriverLicense(),
            'restricted' => $angelType->getRestricted(),
        ], $this->isUserMember($angelType));
    }

    /**
     * @param AngelType $angelType
     * @return array ['member' => true, 'memberAwait' => true]
     */
    protected function isUserMember(AngelType $angelType): array
    {
        $memberState = [
            'member' => false,
            'memberAwait' => false,
        ];

        $user = $this->getUser();
        if ($user instanceof User) {
            /** @var UserAngelTypes $userAngelType */
            foreach ($user->getUserAngelTypes()->toArray() as $userAngelType) {
                if ($userAngelType->getAngelType() === $angelType) {
                    $memberState['member'] = true;

                    if ($userAngelType->getConfirmUser() === null && $userAngelType->isCoordinator() !== true) {
                        $memberState['memberAwait'] = true;
                    }

                    return $memberState;
                }
            }
        }

        return $memberState;
    }

    protected function getAngeltypes()
    {
        $angelTypes = $this->getDoctrine()->getRepository(AngelType::class)->findAll();

        return array_map([$this, 'getAngeltypeStruct'], $angelTypes);
    }
}
