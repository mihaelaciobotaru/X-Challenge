<?php

namespace AppBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class AppExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'app_extension';
    }

    public function getFunctions()
    {
        return array(
            'toastr' => new \Twig_Function_Method($this, 'toastr', array('is_safe' => array('html'))),
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
}