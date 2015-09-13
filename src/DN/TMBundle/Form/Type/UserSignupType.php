<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class UserSignupType extends AbstractType {

//    private $container;
//
//    public function __construct(Container $container) {
//        $this->container = $container;
//    }
//
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'név',
                    'required' => true,
                ))
                ->add('email', 'text', array(
                    'label' => 'email',
                    'required' => true,
                ))
                ->add('password', 'password', array(
                    'label' => 'password',
                    'required' => true,
                ))
                ->add('password2', 'password', array(
                    'label' => 'password2',
                    'mapped' => false,
                    'required' => true,
                ))
                ->add('terms', 'checkbox', array(
                    'label' => 'label.accept_terms',
                    'mapped' => false,
                    'required' => true,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'user_signup';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\User',
        ));
    }

}
