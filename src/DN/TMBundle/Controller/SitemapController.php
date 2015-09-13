<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use SimpleXMLElement;
use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;

class SitemapController extends Controller {

    /**
     * @Route("/meta/sitemap/", name="sitemap_view")
     */
    public function viewAction() {
        $sitemap = $this->buildSitemap();

        var_dump($sitemap);
        die;

        $jsParams = array(
        );

        $retParams = array(
            'sitemapData' => $sitemap,
            'jsParams' => $jsParams,
        );

        return $this->render('DNTMBundle:Sitemap:view.html.twig', $retParams);
    }

    private function buildSitemap() {
        $map = array();

        $map[] = $this->getCustomPages(json_decode($this->get('dn.tm.utilityservice')->loadMenu('menu.dat')));
        $map[] = $this->getCategories();

        $ret = ($map);

        return $ret;
    }

    private function getCustomPages($data) {
        foreach ($data as $d) {
            $ret = array(
                'title' => $d->title,
            );
            if (isset($d->children)) {
                $this->getCustomPages($d->children);
            }
        }
    }

    private function getCategories() {
        $ret = array();

        $mainCategories = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('active' => true, 'isMain' => true));
        $subCategories = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('active' => true, 'isMain' => false));
        $products = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Product')->findAll();

        foreach ($mainCategories as $mc) {
            $ret[$mc->getId()] = array(
                'title' => $mc->getTitle(),
                'children' => array(),
            );
        }

        foreach ($subCategories as $sc) {
            if ($sc->getParent() != null && $sc->getParent()->getActive()) {
                $ret[$sc->getParent()->getId()]['children'][] = array(
                    'title' => $sc->getTitle(),
                );
            }
        }

        foreach ($products as $p) {
            if ($p->getSubcategory() != null) {
                
            }
            $ret[$mc->getId()] = array(
                'title' => $mc->getTitle(),
                'children' => array(),
            );
        }

        return $ret;
    }

    private function getXml($data) {
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($data, array('addChild', $this->getXml($xml)));
        
        return $xml->asXML();
    }

    private function array2xml($array, $node_name = "root") {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement($node_name);
        $dom->appendChild($root);

        $array2xml = function ($node, $array) use ($dom, &$array2xml) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $n = $dom->createElement($key);
                    $node->appendChild($n);
                    $array2xml($n, $value);
                } else {
                    $attr = $dom->createAttribute($key);
                    $attr->value = $value;
                    $node->appendChild($attr);
                }
            }
        };

        $array2xml($root, $array);

        return $dom->saveXML();
    }

}
