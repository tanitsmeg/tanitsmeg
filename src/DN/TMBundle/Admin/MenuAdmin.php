<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MenuAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('title', 'text', array('label' => 'title', 'required' => false))
                ->add('parent', 'sonata_type_model', array('label' => 'parent', 'required' => false))
                ->add('customPage', 'sonata_type_model', array('label' => 'custom page', 'required' => false))
                ->add('rank', 'integer', array('label' => 'rank', 'required' => false))
                ->add('active', 'checkbox', array('label' => 'active', 'required' => false))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('title')
                ->add('parent')
                ->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('title')
                ->add('parent')
                ->add('rank', 'integer', array('label' => 'rank'))
                ->add('active')
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection
                ->remove('create')
                ->remove('delete')
                ->remove('edit')
        ;
    }

//    protected function configureRoutes(RouteCollection $collection) {
////        $collection->remove('delete');
////        $collection->clearExcept(array('list', 'show'));
//    }
}
