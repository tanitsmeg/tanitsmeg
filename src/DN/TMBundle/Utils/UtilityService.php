<?php

namespace DN\TMBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use DateTime;

class UtilityService {

    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container) {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function saveMenu($menuJSON) {
        $fp = fopen('menu.dat', 'w');
        fwrite($fp, $menuJSON);
        fclose($fp);

        $data = json_decode($menuJSON, true);

        $this->em->getRepository('DNTMBundle:PagePath')->savePagePaths($data, "");
    }

    public function loadMenu($filename) {
        $ret = '[]';
        if (file_exists($filename)) {
            $data = file_get_contents($filename, true);
            if (strlen($data) > 0) {
                $ret = $data;
            }
        }
        return $ret;
    }

    public function generateUrlsForMenu(&$menu, $path) {
        foreach ($menu as $m) {
            $p = $path . $m->data->url . '/';
            if (isset($m->children)) {
                $this->generateUrlsForMenu($m->children, $p);
            }
//            var_dump($m->data);
            $m->path = $p;
            switch ($m->data->type) {
                case 'customPage':
                    $m->path = $p;
                    break;
                case 'externalUrl':
                    $m->path = $m->data->externalUrl;
                    break;
                case 'builtInPage':
                    switch ($m->data->builtInPage) {
                        case 'search':
                            $m->path = $this->container->get('router')->generate('DNTMBundle_Search');
                            break;
                        case 'faq':
                            $m->path = $this->container->get('router')->generate('faq_view');
                            break;
                        case 'articleOverview':
                            $params = explode(',', $m->data->overview);
                            $category = count($params) > 0 ? $this->em->getRepository("DNTMBundle:Category")->findOneBy(array('id' => $params[0])) : null;
                            $subcategory = count($params) > 1 ? $this->em->getRepository("DNTMBundle:Category")->findOneBy(array('id' => $params[1])) : null;
                            if ($subcategory != null) {
                                $m->path = $this->container->get('router')->generate('article_overview_with_subcategory', array('categorySlug' => $category->getSlug(), 'subcategorySlug' => $subcategory->getSlug()));
                            } else
                            if ($category != null) {
                                $m->path = $this->container->get('router')->generate('article_overview', array('categorySlug' => $category->getSlug()));
                            }
                            break;
                        case 'newsOverview':
                            $newsCategorySlug = $m->data->overview;
                            $category = $this->em->getRepository("DNTMBundle:NewsCategory")->findOneBy(array('slug' => $newsCategorySlug));
                            if ($category != null) {
                                switch ($newsCategorySlug) {
                                    case 'presse':
                                        $m->path = $this->container->get('router')->generate('news_overview1');
                                        break;
                                    case 'news':
                                        $m->path = $this->container->get('router')->generate('news_overview2');
                                        break;
                                    case 'business':
                                        $m->path = $this->container->get('router')->generate('news_overview6');
                                        break;
                                    case 'jobs':
                                        $m->path = $this->container->get('router')->generate('news_overview4');
                                        break;
                                    case 'pressespiegel':
                                        $m->path = $this->container->get('router')->generate('news_overview3');
                                        break;
                                    case 'lernen-und-leben':
                                        $m->path = $this->container->get('router')->generate('news_overview5');
                                        break;
                                }
                            }
                            break;
                    }
                    break;
                case 'redirect':
                    break;
            }
        }
    }

    public function generateUrlsForRedirectMenus(&$menu) {
        foreach ($menu as $m) {
            if ($m->data->type == 'redirect') {
                $m->path = $this->findMenuItemByKey($menu, $m->data->redirect);
            }
            if (isset($m->children)) {
                $this->generateUrlsForRedirectMenus($m->children);
            }
        }
    }

    private function findMenuItemByKey($menu, $key) {
        $i = 0;
        while ($i < count($menu) && $menu[$i]->key != $key) {
            if (isset($menu[$i]->children)) {
                return $this->findMenuItemByKey($menu[$i]->children, $key);
            }
            $i++;
        }
        return $i < count($menu) ? $menu[$i]->path : null;
    }

    public function getXmlContent($filename, $parentTag) {
        $opts = array('http' => array('header' => 'Accept-Charset: UTF-8, *;q=0'));
        $context = stream_context_create($opts);

        $document = new \DOMDocument();
        $fileData = file_get_contents($filename, false, $context);

        $document->loadXML($fileData);

        $crawler = new Crawler();
        $crawler->addDocument($document);

        $content = $crawler->filter($parentTag)->children();

        ini_set('MAX_EXECUTION_TIME', -1);

        return $content;
    }

    /**
     * returns DateTime object from string date and time
     * 
     * @param type $pDate
     * @param type $pTime
     * @param type $pSeparator
     * @return \DateTime
     */
    public function getDateTimeFromDateAndTime($pDate, $pTime, $pSeparator = '.') {
        $dt = null;

        if ($pDate) {
            $date = explode($pSeparator, $pDate);

            $dt = new DateTime();
            $dt->setDate($date[2], $date[1], $date[0]);

            if ($pTime) {
                $time = explode(':', $pTime);
                $dt->setTime($time[0], $time[1], 0);
            } else {
                $dt->setTime(0, 0, 0);
            }
        }

        return $dt;
    }

}
