<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use DN\TMBundle\Form\Type\CourseType;

class ProductAdmin extends Admin {

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        // TODO: This should be in the repository, check if it's possible
        $query = $this->modelManager->getEntityManager('DN\TMBundle\Entity\Category')->createQuery('SELECT c FROM DN\TMBundle\Entity\Category c WHERE c.active = true');
        
        $formMapper
            ->tab('General')
                ->with('Product')
                    ->add('id', 'text', array(
                        'label' => 'label.id',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('title', 'text', array(
                        'label' => 'Product Title',
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('slug', 'text', array(
                        'label' => 'url',
                    ))
                    ->add('label', 'text', array(
                        'label' => 'label.label',
                        'required' => false,
                    ))
//                    ->add('label', 'choice', array(
//                        'label' => 'label.label',
//                        'choices' => array(
//                            'hot' => 'Hot',
//                            'new' => 'New',
//                        ),
//                        'empty_data'  => null,
//                        'required' => false,
//                    ))
                    ->add('productType', 'entity', array('class' => 'DN\TMBundle\Entity\ProductType', 'required' => false))
                    ->add('kvsCategory', 'text', array(
                        'label' => 'kvs category',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('category', 'sonata_type_model', array(
                        'label' => 'label.category',
                        'required' => false,
                        'property' => 'detailedName',
                        'query' => $query,
                    ))
                    ->add('kvsSubcategory', 'text', array(
                        'label' => 'kvs subcategory',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('subcategory', 'sonata_type_model', array(
                        'label' => 'label.subcategory',
                        'required' => false,
                        'property' => 'detailedName',
                        'query' => $query,
                    ))
                    ->add('additionalCategories', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'Additional categories',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                        'query' => $query,
                    ))
                    ->add('infoVa', null, array(
                        'label' => 'label.isInfoEvent',
                        'read_only' => true,
                        'disabled' => true,
                    ))
                ->end()
            ->end()
            ->tab('Relations')
                ->with('Related')
                    ->add('relatedProducts', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'Related products',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                    ))
                    ->add('relatedTo', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'Related to',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                    ))
                ->end()
                ->with('Base')
                    ->add('baseProducts', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'Base products',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                    ))
                    ->add('advancedProducts', 'sonata_type_model', array(
                        'multiple' => true,
                        'label' => 'Advanced products',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
                    ))
                ->end()
            ->end()
            ->tab('Courses')
                ->with('Related courses')
                    ->add('courses', 'collection', array(
                        'type' => new CourseType(),
                        'required' => false,
                    ))
                ->end()
            ->end()
            ->tab('SEO')
                ->with('SEO data')
                    ->add('seoTitle', 'text', array(
                        'label' => 'label.seo title',
                        'required' => false,
                    ))
                    ->add('seoText', 'textarea', array(
                        'label' => 'label.seo description',
                        'required' => false,
                    ))
                    ->add('canonicalUrl', 'text', array('label' => 'label.canonicalUrl', 'required' => false))
                    ->add('noindex', null, array('label' => 'label.noindex', 'required' => false))
                    ->add('noarchive', null, array('label' => 'label.noarchive', 'required' => false))
                    ->add('nofollow', null, array('label' => 'label.nofollow', 'required' => false))
                    ->add('noydir', null, array('label' => 'label.noydir', 'required' => false))
                    ->add('noopd', null, array('label' => 'label.noopd', 'required' => false))
                    ->add('nosnippet', null, array('label' => 'label.nosnippet', 'required' => false))
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('title')
                ->add('subtitle')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('title')
                ->add('productType.name', null, array(
                    'sortable' => true,
                ))
                ->add('created')
        ;
    }

    protected function configureRoutes(RouteCollection $collection) {
        $collection
                ->remove('create')
                ->remove('delete')
//                ->remove('edit')
////                ->add('hierarchy', $this->getRouterIdParameter() . '/hierarchy')
//                ->add('hierarchy', 'hierarchy')
        ;
    }

}
