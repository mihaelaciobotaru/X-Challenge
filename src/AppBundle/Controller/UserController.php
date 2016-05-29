<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function getProfileInformationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        if($user == null)
        {
            return $this->redirect($this->generateUrl("home"));
        }
        
        if($user->getType() == User::TYPE_MASTER) {
            $type = "Utilizator Master";
        }
        else if($user->getType() == User::TYPE_APPRENTICE) {
            $type = "Utilizator Apprentice";
        }
        else {
            $type = "Utilizator Administrator";
        }
        
        $rank = $user->getRank();
        $topTests = 0;
        $topActivity = 0;
        $topVotes = 0;
        $tests = $em->getRepository('AppBundle:UserTests')->getTestsForUser($user->getId());
        //var_dump($tests);
        if($rank != null)
        {
            $repo = $em->getRepository('AppBundle:Ranking');
            $topTests =  $repo->getUserInTopForTests($rank->getTestScores());
            $topVotes =  $repo->getUserInTopForVotes($rank->getVoteScores());
            $topActivity =  $repo->getUserInTopForActivity($rank->getActivityScores());

        }
        return $this->render('AppBundle:User:getProfileInformation.html.twig', array(
            'title' => 'Profil',
            'user' => $user,
            'type' => $type,
            'topTests' => $topTests,
            'topVotes' => $topVotes,
            'topActivity' => $topActivity
        ));
    }
    
    public function editProfileAction(Request $request, $id)
    {
        $fn = $request->request->get("firstName");
        $ln = $request->request->get("lastName");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->find($id);
        if($ln != null || $fn != null) {
            $user->setFirstName($fn);
            $user->setLastName($ln);
        }
        $em->persist($user);
        $em->flush();
        return $this->redirect($this->generateUrl("profile",array('id'=>$user->getId())));
    }
}