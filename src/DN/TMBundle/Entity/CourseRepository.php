<?php

namespace DN\TMBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\CourseTag;
use DN\TMBundle\Entity\BaseRepository;

class CourseRepository extends BaseRepository {

    public function saveForm($object) {
        if ($object->getId() == null) {
            $object->setCreated(new \DateTime('now'));
            $object->setActive(true);
        }

        foreach ($object->getCourseTimes() as $ct) {
            $ct->setCourse($object);
//            $ct->setTo(null);
//            $ct->setFrom(null);
//            $this->getEntityManager()->persist($ct);
        }
        
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();

        foreach ($object->tags as $t) {
            $ct = new CourseTag();
            $ct->setCourse($object);
            $ct->setTag($t);
            $this->getEntityManager()->persist($ct);
        }
        
        $this->getEntityManager()->flush();

        return $object;
    }

    public function getCoursesByFilters($filters) {
        $qb = $this->createQueryBuilder('c');
        $qb->select(array('c'))
                ->where('c.active = TRUE')
                ->orderBy('c.fromDate')
        ;
        
        if (isset($filters['text']) && !empty($filters['text'])) {
            $qb
                    ->andWhere('c.title LIKE :text')
                    ->orWhere('c.description LIKE :text')
                    ->setParameter('text', '%' . $filters['text'] . '%')
            ;
        }

        if (isset($filters['tags']) && !empty($filters['tags'])) {
            $qb
                    ->innerJoin('c.tags', 't')
                    ->andWhere('t.slug IN (:tagSlugs)')
                    ->setParameter('tagSlugs', array_values($filters['tags']))
            ;
        }

        if (isset($filters['params']) &&!empty($filters['params'])) {
            foreach ($filters['params'] as $param) {
                switch ($param) {
                    case 'pets':
                        $qb
                                ->andWhere('c.pet = TRUE')
                        ;
                        break;
                    case 'wheelchair':
                        $qb
                                ->andWhere('c.wheelchair = TRUE')
                        ;
                        break;
                    case 'earlybird':
                        $qb
                                ->andWhere('c.discountEarlybirdActive = TRUE')
                        ;
                        break;
                    case 'group':
                        $qb
                                ->andWhere('c.discountGroupActive = TRUE')
                        ;
                        break;
                }
            }
        }
        $q = $qb->getQuery();

        return $q->getResult();
    }

    public function getProductWithActiveCourses($productId) {
        $qb = $this->createQueryBuilder('p');
        $qb->select(array('p', 'c'))
                ->innerJoin('p.courses', 'c')
                ->where('p.id = :productId')
                ->andWhere('c.beginDate > :beginDate')
                ->orderBy('c.beginDate')
                ->setParameters(array(
                    'productId' => $productId,
                    'beginDate' => new DateTime(),
        ));
        $q = $qb->getQuery();

        return $q->getSingleResult();
    }

    /**
     * get course data by productId where begindate > current date
     *
     * @param type $productId
     */
    public function getProductAndCategoryWithActiveCourses($productId) {
        $qb = $this->createQueryBuilder('p');
        $qb->select(array('p', 'c'))
                ->innerJoin('p.courses', 'c')
                ->where('p.id = :productId')
                ->andWhere('c.beginDate > :beginDate')
                ->orderBy('c.beginDate')
                ->setParameters(array(
                    'productId' => $productId,
                    'beginDate' => new DateTime(),
        ));
        $q = $qb->getQuery();

        return $q->getSingleResult();
    }

}
