<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuestionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('text', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label"=>"Continut",
                                                'label_attr' => array('class' => 'col-sm-2 control-label')))
            ->add('score', IntegerType::Class, array("attr" => array("class" => "form-control"), "label" => "Punctaj",
                                                    'label_attr' => array('class' => 'col-sm-2 control-label')))
            ->add('answer1', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label" => "Raspuns 1",
                                                    'label_attr' => array('class' => 'col-sm-2 control-label'), "mapped" => false))
            ->add('check1', CheckboxType::Class, array("mapped" => false, "required" => false))
            ->add('answer2', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label" => "Raspuns 2",
                                                    'label_attr' => array('class' => 'col-sm-2 control-label'), "mapped" => false))
            ->add('check2', CheckboxType::Class, array("mapped" => false, "required" => false))
            ->add('answer3', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label" => "Raspuns 3",
                                                        'label_attr' => array('class' => 'col-sm-2 control-label'), "mapped" => false))
            ->add('check3', CheckboxType::Class, array("mapped" => false, "required" => false))
            ->add('answer4', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label" => "Raspuns 4",
                                                        'label_attr' => array('class' => 'col-sm-2 control-label'), "mapped" => false,
                                                        "required" => false))
            ->add('check4', CheckboxType::Class, array("mapped" => false, "required" => false))
            ->add('answer5', TextAreaType::Class, array("attr" => array("class" => "form-control"), "label" => "Raspuns 5",
                                                        'label_attr' => array('class' => 'col-sm-2 control-label'), "mapped" => false,
                                                        "required" => false))
            ->add('check5', CheckboxType::Class, array("mapped" => false, "required" => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }
}
