<?php

namespace AppBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class AppExtension extends \Twig_Extension
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getName()
    {
        return 'app_extension';
    }

    public function getFunctions()
    {
        return array(
            'toastr' => new \Twig_Function_Method($this, 'toastr', array('is_safe' => array('html'))),
            'getVote' => new \Twig_Function_Method($this, 'getVote', array('is_safe' => array('html'))),
            'getTopAnswers' => new \Twig_Function_Method($this, 'getTopAnswers', array('is_safe' => array('html'))),
            'getScore' => new \Twig_Function_Method($this, 'getScore', array('is_safe' => array('html'))),
        );
    }

    public function toastr($type = "{{SESSION}}", $title = null, $content = null)
    {
        $content = str_replace("\n", "<br />", addslashes($content));

        if ($type != null) {
            return '<script type="text/javascript">$(document).ready(function (){ toastr["' . $type . '"]("' . $content . '", "' . $title . '"); });</script>';
        } else {
            return '';
        }
    }

    public function getVote($answer, $user)
    {
        $vote = $this->em->getRepository("AppBundle:Vote")->findOneBy(array("answer" => $answer, "user" => $user));

        if ($vote != null) {
            return $vote->getIsUp();
        } else {
            return 0;
        }
    }

    public function getTopAnswers($challenge)
    {
        $finalAnswers = array();
        $answers = $this->em->getRepository("AppBundle:ChallengeAnswer")->findBy(array("challenge" => $challenge));
        foreach ($answers as $a) {
            $score = 0;
            $votes = $this->em->getRepository("AppBundle:Vote")->findBy(array("answer" => $a));
            foreach ($votes as $v) {
                $score += $v->getIsUp();
            }
            $finalAnswers[$score] = $a;
            /*if (isset($finalAnswers[$score])) {
                $finalAnswers[key($finalAnswers)] = $a;
            } else {
                $finalAnswers[$score] = $a;
            }*/
        }
        ksort($finalAnswers);

        return array_reverse(array_slice($finalAnswers, -3, 3, true));
    }

    public function getScore($answer)
    {
        $score = 0;
        $votes = $this->em->getRepository("AppBundle:Vote")->findBy(array("answer" => $answer));
        foreach ($votes as $v) {
            $score += $v->getIsUp();
        }
        return $score;
    }
}