<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use DN\TMBundle\Form\Type\PageBlockType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class PageBlockAdmin extends Admin {

    private $container;

    public function __construct($code, $class, $baseControllerName, $container = null) {
        parent::__construct($code, $class, $baseControllerName);

        $this->container = $container;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        // todo: implemenet with the existing FormType

        $formMapper
                ->add('id', 'text', array(
                    'label' => 'label.id',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('type', 'choice', array(
                    'label' => 'label.type',
                    'required' => false,
                    'choices' => $this->container->getParameter('page_block_types')
                ))
                ->add('title', 'text', array('label' => 'label.title', 'required' => false))
                ->add('content', 'ckeditor', array(
                    'config' => array(
                        'stylesSet' => 'tm_styles',
                    ),
                    'label' => 'label.content',
                    'required' => false,
                ))
                ->add('image', 'sonata_type_model_list', array(
                    'required' => false,
                    'label' => 'label.image',
                        ), array(
                    'link_parameters' => array('context' => 'page_block')
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('type')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('type')
        ;
    }

}
