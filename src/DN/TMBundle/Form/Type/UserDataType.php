<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Form\Type\CourseTimeType;
use DN\TMBundle\Form\Type\LocationType;

class UserDataType extends AbstractType {

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
                    'required' => false,
                ))
                ->add('email', 'text', array(
                    'label' => 'email',
                    'required' => false,
                ))
                ->add('password', 'password', array(
                    'label' => 'password',
                    'required' => false,
                ))
                ->add('birthyear', 'text', array(
                    'label' => 'birthyear',
                    'required' => false,
                ))
                ->add('birthyearPublic', 'text', array(
                    'label' => 'birthyearPublic',
                    'required' => false,
                ))
                ->add('gender', 'text', array(
                    'label' => 'gender',
                    'required' => false,
                ))
                ->add('genderPublic', 'text', array(
                    'label' => 'genderPublic',
                    'required' => false,
                ))
                ->add('description', 'text', array(
                    'label' => 'description',
                    'required' => false,
                ))
                ->add('description2', 'text', array(
                    'label' => 'description2',
                    'required' => false,
                ))
                ->add('favoriteTags', 'entity', array(
                    'label' => 'tags',
                    'class' => 'DN\TMBundle\Entity\Tag',
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Save',
                ))
        ;
    }

    public function getName() {
        return 'user_data';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\User',
        ));
    }

}
