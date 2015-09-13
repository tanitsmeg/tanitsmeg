<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ImportMediaAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id', 'text', array(
                    'label' => 'label.id',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('filename', 'text', array(
                    'label' => 'label.filename',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('url', 'text', array(
                    'label' => 'label.url',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('kbNumber', 'text', array(
                    'label' => 'label.kbNumber',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('kbDate', 'text', array(
                    'label' => 'label.kbDate',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('product', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\Product',
                    'label' => 'label.product',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('filename')
                ->add('kbNumber')
                ->add('kbDate')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('filename')
                ->add('kbNumber')
                ->add('kbDate')
                ->add('product.title', null, array(
                    'sortable' => true,
                ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
//        $collection
//                ->remove('create')
//                ->remove('delete')
//                ->remove('edit')
//        ;
    }

//    protected function configureRoutes(RouteCollection $collection) {
////        $collection->remove('delete');
////        $collection->clearExcept(array('list', 'show'));
//    }
}
