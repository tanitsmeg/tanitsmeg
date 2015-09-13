<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class UserLoginType extends AbstractType {

//    private $container;
//
//    public function __construct(Container $container) {
//        $this->container = $container;
//    }
//
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'text', array(
                    'label' => 'email',
                    'required' => true,
                ))
                ->add('password', 'password', array(
                    'label' => 'password',
                    'required' => true,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Login',
                ))
        ;
    }

    public function getName() {
        return 'user_login';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\User',
        ));
    }

}
