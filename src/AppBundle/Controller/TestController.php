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

    public function listTestsPerCategoryAction(Request $request, $cid)
    {
        $category = $this ->getDoctrine()->getRepository('AppBundle:Category')->find($cid);
        $tests = $this->getDoctrine()->getRepository('AppBundle:Test')->findBy(array("category" => $cid));
        $title = "Teste din categoria ".$category->getName();
        return $this->render(
            'AppBundle:Test:listTests.html.twig',
            array('tests' => $tests, 'title' => $title, 'category' => $category));

    }

}
