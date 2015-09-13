<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use DN\TMBundle\Entity\Menu;
use DN\TMBundle\Entity\PagePath;

class AdminMenuController extends CRUDController {

    public function listAction() {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'POST') {
            $data = $this->getRequest()->get('menu-structure');
            $this->get('dn.tm.utilityservice')->saveMenu($data);
        }

        $customPageList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomPage')->findAll();

        $menuTypes = array(
            'customPage' => 'Custom page',
            'externalUrl' => 'External url',
            'builtInPage' => 'Built in page',
            'redirect' => 'Redirect',
        );

        $builtInPages = array(
            'search' => 'search page',
            'faq' => 'FAQ',
            'articleOverview' => 'article overview',
            'newsOverview' => 'news overview',
//            'newsOverviewNews' => 'news overview (news)',
//            'newsOverviewBusiness' => 'news overview (business)',
//            'newsOverviewJobs' => 'news overview (jobs)',
//            'newsOverviewPressespiegel' => 'news overview (pressespiegel)',
//            'newsOverviewLernenUndLeben' => 'news overview (lernen-und-leben)',
        );

        $jsParams = array(
            'menuJSON' => json_decode($this->get('dn.tm.utilityservice')->loadMenu('menu.dat')),
        );

        $retParams = array(
            'action' => 'list',
            'jsParams' => $jsParams,
            'menuTypes' => $menuTypes,
            'customPageList' => $customPageList,
            'builtInPages' => $builtInPages,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        );

        return $this->render($this->admin->getTemplate('list'), $retParams);
    }

}
