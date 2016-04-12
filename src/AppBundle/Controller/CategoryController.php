<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="categorii")
     */
    public function listCategoriesAction(){
        
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findBy(array(), array('name'=>'asc'));
        $title = "Categorii";
        return $this->render(
            'AppBundle:Category:listCategories.html.twig',
            array('categories' => $categories, 'title' => $title));
    }
}
