<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;

class AdminCategoryController extends CRUDController {

    // http://sonata-project.org/bundles/admin/master/doc/cookbook/recipe_custom_action.html
    public function listAction() {
        if ($this->getRestMethod() == 'POST') {
            $data = $this->getRequest()->get('category-structure');
            $this->save($data);
        }

        $categories = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findAll();

        $categoriesParsed = $this->buildTree($categories);
//var_dump($categoriesParsed);die;

        $jsParams = array(
//            'dataJSON' => json_encode($categoriesParsed),
            'dataJSON' => $categoriesParsed,
        );

        $retParams = array(
            'action' => 'list',
            'jsParams' => $jsParams,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        );

        return $this->render($this->admin->getTemplate('list'), $retParams);
    }

    public function save($data) {
        $data = json_decode($data, true);

        $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->saveHierarchy($data);
    }

    private function buildTree($data) {
        $tree = array();
        
        foreach ($data as $d) {
            if ($d->getParent() == null) {
                $c = array(
                    'id' => $d->getId(),
                    'title' => $d->getTitle(),
                    'children' => array(),
                );
                $tree[] = $c;
            }
        }

        foreach ($data as $d) {
            if ($d->getParent() != null) {
                $i = 0;
                while ($i < count($tree) && $tree[$i]['id'] != $d->getParent()) {
                    $i++;
                }
                if ($i < count($tree)) {
                    $c = array(
                        'id' => $d->getId(),
                        'title' => $d->getTitle(),
                    );
                    $tree[$i]['children'][] = $c;
                }
            }
        }
        return $tree;
    }

}
