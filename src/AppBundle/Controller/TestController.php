<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Test;
use AppBundle\Entity\Question;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TestType;
use Doctrine\ORM;

class TestController extends Controller
{
    public function deleteAction($cid, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository("AppBundle:Test")->find($id);
        if ($test != null) {
            $questions = $test->getQuestions();
            
            foreach ($questions as &$value) {
                $question = $em->getRepository("AppBundle:Question")->find($value->getId());
                $question->setTest(null);
            }
                $em->remove($test);
                $em->flush();

        } else {
            //toastr::test does not exist
        }
        return $this->redirect($this->generateUrl('test_list', array('cid' => $cid)));
    }

        public function generateAction(Request $request, $cid)
        {
            $title = "Genereaza test";
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository("AppBundle:Category")->find($cid);
            $test = new Test();
                $error = null;


            $form = $this->createForm(TestType::class, $test);

            if ($request->getMethod() == "POST") {
                $form->handleRequest($request);
                $valid = true;
                if (empty($form->get("title")->getData())) {
                    $error = "Titlul este obligatoriu";
                    $valid = false;
                } elseif (empty($form->get("time")->getData())) {
                    $error = "Durata este obligatorie";
                    $valid = false;
                } elseif (empty($form->get("noOfQuestions")->getData())) {
                    $error = "Numarul de intrebari este obligatoriu";
                    $valid = false;
                }
                if ($valid) {
                    $no = $form->get("noOfQuestions")->getData();
                    $queryID = $this->getDoctrine()->getRepository('AppBundle:Question')->getNullQuestions($cid);
                    $questid = array();
                    foreach($queryID as $q) {
                        $questid[] = $q->getID();
                    }

                    if(count($questid) >= $no) {
                        shuffle($questid);
                        $togetarray = array_slice($questid,0,$no);
                        $questions = $this->getDoctrine()->getRepository('AppBundle:Question')
                                    ->getRandomQuestions($togetarray);
                        $score = 0;

                        foreach ($questions as $q) {
                            $score += $q['score'];
                        }

                        $user = $this->get('security.token_storage')->getToken()->getUser();
                        $test->setUser($user);
                        $test->setCategory($cid);
                        $test->setTotalScore($score);
                        $em->persist($test);
                        $em->flush();

                        $maxid = $this->getDoctrine()->getManager()
                            ->getRepository('AppBundle:Test')
                            ->getMaxID();
                        foreach ($questions as $q) {
                            $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($q['id']);
                            $testid = $this->getDoctrine()->getRepository('AppBundle:Test')->find($maxid[1]);
                            $question->setTest($testid);
                            $em->persist($question);
                        }

                        $em->flush();

                        $this->get('session')->getFlashBag()->add('success', 'Testul a fost creat cu succes');

                        return $this->redirect($this->generateUrl("test_list", array("cid" => $cid)));
                    }
                    else{
                        $msg = 'Intreberi insuficiente. Total intrebari disponibile: '.count($questid);
                        $this->get('session')->getFlashBag()->add('error', $msg );
                        
                        return $this->redirect($this->generateUrl("question_list", array("cid" => $cid)));
                    }
                }
        }

        return $this->render("AppBundle:Test:generateTest.html.twig", array(
            "title" => $title,
            "form" => $form->createView(),
            "error" => $error,
        ));
    }



    public function listTestsPerCategoryAction($cid)
    {
        $category = $this ->getDoctrine()->getRepository('AppBundle:Category')->find($cid);
        $tests = $this->getDoctrine()->getRepository('AppBundle:Test')->findBy(array("category" => $cid));

        $title = "Teste din categoria ".$category->getName();
        return $this->render(
            'AppBundle:Test:listTests.html.twig',
            array('tests' => $tests, 'title' => $title, 'category' => $category));

    }
    
    public function showQuestionsInTestAction($tid){
        $title = "Vizualizare test";
        $test = $this->getDoctrine()->getRepository('AppBundle:Test')->find($tid);
        $questions = $this->getDoctrine()->getRepository('AppBundle:Question')->findBy(array("test" => $tid));
        $answers = array();
        foreach($questions as $q){
            $answers[$q->getID()] = json_decode($q->getAnswerList(), true);
        }
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $categno = array();
        foreach($category as $c){
            $categno[$c->getID()] = $c->getName();
        }
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $userno = array();
        foreach($users as $u){
            $username = $u->getFirstName()." ".$u->getLastName();
            $userno[$u->getID()] = $username;
        }
        return $this->render('AppBundle:Test:listQuestionsinTest.html.twig', 
            array('questions' => $questions, 'test' => $test, 'answers' => $answers, 'title' => $title, 'categories' => $categno, 'users' => $userno
                            ));
    }

    public function listAllTestsAction(){
        $title = "Teste";
        $tests = $this->getDoctrine()->getRepository('AppBundle:Test')->findBy(array(), array('category' => 'asc', 'createdAt'=>'desc'));
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $categno = array();
        foreach($category as $c){
            $categno[$c->getID()] = $c->getName();
        }
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $userno = array();
        foreach($users as $u){
            $username = $u->getFirstName()." ".$u->getLastName();
            $userno[$u->getID()] = $username;
        }
        return $this->render('AppBundle:Test:listAllTests.html.twig', array(
                'tests' => $tests, 'title' => $title, 'categories' => $categno, 'users' => $userno
            )
        );

    }
}
