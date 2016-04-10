<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/index", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $title = "Acasa";
        $user = $this->getUser()->getID();
        $hasTests = $this->getDoctrine()->getRepository('AppBundle:UserTests')->findOneBy(['user' => $user]);

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'), 'title' => $title, 'hasTests' => $hasTests
        ]);
    }
}
