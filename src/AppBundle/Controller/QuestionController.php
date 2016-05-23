<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\QuestionType;
use AppBundle\Entity\Question;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class QuestionController extends Controller
{

    public function editAction(Request $request, $cid = -1, $id = -1)
    {
        $sc = $this->get('security.authorization_checker');
        if (!$sc->isGranted("ROLE_MASTER")) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find($cid);
        $error = "";
        $question = null;
        if ($category != null) {
            $question = $em->getRepository("AppBundle:Question")->find($id);

            if ($question != null) {
                $action = "edit";
                $title = "Editeaza intrebare";
            } else {
                $action = "create";
                $title = "Adauga intrebare";
                $question = new Question();
            }

            $form = $this->createForm(QuestionType::class, $question);
            if ($action == "edit") {
                $answerList = json_decode($question->getAnswerList());
                $step = 1;
                foreach($answerList as $answer=>$check) {
                    $form->get("answer".$step)->setData($answer);
                    $form->get("check".$step)->setData($check);
                    $step++;
                }
            }
            if ($request->getMethod() == "POST") {
                $form->handleRequest($request);
                $valid = true;
                if (empty($form->get("text")->getData())) {
                    $error = "Continutul este obligatoriu";
                    $valid = false;
                } elseif (empty($form->get("score")->getData())) {
                    $error = "Punctajul este obligatoriu";
                    $valid = false;
                } elseif(empty($form->get("answer1")->getData()) || empty($form->get("answer2")->getData())
                    || empty($form->get("answer3")->getData())) {
                    $error = "Completati cel putin 3 raspunsuri";
                    $valid = false;
                }
                if ($valid) {
                    $answers = array();

                    for ($i = 1; $i <= 5; $i++) {
                        if (!empty($form->get("answer" . $i)->getData())) {
                            $answers[$form->get("answer" . $i)->getData()] = $form->get("check" . $i)->getData();
                        }
                    }
                    $question->setAnswerList(json_encode($answers));
                    if ($action == "create") {
                        $user = $this->get('security.token_storage')->getToken()->getUser();
                        $question->setUser($user);
                        $question->setCategory($category);
                    }
                    $em->persist($question);
                    $em->flush();
                    if ($action == "create") {
                        $this->get('session')->getFlashBag()->add('success', 'Intrebarea a fost adaugata cu succes');
                    } else {
                        $this->get('session')->getFlashBag()->add('success', 'Intrebarea a fost editata cu succes');
                    }

                    return $this->redirect($this->generateUrl("question_list", array("cid" => $cid)));
                }
            }
        } else {
            $error = "Categoria nu exista";
        }

        return $this->render("AppBundle:Question:edit.html.twig", array(
            "title" => $title,
            "form" => $form->createView(),
            "error" => $error,
        ));
    }

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

        if($cid != -1) {
            $this->get('session')->getFlashBag()->add('success', 'Intrebarea a fost stearsa cu succes');
            return $this->redirect($this->generateUrl('question_list', array('cid'=>$cid)));
        } else {
            return $this->redirect($this->generateUrl('all_question_list'));
        }
    }

    public function listQuestionsPerCategoryAction(Request $request, $cid){

        $category = $this ->getDoctrine()->getRepository('AppBundle:Category')->find($cid);
        $questions = $this->getDoctrine()->getRepository('AppBundle:Question')->findBy(array("category" => $cid));
        $title = "Intrebari din categoria ".$category->getName();

        return $this->render('AppBundle:Question:listQuestions.html.twig', array(
            'questions' => $questions,
            'title' => $title,
            'category' => $category,
        ));
    }

    public function listAllQuestionsAction(){

        $questions = $this->getDoctrine()->getRepository('AppBundle:Question')->findBy(array(), array('createdAt'=>'desc'));
        $title = "Intrebari";
        return $this->render('AppBundle:Question:listAllQuestions.html.twig', array(
                'questions' => $questions, 'title' => $title
            )
        );
    }
    
}
