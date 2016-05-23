<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

class AdminController extends Controller
{
    /**
     * @Route("/users", name="utilizatori")
     */
    public function listUsersAction($type = 2)
    {

        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->getUsersByType($type);
        if($type == User::TYPE_MASTER) {
            $title = "Utilizatori Master";
        }
        else if($type == User::TYPE_APPRENTICE) {
            $title = "Utilizatori Apprentice";
        }
        else if($type == User::TYPE_ADMIN) {
            $title = "Utilizatori Administratori";
        }

        return $this->render('AppBundle:Admin:listUsers.html.twig', array(
            'users' => $users,
            'title' => $title
        ));
    }

    public function manageUserActivationAction($id, $isActive)
    {

        $sc = $this->get('security.authorization_checker');
        if (!$sc->isGranted("ROLE_ADMIN")) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->find($id);

        if($user !== null)
        {
            $user->setIsActive($isActive);
        }
        else
        {
            //toastr:: user-ul nu exista
        }

        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('users', array("type"=>User::TYPE_MASTER)));
    }

    public function  updateApprenticeToMasterAction($id)
    {
        $sc = $this->get('security.authorization_checker');
        if (!$sc->isGranted("ROLE_ADMIN")) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->find($id);

        if($user !== null)
        {
            $score = $em->getRepository("AppBundle:Ranking")->findOneBy(array("user"=>$id));
            $totalScore = $score->getTestScores + $score->getActivityScores + $score->getVoteScores;
            if($totalScore > 2000 && $user->getType == User::TYPE_APPRENTICE) {
                $user->setType(User::TYPE_MASTER);
                }
        }
        else
        {
            //toastr:: user-ul nu exista
        }

        $em->persist($user);
        $em->flush();
    }
}
