<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Entity\News;

class NewsController extends Controller {

    /**
     * @Route("/ueber-uns/presse/{slug}/", name="news_view1", defaults={"area" = "about-us"})
     * @Route("/ueber-uns/organisation/news/{slug}/", name="news_view2", defaults={"area" = "about-us"})
     * @Route("/ueber-uns/organisation/pressespiegel/{slug}/", name="news_view3", defaults={"area" = "about-us"})
     * @Route("/ueber-uns/karriere/jobs/{slug}/", name="news_view4", defaults={"area" = "about-us"})
     * @Route("/lernen-und-leben/news/{slug}/", name="news_view5", defaults={"area" = "private"})
     * @Route("/business/ueber-uns/news/{slug}/", name="news_view6", defaults={"area" = "business"})
     */
    public function view1Action($area, $slug) {
        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:News')->findOneBy(array('slug' => $slug));

        if ($object == null) {
            throw $this->createNotFoundException('Page does not exist');
        }

        $jsParams = array(
        );

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('news', $object);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('news', $object);

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        $template = '';
        switch ($area) {
//            case 'about-us':
//                $template = 'DNTMBundle:AboutUs:news_overview.html.twig';
//                break;
            case 'business':
                $retParams['slideShowData'] = $slideShowData = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PageBlock')->findBy(array('type' => 'business_slideshow'));
                $template = 'DNTMBundle:Business:news_view.html.twig';
                break;
            default:
                $template = 'DNTMBundle:News:view.html.twig';
                break;
        }

        return $this->render($template, $retParams);
    }

    /**
     * @Route("/ueber-uns/presse/", name="news_overview1", defaults={"area" = "about-us", "newsCategory" = "presse"})
     * @Route("/ueber-uns/organisation/news/", name="news_overview2", defaults={"area" = "about-us", "newsCategory" = "news"})
     * @Route("/ueber-uns/organisation/pressespiegel/", name="news_overview3", defaults={"area" = "about-us", "newsCategory" = "pressespiegel"})
     * @Route("/ueber-uns/karriere/jobs/", name="news_overview4", defaults={"area" = "about-us", "newsCategory" = "jobs"})
     * @Route("/lernen-und-leben/news/", name="news_overview5", defaults={"area" = "private", "newsCategory" = "lernen-und-leben"})
     * @Route("/business/ueber-uns/news/", name="news_overview6", defaults={"area" = "business", "newsCategory" = "business"})
     */
    public function overview1Action($area, $newsCategory) {
        $newsCategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:NewsCategory')->findOneBy(array('slug' => $newsCategory));

        if ($newsCategory == null) {
            throw $this->createNotFoundException('Page does not exist');
        }


        $newsCategoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:NewsCategory')->findAll();
        $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:News')->findBy(array('newsCategory' => $newsCategory->getId()));

        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('newsOverview', $cmsObject);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('newsOverview', $cmsObject);

        $retParams = array(
            'resultList' => $resultList,
            'newsCategoryList' => $newsCategoryList,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

//        return $this->render('DNTMBundle:News:overview_newscategory.html.twig', $retParams);
        $template = '';
        switch ($area) {
//            case 'about-us':
//                $template = 'DNTMBundle:AboutUs:news_overview.html.twig';
//                break;
            case 'business':
                $retParams['slideShowData'] = $slideShowData = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PageBlock')->findBy(array('type' => 'business_slideshow'));
                $template = 'DNTMBundle:Business:news_overview.html.twig';
                break;
            default:
                $template = 'DNTMBundle:News:overview.html.twig';
                break;
        }

        return $this->render($template, $retParams);
    }

//    /**
//     * Route("/{newsCategorySlug}/news/{slug}/", name="news_view", defaults={"newsCategorySlug" = "a"})
//     */
//    public function viewAction($newsCategorySlug, $slug) {
//        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:News')->findBySlugAndNewsCategorySlug($slug, $newsCategorySlug);
//
//        if ($object == null) {
//            throw $this->createNotFoundException('Page does not exist');
//        }
//
//        $jsParams = array(
//        );
//
//        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('customPage', $object);
//        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('customPage', $object);
//
//        $retParams = array(
//            'jsParams' => $jsParams,
//            'object' => $object,
//            'blocks' => $blocks,
//        );
//
//        return $this->render('DNTMBundle:News:view.html.twig', $retParams);
//    }
//
//    /**
//     * Route("/{newsCategorySlug}/news/", name="news_category_overview")
//     */
//    public function overviewAction($newsCategorySlug) {
//        $newsCategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:NewsCategory')->findOneBy(array('slug' => $newsCategorySlug));
//
//        if ($newsCategory == null) {
//            throw $this->createNotFoundException('Page does not exist');
//        }
//
//
//        $newsCategoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:NewsCategory')->findAll();
//        $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:News')->findBy(array('newsCategory' => $newsCategory->getId()));
//
//        $cmsObject = new CMSObject();
//        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('newsOverview', $cmsObject);
//
//        $retParams = array(
//            'resultList' => $resultList,
//            'newsCategoryList' => $newsCategoryList,
//            'blocks' => $blocks,
//        );
//
//        return $this->render('DNTMBundle:News:overview.html.twig', $retParams);
//    }

}
