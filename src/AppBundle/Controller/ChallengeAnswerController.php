<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Vote;
use AppBundle\Entity\Ranking;

class ChallengeAnswerController extends Controller
{
    function voteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $answerId = intval($request->get("answer_id"));
        $score = intval($request->get("score"));
        $answer = $em->getRepository("AppBundle:ChallengeAnswer")->find($answerId);
        if (!empty($answerId) && !empty($score)) {
            $vote = $em->getRepository("AppBundle:Vote")->findOneBy(array("answer" => $answer, "user" => $user));
            if ($vote == null) {
                $vote = new Vote();
                $vote->setAnswer($answer);
                $vote->setUser($user);
            }
            $vote->setIsUp($score);
            $em->persist($vote);
            $rank = $em->getRepository("AppBundle:Ranking")->findOneBy(array("user" => $answer->getUser()));
            $new = false;
            if ($rank == null) {
                $rank = new Ranking();
                $rank->setUser($answer->getUser());
                $new = true;
            }
            $rank->setVoteScores($score);
            $em->persist($rank);
            $em->flush();

            if ($new == true) {
                $user = $answer->getUser();
                $user->setRank($rank);
                $em->persist($user);
                $em->flush();
            }

            return new JsonResponse(["error" => false]);
        } else {
            return new JsonResponse(["error" => true]);
        }

    }
}
