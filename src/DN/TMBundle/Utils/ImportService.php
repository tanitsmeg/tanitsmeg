<?php

namespace DN\TMBundle\Utils;

use Doctrine\ORM\EntityManager;
//use DN\TMBundle\Utils\Utility;
use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;
use DN\TMBundle\Entity\MediaFile;

class ImportService {

    private $em;
    private $importFolder;

    public function __construct(EntityManager $entityManager, $importFolder) {
        $this->em = $entityManager;
        $this->importFolder = $importFolder;
    }

    /**
     * todo: handle the deleted products
     * 
     * imports all the products from xml input file
     */
    public function importProduct($utilityService) {
//        $content = $utilityService->getXmlContent($this->importFolder . "/produkte.xml", "bfiwien");
        $content = $utilityService->getXmlContent($this->importFolder . "/produkte.xml", "bfiwien");

        $insertedIds = array();

        foreach ($content as $element) {
            $dataSrc = array();

            $id = $element->getAttribute('id');
            $newProductFrom = null;
            $newProductTo = null;

            foreach ($element->childNodes as $node) {
                if ($node->nodeName != '#text') {
                    $dataSrc[$node->nodeName] = $node->nodeValue;

                    if ($node->nodeName == 'neues_produkt') {
                        $newProductFrom = $node->getAttribute('von');
                        $newProductTo = $node->getAttribute('bis');
                    }
                }
            }

            $data = $this->em->getRepository('DNTMBundle:Product')->findOneBy(array('id' => $id));

            $pg = null;
            $pfb = null;

            if ($data == null) {
                $data = new Product();
                $data->setId($id);
                $data->setTitle($dataSrc['titel']);
                $data->setSubTitle($dataSrc['subtitel']);
                $data->setCreated(new \DateTime("now"));

                $pg = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('id' => 'G' . $dataSrc['produktgruppe']));
                if ($pg != null) {
                    $data->setCategory($pg);
                }

                $pfb = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('id' => 'F' . $dataSrc['fachbereich']));
                if ($pfb != null) {
                    $data->setSubcategory($pfb);
                }
            }

            if ($pg != null) {
                $data->setKvsCategory($pg->getTitle() . ' (' . $pg->getId() . ')');
            }

            if ($pfb != null) {
                $data->setKvsSubcategory($pfb->getTitle() . ' (' . $pfb->getId() . ')');
            }

            $data->setKbNumber($element->getAttribute('id'));
            $data->setKbDate($utilityService->getDateTimeFromDateAndTime($element->getAttribute('datum'), null, '.'));
            $data->setSeoTitle($dataSrc['seotitel']);
            $data->setSeoText($dataSrc['seotext']);
            $data->setKeyword01($dataSrc['keyword_01']);
            $data->setKeyword02($dataSrc['keyword_02']);
            $data->setKeyword03($dataSrc['keyword_03']);
            $data->setKeyword04($dataSrc['keyword_04']);
            $data->setKeyword05($dataSrc['keyword_05']);
            $data->setKeyword06($dataSrc['keyword_06']);
            $data->setKeyword07($dataSrc['keyword_07']);
            $data->setKeyword08($dataSrc['keyword_08']);
            $data->setKeyword09($dataSrc['keyword_09']);
            $data->setKeyword10($dataSrc['keyword_10']);
            $data->setGoals($dataSrc['ziele']);
            $data->setTargetGroup($dataSrc['zielgruppe']);
            $data->setPreconditions($dataSrc['voraussetzungen']);
            $data->setPrecognition($dataSrc['vorkenntnisse']);
            $data->setCharacteristic($dataSrc['besonderheiten']);
            $data->setCareerOptions($dataSrc['berufliche_verwendung']);
            $data->setAk($dataSrc['ak-big']);
            $data->setPrice($dataSrc['preis']);
            $data->setTeachingUnit($dataSrc['unterrichtseinheiten']);
            if ($dataSrc['rating'] > 0)
                $data->setRating($dataSrc['rating']);
            else
                $data->setRating(null);
            $data->setRatingCount($dataSrc['rating_count']);

            $data->setCourseContent($dataSrc['kursinhalt']);

            $infoVa = ($dataSrc['is_info_va'] == 'J' || $dataSrc['info_veranstaltungen'] != "") ? 1 : 0;

            $data->setInfoVa($infoVa);
            $data->setFromDate($utilityService->getDateTimeFromDateAndTime($newProductFrom, null, '.'));
            $data->setToDate($utilityService->getDateTimeFromDateAndTime($newProductTo, null, '.'));

            $data->setActive(1);
            $data->setInternet(1);

            if (!in_array($id, $insertedIds)) {
                $insertedIds[] = $id;
                $this->em->merge($data);
            }
        }

        $this->em->flush();
    }

    /**
     * imports all the courses from xml input file
     */
    public function importCourse($utilityService) {
        $content = $utilityService->getXmlContent($this->importFolder . "/kurse.xml", "bfiwien");

        $insertedIds = array();

        $locationId = null;
        $locationName = null;
        $locationCity = null;
        $locationZip = null;
        $locationStreet = null;

        foreach ($content as $element) {
            $dataSrc = array();

            foreach ($element->childNodes as $node) {
                if ($node->nodeName != '#text') {
                    $dataSrc[$node->nodeName] = $node->nodeValue;

                    if ($node->nodeName == 'standort') {
                        $locationId = $node->getAttribute('id');

                        if ($node->getElementsByTagName('name')->item(0)) {
                            $locationName = $node->getElementsByTagName('name')->item(0)->nodeValue;
                            $locationZip = $node->getElementsByTagName('plz')->item(0)->nodeValue;
                            $locationCity = $node->getElementsByTagName('ort')->item(0)->nodeValue;
                            $locationStreet = $node->getElementsByTagName('strasse')->item(0)->nodeValue;
                        }
                    }
                }
            }

            $data = $this->em->getRepository('DNTMBundle:Course')->findOneBy(array('id' => $element->getAttribute('id')));

            if ($data == null) {
                $data = new Course();
                $data->setId($element->getAttribute('id'));
            }

            $data->setKbNumber($element->getAttribute('kb_nummer'));
            $data->setKbDate($utilityService->getDateTimeFromDateAndTime($element->getAttribute('kb_datum'), null, '.'));

            $productId = $element->getAttribute('kb_nummer');
            $product = $this->em->getRepository('DNTMBundle:Product')->findOneBy(array('id' => $productId));
            $data->setProduct($product);
            $data->setCourseNumber($dataSrc['kursnummer']);
            $data->setBeginDate($utilityService->getDateTimeFromDateAndTime($dataSrc['datum_beginn'], $dataSrc['zeit_beginn'], '.'));
            $data->setEndDate($utilityService->getDateTimeFromDateAndTime($dataSrc['datum_ende'], $dataSrc['zeit_ende'], '.'));
            $data->setCourseTimes($dataSrc['kurszeiten']);
            $data->setDayTimes($dataSrc['tageszeit']);
            $data->setCourseLeader($dataSrc['kursleiter']);
            $data->setPrice($dataSrc['preis']);
            $data->setStatus($dataSrc['status']);
            $data->setMinParticipant($dataSrc['min_tn']);
            $data->setMaxParticipant($dataSrc['max_tn']);
            $data->setParticipantCount($dataSrc['anzahl_tn']);
            $data->setDfWarranty($dataSrc['df_garantie'] == 'J' ? 1 : 0);
            ;
            $data->setLocation($locationId);
            $data->setLocationName($locationName);
            $data->setLocationZip($locationZip);
            $data->setLocationCity($locationCity);
            $data->setLocationStreet($locationStreet);
            $data->setActive(1);

            if (!in_array($element->getAttribute('id'), $insertedIds)) {
                $insertedIds[] = $element->getAttribute('id');
                $this->em->merge($data);
            }
        }

        $this->em->flush();
    }

    /**
     * imports all the categories from xml input file
     */
    public function importCategory($utilityService) {
        $this->processMainCategories($utilityService);
        $this->processSubcategories($utilityService);
    }

    protected function processMainCategories($utilityService) {
        $content = $utilityService->getXmlContent($this->importFolder . "/produktgruppe.xml", "bfiwien");
        $insertedIds = array();

        foreach ($content as $element) {
            $dataSrc = array();

            foreach ($element->childNodes as $node) {
                if ($node->nodeName != '#text') {
                    $dataSrc[$node->nodeName] = $node->nodeValue;
                }
            }

            $data = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('id' => 'G' . $element->getAttribute('id')));

            if ($data == null) {
                $data = new Category();
                $data->setId('G' . $element->getAttribute('id'));
                $data->setKvsId($element->getAttribute('id'));
                $data->setTitle($dataSrc['bezeichnung']);
                $data->setActive(1);
                $data->setIsMain(1);
            }

            $data->setKvsName($dataSrc['bezeichnung']);

            if (!in_array($element->getAttribute('id'), $insertedIds)) {
                $insertedIds[] = $element->getAttribute('id');
                $this->em->merge($data);
            }
        }

        $this->em->flush();
    }

    private function processSubcategories($utilityService) {
        $content = $utilityService->getXmlContent($this->importFolder . "/fachbereich.xml", "bfiwien");
        $insertedIds = array();

        foreach ($content as $node) {
            if ($node->nodeName != '#text') {
                $dataSrc = array();

                foreach ($node->childNodes as $childNode) {
                    if ($childNode->nodeName != '#text') {
                        $dataSrc[$childNode->nodeName] = $childNode->nodeValue;
                    }
                }

                $data = $this->em->getRepository('DNTMBundle:Category')->findOneBy(array('id' => 'F' . $node->getAttribute('id')));

                if ($data == null) {
                    $data = new Category();
                    $data->setId('F' . $node->getAttribute('id'));
                    $data->setKvsId($node->getAttribute('id'));
                    $data->setActive(1);
                    $data->setIsMain(0);
                    $data->setTitle($dataSrc['bezeichnung']);
                }
                $data->setKvsName($dataSrc['bezeichnung']);

                if (!in_array($node->getAttribute('id'), $insertedIds)) {
                    $insertedIds[] = $node->getAttribute('id');
                    $this->em->merge($data);
                }
            }
        }

        $this->em->flush();
    }

    /**
     * imports all the faculties and faculty groups from xml input file (fachbereich)
     */
//    public function importFaculty($utilityService) {
//        $content = $utilityService->getXmlContent($this->importFolder . "/fachbereich.xml", "bfiwien");
//
//        $this->processFacultyGroups($content, $utilityService);
//        $this->processFaculties($content, $utilityService);
//    }

    /**
     * scans the input xml data and finds the "fachgruppe" tags and writes them into db
     * 
     * @param type $content
     */
    private function processFacultyGroups($content, $utilityService) {
        $insertedIds = array();

        foreach ($content as $element) {
            $dataSrc = array();

            foreach ($element->childNodes as $node) {
                if ($node->nodeName == 'fachgruppen') {
                    foreach ($node->childNodes as $childNode) {
                        if ($childNode->nodeName != '#text') {
                            $data = $this->em->getRepository('DNTMBundle:FacultyGroup')->findOneBy(array('id' => $childNode->getAttribute('id')));

                            if ($data == null) {
                                $data = new FacultyGroup();
                                $data->setId($childNode->getAttribute('id'));
                            }
                            $data->setName($childNode->getAttribute('bezeichnung'));

                            if (!in_array($childNode->getAttribute('id'), $insertedIds)) {
                                $insertedIds[] = $childNode->getAttribute('id');
                                $this->em->merge($data);
                            }
                        }
                    }
                }
            }
        }

        $this->em->flush();
    }

    /**
     * scans the input xml data and finds the "fachbereich" tags and writes them into db
     * 
     * @param type $content
     */
    private function processFaculties($content, $utilityService) {
        $insertedIds = array();

        foreach ($content as $element) {
            $dataSrc = array();

            foreach ($element->childNodes as $node) {
                if ($node->nodeName != '#text') {
                    $data = $this->em->getRepository('DNTMBundle:Faculty')->findOneBy(array('id' => $node->getAttribute('id')));

                    if ($data == null) {
                        $data = new Faculty();
                        $data->setId($node->getAttribute('id'));
                    }
                    $data->setName($node->getAttribute('bezeichnung'));

                    if ($node->nodeName == 'fachgruppen') {
                        foreach ($node->childNodes as $childNode) {
                            if ($childNode->nodeName != '#text') {
                                
                            }
                        }
                    }

                    if (!in_array($node->getAttribute('id'), $insertedIds)) {
                        $insertedIds[] = $node->getAttribute('id');
                        $this->em->merge($data);
                    }
                }
            }
        }

        $this->em->flush();
    }

    /**
     * imports all the media from xml input file
     */
    public function importMedia($utilityService) {
        $content = $utilityService->getXmlContent($this->importFolder . "/mediendateien.xml", "bfiwien");

        $insertedIds = array();

        foreach ($content as $element) {
            $dataSrc = array();

            foreach ($element->childNodes as $node) {
                if ($node->nodeName != '#text') {
                    $dataSrc[$node->nodeName] = $node->nodeValue;
                }
            }

            $data = $this->em->getRepository('DNTMBundle:MediaFile')->findOneBy(array('id' => $element->getAttribute('id')));

            if ($data == null) {
                $data = new MediaFile();
                $data->setId($element->getAttribute('id'));
            }

            $data->setKbNumber($element->getAttribute('kb_nummer'));
            $data->setKbDate($element->getAttribute('kb_datum'));
            $data->setAvailableFrom(new \DateTime($dataSrc['gueltig_von']));
            $data->setAvailableTo(new \DateTime($dataSrc['gueltig_bis']));
            $data->setDescription($dataSrc['bezeichnung']);
            $data->setKbOrder($dataSrc['order']);
            $data->setFilename($dataSrc['datei']);
            $data->setUrl($dataSrc['url']);

            $product = $this->em->getRepository('DNTMBundle:Product')->findOneBy(array('kbNumber' => $element->getAttribute('kb_nummer'), 'kbDate' => new \DateTime($element->getAttribute('kb_datum'))));

            if ($product != null) {
                $data->setProduct($product);
            }

            if (!in_array($element->getAttribute('id'), $insertedIds)) {
                $insertedIds[] = $element->getAttribute('id');
                $this->em->merge($data);
            }
        }

        $this->em->flush();
    }

}
