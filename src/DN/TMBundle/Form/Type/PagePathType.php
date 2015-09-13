<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagePathType extends AbstractType {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('type', 'choice', array(
                    'label' => 'label.type',
                    'required' => false,
                    'choices' => $this->container->getParameter('page_block_types')
                ))
//                ->add('type', 'text', array(
//                    'label' => 'label.type',
//                    'required' => false,
//                ))
                ->add('rank', 'number', array(
                    'label' => 'label.rank',
                    'required' => false,
                ))
                ->add('content', 'ckeditor', array(
                    'label' => 'label.content',
                    'required' => false,
                ))
                ->add('parameters', 'collection', array(
                    'type' => new PageBlockParameterType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
        ;
    }

    public function getName() {
        return 'page_block';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DN\TMBundle\Entity\PageBlock',
        ));
    }

}
