<?php

namespace DN\TMBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CategoryAdmin extends Admin {

    private $container;
    protected $translationDomain = 'messages';

    public function __construct($code, $class, $baseControllerName, $container = null) {
        parent::__construct($code, $class, $baseControllerName);

        $this->container = $container;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $query = $this->modelManager->getEntityManager('DN\TMBundle\Entity\Category')->createQuery('SELECT c FROM DN\TMBundle\Entity\Category c WHERE c.isMain = false');
//        $arrayType = $query->getArrayResult();
//        var_dump($arrayType);die;

        $formMapper
            ->tab('General')
                ->with('Category')
                    ->add('id', 'text', array(
                        'label' => 'label.id',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('kvsId', 'text', array(
                        'label' => 'label.kvsId',
                        'required' => false,
                        'read_only' => true,
                        'disabled' => true,
                    ))
                    ->add('title', 'text', array(
                        'label' => 'label.title',
                    ))
                    ->add('slug', 'text', array('label' => 'page url'))
                    ->add('kvsName', 'text', array(
                        'label' => 'kvs name',
                        'read_only' => true,
                        'disabled' => true,
                        'required' => false,
                    ))
                    ->add('active', null, array(
                        'label' => 'active',
                        'required' => false,
                    ))
                    ->add('isMain', null, array(
                        'label' => 'is main?',
                        'required' => false,
                    ))
                    ->add('isShownInLists', null, array(
                        'label' => 'is shown in menu lists?',
                        'required' => false,
                    ))
    //                ->add('children', 'sonata_type_model', array(
    //                    'multiple' => true,
    //                    'label' => 'label.children',
    //                    'required' => false,
    //                    'btn_add' => false,
    ////                    'query' => $query,
    //                ))
                    // todo: save for parent
                    ->add('parent', 'sonata_type_model', array(
    //                    'multiple' => true,
                        'label' => 'label.parent',
                        'required' => false,
                        'btn_add' => false,
                        'property' => 'detailedName',
    //                    'query' => $query,
                    ))
                ->end()
            ->end()
            ->tab('SEO')
                ->with('SEO data')
                    ->add('seoFields', 'collection', array(
//                    ->add('seoFields', 'sonata_type_collection', array(
                        'label' => 'label.seoFields',
                        'by_reference' => false,
//                        'cascade_validation' => true,
                        'type' => $this->container->get('dn.tm.form.type.category_seo'),
                        'required' => false,
                        'allow_add' => true,
                        'allow_delete' => true,
                    ))
                ->end()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('kvsId')
                ->add('slug')
                ->add('title')
                ->add('isMain')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('kvsId')
                ->add('title')
                ->add('isMain')
                ->add('isShownInLists')
//                ->add('_action', 'actions', array(
//                    'actions' => array(
//                        'Hierarchy' => array(
//                            'template' => 'DNTMBundle:Admin:category_hierarchy.html.twig'
//                        )
//                    )
//                ))
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

    public function prePersist($object) {
        foreach ($object->getSeoFields() as $sf) {
            $sf->setCategory($object);
        }
    }

    public function preUpdate($object) {
        foreach ($object->getSeoFields() as $sf) {
            $sf->setCategory($object);
        }
    }

}
