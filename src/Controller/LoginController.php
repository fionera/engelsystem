<?php

namespace Engelsystem\Controller;

use Engelsystem\Entity\User;
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
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
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

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setCreateDate(new \DateTime());
            $user->setApiKey('');

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
