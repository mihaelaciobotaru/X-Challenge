<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ChallengeController extends Controller
{
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $challenge = $em->getRepository("AppBundle:Challenge")->find($id);
           
           if($challenge != null) {
                $em->remove($challenge); //should also remove answers and votes and update the voteScores from Ranking (substract the number of ((isUp = true) - (isUp = false))
                $em->flush();
           } else {
               //toastr::challenge does not exists
           }   
           return $this->render('AppBundle:Challenge:index.html.twig');
    }

}