<?php

namespace DN\TMBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class PageBlockType extends AbstractType {

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
                ->add('rank', 'number', array(
                    'label' => 'label.rank',
                    'required' => false,
                ))
                ->add('content', 'ckeditor', array(
                    'label' => 'label.content',
                    'required' => false,
                ))
//                ->add('image', 'sonata_type_model_list', array(
//                    'required' => false,
//                    'label' => 'label.image',
//                        ), array(
//                    'link_parameters' => array('context' => 'page_block')
//                ))
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
