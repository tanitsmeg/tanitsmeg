<?php

namespace DN\TMBundle\Base;

use Doctrine\ORM\EntityManager;

class BaseManager {

    protected $em;
    protected $class;
    protected $repository;

    public function __construct(EntityManager $em, $class) {
        $this->em           = $em;
        $this->repository   = $em->getRepository($class);

        $metadata           = $em->getClassMetadata($class);
        $this->class        = $metadata->name;
    }

    /**
     * inserts an element to the database
     * 
     * @param <type> $element : element to be inserted
     */
    public function insert($element) {
        $this->em->persist($element);
        $this->em->flush();
        return $element;
    }

    /**
     * updates an element in the database
     *
     * @param <type> $id : id of the element to be updated
     * @param <type> $element : element to be inserted
     */
    public function update($element) {
//        ezt valahogy másképp kéne csinálni - csak olyanra megy így, aminek van id-ja :)
        //$temp   = $this->repository->find($element->getId());
        //$temp   = $element;
        //$temp->setId($id);
        $this->em->merge($element);
        $this->em->flush();
    }

    /**
     * deletes an element from the database by it's id
     *
     * @param <type> $id : element's id to be deleted
     */
    public function delete($id) {
        $element    = $this->repository->find($id);
        $this->em->remove($element);
        $this->em->flush();
    }

    /**
     * returns an element from the database by it's id
     *
     * @param <type> $id : element's id to get
     */
    public function get($id) {
        $element    = $this->repository->find($id);
        return $element;
    }

    /**
     * loads all elements from the database
     *
     */
    public function loadAll() {
        $elements   = $this->repository->findAll();
        return $elements;
    }

    /**
     * returns an element by criteria (example: $criteria = array('age' => 25, 'name' => 'Dzsoni'))
     *
     */
    public function getByCriteria(array $criteria) {
        return $this->repository->findOneBy($criteria);
    }

    public function getByCriteriaOrderBy(array $criteria, array $orderBy) {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    /**
     * returns all elements by criteria
     *
     */
    public function loadByCriteria(array $criteria) {
        return $this->repository->findBy($criteria);
    }

    public function loadByCriteriaOrderBy(array $criteria, array $orderBy) {
        return $this->repository->findBy($criteria, $orderBy);
    }

    /**
     * deletes all elements by criteria
     *
     */
    public function deleteByCriteria(array $criteria) {
        $elements = $this->repository->findBy($criteria);
        foreach ($elements as $element) {
            $this->em->remove($element);
        }
        $this->em->flush();
    }

    /**
     * returns the class
     *
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * returns the result of the select (with limit)
     *
     * http://www.doctrine-project.org/docs/orm/2.0/en/reference/dql-doctrine-query-language.html
     * 
     */
    public function selectDql($dql, $limit) {
        $query = $this->em->createQuery($dql);
        if ($limit != null) {
            $query->setMaxResults($limit);
        }
        return $query->getResult();
    }

}
?>
