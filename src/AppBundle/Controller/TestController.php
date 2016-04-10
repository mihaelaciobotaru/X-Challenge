<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestController extends Controller
{
    public function deleteAction(Request $request, $cid, $id)
    {
           $em = $this->getDoctrine()->getManager();
           $test = $em->getRepository("AppBundle:Test")->find($id);
           
           if($test != null) {
                $isTaken= $test->getUserTests();
                
                if($isTaken != null) {
                    //toastr::alert requester that this test was taken by users
                } else {
                    $em->remove($test);
                    $em->flush();
                }          
           } else {
               //toastr::test does not exist
           }
        return $this->redirect($this->generateUrl('tests',array('cid'=>$cid)));
    }
    
    public function generateAction(Request $request, $cid)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find($cid);      
       
    }

}
