<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CourseOrderAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id', 'text', array('label' => 'label.id', 'required' => false))
                ->add('status', 'text', array('label' => 'label.status', 'required' => false))
                ->add('course', 'entity', array('label' => 'label.course', 'required' => false))
                ->add('user', 'entity', array('label' => 'label.user', 'required' => false))
                ->add('comment', 'text', array('label' => 'label.comment', 'required' => false))
                ->add('email', 'text', array('label' => 'label.email', 'required' => false))
                ->add('phone', 'text', array('label' => 'label.phone', 'required' => false))
                ->add('fullname', 'text', array('label' => 'label.fullname', 'required' => false))
                ->add('price', 'text', array('label' => 'label.price', 'required' => false))
                ->add('priceType', 'text', array('label' => 'label.priceType', 'required' => false))
                ->add('paymentMethod', 'text', array('label' => 'label.paymentMethod', 'required' => false))
                ->add('created', 'text', array('label' => 'label.created', 'required' => false))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('status')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('status')
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection
                ->remove('create')
                ->remove('delete')
        ;
    }

}
