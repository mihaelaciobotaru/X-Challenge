<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextareaType::class, array("attr" => array("class" => "form-control"), "label"=>"Titlul testului",
                                                'label_attr' => array('class' => 'col-sm-2 control-label')))
            ->add('time', IntegerType::class, array("attr" => array("class" => "form-control"), "label"=>"Durata testului",
                                                'label_attr' => array('class' => 'col-sm-2 control-label')))
            ->add('noOfQuestions', IntegerType::class, array("attr" => array("class" => "form-control"), "label"=>"Numar de intrebari",
                                                'label_attr' => array('class' => 'col-sm-2 control-label')))
        ;
    }
   
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Test'
        ));
    }
}
