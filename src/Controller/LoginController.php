<?php

namespace Engelsystem\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Engelsystem\Entity\AngelType;
use Engelsystem\Entity\User;
use Engelsystem\Entity\UserAngelTypes;
use Engelsystem\Form\LoginType;
use Engelsystem\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $loginForm = $this->createForm(LoginType::class, null, [
            'lastUsername' => $authenticationUtils->getLastUsername(),
            'action' => $this->generateUrl('login')
        ]);

        return $this->render('login/login.html.twig', array(
            'loginForm' => $loginForm->createView(),
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('index');
        }

        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);

        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {

            $userAngelTypeCollection = new ArrayCollection();
            /** @var AngelType $angelType */
            foreach ($registerForm->get('angelTypes')->getData() as $angelType) {
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

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setCreateDate(new \DateTime());
            $user->resetApiKey();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('login/register.html.twig', array(
            'registerForm' => $registerForm->createView(),
        ));
    }
}
