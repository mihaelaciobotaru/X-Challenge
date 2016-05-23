<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Challenge;
use AppBundle\Entity\ChallengeAnswer;

class ChallengeController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $title = "Challenges";
        $repo = $em->getRepository("AppBundle:Challenge");
        $createdGroups = $repo->getGroupByCreated();

        $challenges = array();
        $tDayChallenges = array();
        foreach ($createdGroups as $c) {
            $date =  $c["created"]->format("d M Y");
            $current = new \DateTime("now");
            if ($date == $current->format("d M Y")) {
                $tDayChallenges = $repo->getAllByDate($c["created"]);
                /*foreach ($tDayChallenges as $t) {
                    var_dump($t->getId());

                }*/
            } else {
                $challenges[$date] = $repo->getAllByDate($c["created"]);
            }
        }
        return $this->render("AppBundle::index.html.twig", array(
            "title" => $title,
            "tDayChallenges" => $tDayChallenges,
            "challengesByTime" => $challenges,
        ));
    }

    public function addAction(Request $request)
    {
        if ($request->request->get("title") != NULL) {
            $em = $this->getDoctrine()->getManager();

            $challenge = new Challenge();
            $challenge->setTitle($request->request->get("title"));
            $challenge->setText($request->request->get("content"));
            $challenge->setCreatedAt(new \DateTime("now"));
            $challenge->setCreatedTime(new \DateTime("now"));
            $challenge->setUser($this->getUser());

            $em->persist($challenge);
            $em->flush();

            $result = array();
            $result["id"] = $challenge->getId();
            $result["created_at"] = $challenge->getCreatedAt()->format("H:m");

            return new JsonResponse(["error" => false, "challenge" => $result]);
        } else {
            return new JsonResponse(["error" => true]);
        }
    }

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

    public function addAnswerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $challengeId = $request->request->get("challengeId");
        $content = $request->request->get("answerContent");

        $challenge = $em->getRepository("AppBundle:Challenge")->find($challengeId);
        if ($challenge != null) {
            $challengeAnswer = new ChallengeAnswer();
            $challengeAnswer->setAnswer($content);
            $challengeAnswer->setCreatedAt(new \DateTime("now"));
            $challengeAnswer->setUser($this->getUser());
            $challengeAnswer->setChallenge($challenge);

            $em->persist($challengeAnswer);
            $em->flush();
            return new JsonResponse(["error" => false]);
        } else {
            return new JsonResponse(["error" => true]);
        }
    }

    public function viewAnswersAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $challenge = $em->getRepository("AppBundle:Challenge")->find($id);

        if ($challenge != null) {
            return $this->render("AppBundle:Challenge:answers.html.twig", array(
                "title" => "Answers",
                "challenge" => $challenge,
            ));
        } else {

        }
    }

}