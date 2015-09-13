<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CourseAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id', 'text', array('label' => 'label.id', 'required' => false))
                ->add('title', 'text', array('label' => 'label.title', 'required' => true))
                ->add('description', 'text', array('label' => 'label.description', 'required' => false))
                ->add('description2', 'text', array('label' => 'label.description2', 'required' => false))
                ->add('description3', 'text', array('label' => 'label.description3', 'required' => false))
                ->add('minParticipant', 'text', array('label' => 'label.minParticipant', 'required' => false))
                ->add('maxParticipant', 'text', array('label' => 'label.maxParticipant', 'required' => false))
                ->add('price', 'text', array('label' => 'label.price', 'required' => false))
                ->add('priceType', 'text', array('label' => 'label.priceType', 'required' => false))
                ->add('active', 'text', array('label' => 'label.active', 'required' => false))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
                ->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('title')
                ->add('active')
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection
                ->remove('create')
                ->remove('delete')
        ;
    }

}
