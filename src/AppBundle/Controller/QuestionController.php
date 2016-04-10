<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class QuestionController extends Controller
{
    public function deleteAction(Request $request, $cid, $id)
    {
           $em = $this->getDoctrine()->getManager();
           $question = $em->getRepository("AppBundle:Question")->find($id);
           
           if($question != null) {
                $em->remove($question);
                $em->flush();
           } else {
               //toastr::question does not exists
           }   
           return $this->redirect($this->generateUrl('questions', array('cid'=>$cid));
          
    }
}
