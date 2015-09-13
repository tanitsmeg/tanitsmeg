<?php

namespace DN\TMBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\BaseRepository;

class TagRepository extends BaseRepository {

    /**
     * get course data by productId where begindate > current date
     *
     * @param type $productId
     */
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
