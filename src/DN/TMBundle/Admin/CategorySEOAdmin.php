<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CategorySEOAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('page_type', 'choice', array(
                    'label' => 'label.type',
                    'required' => true,
                    'choices' => array(
                        'product' => 'product',
                        'article' => 'article',
                        'news' => 'news',
                        'video' => 'video',
                        'trainer' => 'trainer',
                        'faq' => 'faq',
                    )
                ))
                ->add('overviewCategory', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\Category',
                    'label' => 'label.category',
                    'required' => true,
                    'property' => 'detailedName',
                ))
                ->add('seoTitle', 'text', array(
                    'label' => 'label.seo title',
                    'required' => false,
                ))
                ->add('seoText', 'textarea', array(
                    'label' => 'label.seo description',
                    'required' => false,
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
        ;
    }

}
