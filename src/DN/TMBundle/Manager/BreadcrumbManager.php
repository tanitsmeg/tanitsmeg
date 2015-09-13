<?php

namespace DN\TMBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class BreadcrumbManager {

    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container) {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function getBreadcrumbForCustomPage($uri, $title, $area) {
        $ret = array();

        $path = '';
        $i = 0;
        foreach ($uri as $u) {
            if ($i != 0 || $area == 'privat') {
                $path .= $u . '/';
            }
            $text = $u;
            $url = '';

            if ($path == '') {
                $pagePath = $this->em->getRepository('DNTMBundle:PagePath')->findOneBy(array('path' => null, 'actionType' => 'customPage', 'area' => $area));
            } else {
                $pagePath = $this->em->getRepository('DNTMBundle:PagePath')->findOneBy(array('path' => $path, 'actionType' => 'customPage', 'area' => $area));
            }
            if ($pagePath != null) {
                $text = $pagePath->getPageTitle();
                $pathTrimmed = trim($pagePath->getPath(), '/');
                switch ($pagePath->getArea()) {
                    case 'privat':
                        $url = $this->container->get('router')->generate('custom_page_view', array('slug' => $pathTrimmed));
                        break;
                    case 'business':
                        if ($pathTrimmed == '') {
                            $url = $this->container->get('router')->generate('business_home_view', array());
                        } else {
                            $url = $this->container->get('router')->generate('business_view', array('slug' => $pathTrimmed));
                        }
                        break;
                    case 'ueber-uns':
                        if ($pathTrimmed == '') {
                            $url = $this->container->get('router')->generate('about_us_home_view', array('slug' => $pathTrimmed));
                        } else {
                            $url = $this->container->get('router')->generate('about_us_view', array('slug' => $pathTrimmed));
                        }
                        break;
                }
            }

            $ret[] = array(
                'url' => $url,
                'text' => $text,
            );
            $i++;
        }

        return $ret;
    }

    public function getBreadcrumbForView($uri, $title, $pageType) {
        $e = array_pop($uri);

        $ret = $this->getBreadcrumbForCategoryOverview($uri, null);
        $ret = array_merge($ret, $this->getBreadcrumbForOverviewPages($pageType, $title, $uri));

        $ret[] = array(
            'url' => null,
            'text' => $e,
        );

        return $ret;
    }

    public function getBreadcrumbForCategoryOverview($uri, $title) {
        $ret = array();

        if (count($uri) == 2) {
            $ret = array_merge($ret, $this->getBreadcrumbForCategories($uri[0]));
        } else
        if (count($uri) == 3) {
            $ret = array_merge($ret, $this->getBreadcrumbForCategories($uri[0], $uri[1]));
        }
        if ($title != null) {
            $ret[] = array(
                'url' => null,
                'text' => $title,
            );
        }

        return $ret;
    }

    private function getBreadcrumbForCategories($categorySlug, $subcategorySlug = null) {
        $ret = array();

        $c = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));
        if ($c != null) {
            $ret[] = array(
                'text' => $c->getTitle(),
                'url' => $this->container->get('router')->generate('DNTMBundle_Category', array('categorySlug' => $categorySlug)),
            );
        } else {
            $ret[] = array(
                'text' => $categorySlug,
                'url' => '',
            );
        }

        if ($subcategorySlug != null) {
            $sc = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
            if ($sc != null) {
                $ret[] = array(
                    'text' => $sc->getTitle(),
                    'url' => $this->container->get('router')->generate('DNTMBundle_Subcategory', array('parentCategorySlug' => $categorySlug, 'categorySlug' => $subcategorySlug)),
                );
            } else {
                $ret[] = array(
                    'text' => $subcategorySlug,
                    'url' => '',
                );
            }
        }

        return $ret;
    }

    private function getBreadcrumbForOverviewPages($pageType, $title, $uri) {
        $ret = array();

        if (count($uri) == 2) {
            $ret[] = array(
                'text' => $title,
                'url' => $this->container->get('router')->generate($pageType . '_overview', array('categorySlug' => $uri[0])),
            );
        } else
        if (count($uri) == 3) {
            $ret[] = array(
                'text' => $title,
                'url' => $this->container->get('router')->generate($pageType . '_overview_with_subcategory', array('categorySlug' => $uri[0], 'subcategorySlug' => $uri[1])),
            );
        }

        return $ret;
    }

}
