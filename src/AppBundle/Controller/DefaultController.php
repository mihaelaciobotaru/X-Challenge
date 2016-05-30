<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ChallengeType;
use AppBundle\Entity\Challenge;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $sc = $this->get('security.authorization_checker');
        if (!$sc->isGranted("ROLE_USER")) {
            return $this->redirect($this->generateUrl("security_login"));
        }

        $title = "Acasa";
        $user = $this->getUser()->getID();
        $hasTests = $this->getDoctrine()->getRepository('AppBundle:UserTests')->findOneBy(['user' => $user]);
        
        $em = $this->getDoctrine()->getManager();
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
            if ($request->getMethod() == "POST") {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $user = $this->get('security.token_storage')->getToken()->getUser();
                    $challenge->setUser($user);

                    $em->persist($challenge);
                    $em->flush();
                
                } else {
                    //toastr::form is not valid
                }
            }
        return $this->render('AppBundle::index.html.twig', [
            'title' => $title, 'hasTests' => $hasTests, "form" => $form->createView()
        ]);
    }
    
    public function regulationsAction()
    {
        return $this->render('AppBundle::regulations.html.twig', ['title' => 'Regulament']);
    }
}
