<?php

namespace DN\TMBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use RuntimeException;

class RTEExtension extends Twig_Extension {

    private $em;
    private $container;
    private $mediaManager;

    public function __construct(EntityManager $entityManager, Container $container, $mediaManager) {
        $this->em = $entityManager;
        $this->container = $container;
        $this->mediaManager = $mediaManager;
    }

    public function getFilters() {
        return array(
            new Twig_SimpleFilter('rte', array($this, 'rteLinkFilter')),
        );
    }

    public function rteLinkFilter($text) {
        if ( false === preg_match_all('/\[\[(.*?):(.*?)\]\]/', $text, $links) ) return $text;
        
        foreach ($links[0] as $i => $link) {
            $to = $this->getLink($links[1][$i], $links[2][$i]);
            $text = str_replace($link, $to, $text);
        }        

        return $text;
    }

    private function getLink($entity, $id) {
        try {
            switch ($entity) {
                case 'Form':
                    $item = 'form';
                    break;
                case 'Media':
                    $item = $this->mediaManager->findOneBy(array('id' => $id));
                    break;
                default:
                    $item = $this->em->getRepository('DNTMBundle:' . $entity)->find($id);
                    break;
            }
        } catch(MappingException $e) {
            return "";
        } catch(RuntimeException $e) {
            return "";
        }

        if ($item == null) {
            return "";
        }
        $path = "";
        
        switch ($entity) {
            case 'CustomPage':
                $pagePath = $this->em->getRepository('DNTMBundle:PagePath')->findOneBy(array('actionType' => 'customPage', 'action' => $id));

                if ($pagePath != null) {
                    switch ($pagePath->getArea()) {
                        case 'privat':
                            if ($pagePath->getPath() != null) {
                                $path = $this->container->get('router')->generate('custom_page_view', array('slug' => trim($pagePath->getPath(), '/')));
                            } else {
                                $path = $this->container->get('router')->generate('custom_page_view', array('slug' => ''));
                            }
                            break;
                        case 'ueber-uns':
                            if ($pagePath->getPath() != null) {
                                $path = $this->container->get('router')->generate('about_us_view', array('slug' => trim($pagePath->getPath(), '/')));
                            } else {
                                $path = $this->container->get('router')->generate('about_us_home_view');
                            }
                            break;
                        case 'business':
                            if ($pagePath->getPath() != null) {
                                $path = $this->container->get('router')->generate('business_view', array('slug' => trim($pagePath->getPath(), '/')));
                            } else {
                                $path = $this->container->get('router')->generate('business_home_view');
                            }
                            break;
                        default:
                            
                    }
                }
                break;
            case 'News':
                if ($item->getNewsCategory() != null) {
                    $path = $this->container->get('router')->generate('news_view', array(
                        'slug' => $item->getSlug(),
                        'newsCategorySlug' => $item->getNewsCategory()->getSlug(),
                    ));                    
                }
                break;
            case 'Article':
                if ($item->getCategory() != null) {
                    if ($item->getSubcategory() != null) {
                        $path = $this->container->get('router')->generate('article_view_with_subcategory', array(
                            'slug' => $item->getSlug(),
                            'categorySlug' => $item->getCategory()->getSlug(),
                            'subcategorySlug' => $item->getSubcategory()->getSlug(),
                        ));
                    } else {
                        $path = $this->container->get('router')->generate('article_view', array(
                            'slug' => $item->getSlug(),
                            'categorySlug' => $item->getCategory()->getSlug(),
                        ));
                    }
                }
                break;
            case 'Trainer':
                if ($item->getCategory() != null) {
                    if ($item->getSubcategory() != null) {
                        $path = $this->container->get('router')->generate('trainer_view_with_subcategory', array(
                            'slug' => $item->getSlug(),
                            'categorySlug' => $item->getCategory()->getSlug(),
                            'subcategorySlug' => $item->getSubcategory()->getSlug(),
                        ));
                    } else {
                        $path = $this->container->get('router')->generate('trainer_view', array(
                            'slug' => $item->getSlug(),
                            'categorySlug' => $item->getCategory()->getSlug(),
                        ));
                    }
                }
                break;
            case 'Product':
                if ($item->getCategory() != null && $item->getCategory()->getSlug() != null && $item->getCategory()->getSlug() != "") {
                    if ($item->getSubcategory() != null && $item->getSubcategory()->getSlug() != null && $item->getSubcategory()->getSlug() != "") {
                        $path = $this->container->get('router')->generate('course_view_with_subcategory', array(
                            'slug' => $item->getSlug(),
                            'parentCategorySlug' => $item->getCategory()->getSlug(),
                            'categorySlug' => $item->getSubcategory()->getSlug(),
                        ));
                    } else {
                        $path = $this->container->get('router')->generate('course_view', array(
                            'slug' => $item->getSlug(),
                            'categorySlug' => $item->getCategory()->getSlug(),
                        ));
                    }
                }
                break;
            case 'Media':
                $provider = $this->container->get($item->getProviderName());
                $path = $provider->generatePublicUrl($item, 'reference');
                break;
            case 'Form':
                $path = 'forma/' . $id . ')';
                break;
        }
        
        return $path;
    }

    public function getName() {
        return 'rte';
    }

}
