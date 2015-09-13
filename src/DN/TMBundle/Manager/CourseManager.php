<?php

namespace DN\TMBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CourseManager {

    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container) {
        $this->em = $entityManager;
        $this->container = $container;
    }

    /**
     * returns right side blocks filtered by pageType / object
     * 
     * @param type $pageType
     * @param type $object
     * @param type $path
     * @return type
     */
    public function getRightSideBlocks($pageType, $object) {
        if ($object == null || $pageType == null) {
            return null;
        }

        $containerFilters = array(
            'pageType' => $pageType,
            'active' => true,
        );

        $containerFilters['id'] = $object->getId();
        $containerFilters['categories'] = array();

        if ($object->getCategory() != null) {
            $containerFilters['categories'][] = $object->getCategory()->getId();
        }

        if ($object->getSubcategory() != null) {
            $containerFilters['categories'][] = $object->getSubcategory()->getId();
        }

        $containers = $this->getPageBlockContainers($containerFilters);
        $blocks = $this->getPageBlocksFromContainers($containers);

//foreach ($containers as $c) {
//    var_dump($c->getId());
//}die;
//        foreach ($blocks as $c) {
//            var_dump($c);
//        }die;

        return $blocks;
    }

    public function getBlockContents($blocks, $object, $pageType) {
        if ($object == null || $blocks == null) {
            return null;
        }

        $blockFilters = array(
            'object' => $object,
            'foundIds' => array(),
        );

        $blockFilters['pageType'] = $pageType;
        $blockFilters['category'] = $object->getCategory();
        $blockFilters['subcategory'] = $object->getSubcategory();
        $blockFilters['foundIds'][get_class($object)] = array($object->getId());

        $contents = $this->getContentForBlocks($blocks, $blockFilters);

        return $contents;
    }

    public function getBlockFiltersFromObject($pageType, $object) {
        if ($object == null || $pageType == null) {
            return null;
        }

        $blockFilters = array(
            'object' => $object,
            'foundIds' => array(
                get_class($object) => array($object->getId()),
            ),
            'pageType' => $pageType,
            'category' => $object->getCategory(),
            'subcategory' => $object->getSubcategory(),
        );

        return $blockFilters;
    }

    /**
     * returns PageBlockContainer entities that have to be shown on the actual page
     * 
     * @param type $filters
     * @return type
     */
    private function getPageBlockContainers($filters) {
        $containers = $this->em->getRepository("DNTMBundle:PageBlockContainer")->getPageBlockContainers($filters);

        return $containers;
    }

    /**
     * returns the PageBlocks for containers
     * 
     * @param type $containers
     * @param type $filters
     * @return null
     */
    private function getPageBlocksFromContainers($containers) {
        if ($containers == null) {
            return null;
        }

        $blockTypesProcessed = array();
        $blocks = array();
        foreach ($containers as $c) {
            if ($c->getPageBlocks() != null) {
                foreach ($c->getPageBlocks() as $b) {
                    if ($b->getType() == 'custom' || !in_array($b->getType(), $blockTypesProcessed)) {
                        $blocks[] = $b;
                        $blockTypesProcessed[] = $b->getType();
                    }
                }
            }
        }

        $blocks = $this->sortByProp($blocks, 'rank');

        return $blocks;
    }

    private function sortByProp($array, $propName, $reverse = false) {
        $sorted = [];

        foreach ($array as $item) {
            // todo: general with $propName
            $sorted[$item->getRank()][] = $item;
        }

        if ($reverse)
            krsort($sorted);
        else
            ksort($sorted);
        $result = [];

        foreach ($sorted as $subArray)
            foreach ($subArray as $item) {
                $result[] = $item;
            }

        return $result;
    }

    private function cmp($a, $b) {
        if ($a > $b) {
            return 1;
        } else
        if ($a < $b) {
            return -1;
        } else {
            return 0;
        }
//        return strcmp($a->getRank(), $b->getRank());
    }

    /**
     * returns the right side content to be displayed
     * 
     * @param type $blocks
     * @param type $filters
     * @return array
     */
    public function getContentForBlocks($blocks, $filters) {
        if ($blocks == null) {
            return null;
        }

        $contents = array();

        foreach ($blocks as $b) {
            $c = $this->getContentForBlock($b, $filters);
            $contents[] = $c;
        }

        return $contents;
    }

    /**
     * returns array(
     *     'type' => 'news/article etc.',
     *     'object' => $object,
     * );
     * 
     * @param type $blockType
     * @param type $filters
     */
    public function getContentForBlock($block, &$filters) {
        $ret = null;
        $content = null;
//        $blockTypes = $this->container->getParameter('page_block_types');
        switch ($block->getType()) {
            case 'article':
                $content = $this->em->getRepository("DNTMBundle:Article")->getContentForTeaserBlock($filters, 1);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'object' => $content,
                    );
                }
                break;
            case 'article_combo':
                $filters['id'] = '1';
                $content = $this->em->getRepository("DNTMBundle:Article")->getContentForTeaserBlock($filters, 6);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'object' => $content,
                        'objectInOneBox' => true,
                    );
                }
                break;
            case 'news':
                $content = $this->em->getRepository("DNTMBundle:News")->getContentForTeaserBlock($filters, 1);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'object' => $content,
                    );
                }
                break;
            case 'trainer':
                $content = $this->em->getRepository("DNTMBundle:Trainer")->getContentForTeaserBlock($filters, 5);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'objectInOneBox' => true,
                        'object' => $content,
                    );
                }
                break;
            case 'custom':
                $content = $block->getContent();
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'objectInOneBox' => true,
                        'object' => $content,
                    );
                }
                break;
            case 'location':
                $content = '';
                break;
            case 'info':
                $content = '';
                break;
            case 'faq':
                $content = $this->em->getRepository("DNTMBundle:FAQ")->getContentForTeaserBlock($filters, 5);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'objectInOneBox' => true,
                        'object' => $content,
                    );
                }
                break;
            case 'video':
                $content = $this->em->getRepository("DNTMBundle:Video")->getContentForTeaserBlock($filters, 1);
                if ($content != null) {
                    $ret = array(
                        'type' => $block->getType(),
                        'objectInOneBox' => true,
                        'object' => $content,
                    );
                }
                break;
            case 'video':
                $content = '';
                break;
            case 'video':
                $content = '';
                break;
        }

        return $ret;
    }

}
