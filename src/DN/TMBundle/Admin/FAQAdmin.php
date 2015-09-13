<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FAQAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('id', 'text', array(
                    'label' => 'label.id',
                    'required' => false,
                    'read_only' => true,
                    'disabled' => true,
                ))
                ->add('question', 'text', array('label' => 'label.question', 'required' => true))
                ->add('answer', 'ckeditor', array(
                    'label' => 'label.answer',
                    'required' => true,
                ))
                ->add('faqCategory', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\FAQCategory',
                    'label' => 'label.faqCategory',
                    'required' => false
                ))
                ->add('category', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\Category',
                    'label' => 'label.category',
                    'required' => false,
                    'property' => 'detailedName',
                ))
                ->add('subcategory', 'entity', array(
                    'class' => 'DN\TMBundle\Entity\Category',
                    'label' => 'label.subcategory',
                    'required' => false,
                    'property' => 'detailedName',
                ))
                ->add('additionalCategories', 'sonata_type_model', array(
                    'multiple' => true,
                    'label' => 'label.additionalCategories',
                    'required' => false,
                    'btn_add' => false,
                    'property' => 'detailedName',
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('question')
                ->add('answer')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('question')
                ->add('answer')
        ;
    }

}
