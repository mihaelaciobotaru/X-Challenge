<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\QuestionType;
use AppBundle\Entity\Question;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class QuestionController extends Controller
{
    public function editAction(Request $request, $cid = 1, $id = -1)
    {
        $sc = $this->get('security.authorization_checker');
        if (!$sc->isGranted("ROLE_MASTER")) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->find($cid);

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
            if ($request->getMethod() == "POST") {
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $answers = array();

                    for ($i = 1; $i <= 5; $i++) {
                        if ($form->has("answer" . $i) && !empty($form->get("answer" . $i)->getData())) {
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
                } else {
                    //toastr::form is not valid
                }
            }
        } else {
            //toastr::category does not exist
        }

        return $this->render("AppBundle:Question:edit.html.twig", array(
            "title" => $title,
            "form" => $form->createView(),
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

        return $this->redirect($this->generateUrl('questions', array('cid'=>$cid)));
    }
}
