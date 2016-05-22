<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    public function registerAction(Request $request)
    {
        $sc = $this->get('security.authorization_checker');
        if ($sc->isGranted("ROLE_USER")) {
            return $this->redirect($this->generateUrl("home"));
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);

            $valid = $form->isValid();
            if (!$valid) {
                $this->get('session')->getFlashBag()->add('error', 'Va rugam completati cu atentie toate campurile');
            }
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository("AppBundle:User");
            if($repo->findOneBy(array("username" => $form->get("username")->getData()))
                || $repo->findOneBy(array("email" => $form->get("email")->getData()))) {
                $valid = false;
                $this->get('session')->getFlashBag()->add('error', 'Username sau Email existent');
            }

            if ($valid) {
                $passwordEncoder = $this->container->get('security.password_encoder');
                $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encodedPassword);
                if($form->get("type")->getData() == User::TYPE_MASTER) {
                    $user->setIsActive(false);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                if($user->getType() == User::TYPE_MASTER) {
                    $this->get('session')->getFlashbag()->add('success', 'Cont creat cu succes. Activare in curs de catre administrator.');
                }
                return $this->redirectToRoute('security_login');
            }
        }

        return $this->render('AppBundle:Security:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function loginAction()
    {
        $sc = $this->get('security.authorization_checker');

        if ($sc->isGranted("ROLE_USER")) {
            return $this->redirect($this->generateUrl("home"));
        }

        $helper = $this->get('security.authentication_utils');
        return $this->render('AppBundle:Security:login.html.twig', array(
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
        ));
    }


    public function autoLoginAction($username, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findByUserNameOrEmail($username);
        
        if (!$user) {
            throw $this->createNotFoundException('No user!');
        }
        $firewallKey = 'secured_area';
        $authenticator = $this->container->get('app.form_login_authenticator');
        $guardHandler = $this->container->get('security.authentication.guard_handler');
        $successResponse = $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            $firewallKey
        );
        return $successResponse;
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}
