<?php

namespace DN\TMBundle\Transformer;

use DateTime;
use FOS\ElasticaBundle\Doctrine\AbstractElasticaToModelTransformer;
use Doctrine\ORM\Query;

class ElasticaToProductTransformer extends AbstractElasticaToModelTransformer
{
    const ENTITY_ALIAS = 'p';

    /**
     * Fetch Product from Doctrine for the given Elasticsearch identifiers
     *
     * @param array $identifierValues ids values
     * @param Boolean $hydrate whether or not to hydrate the objects, false returns arrays
     * @return array of objects or arrays
     */
    protected function findByIdentifiers(array $identifierValues, $hydrate)
    {
        if (empty($identifierValues)) {
            return array();
        }

        $hydrationMode = $hydrate ? Query::HYDRATE_OBJECT : Query::HYDRATE_ARRAY;
        $qb = $this->getEntityQueryBuilder();

        $qb
            ->select(static::ENTITY_ALIAS.',c')
            ->innerJoin(static::ENTITY_ALIAS.'.courses','c')
            ->where($qb->expr()->in(static::ENTITY_ALIAS.'.'.$this->options['identifier'], ':values'))
            ->andWhere('c.beginDate > :beginDate')
            ->orderBy('c.beginDate')
            ->setParameters(array(
                'values' => $identifierValues,
                'beginDate' => new \DateTime(),
            ))
        ;

        return $qb->getQuery()->setHydrationMode($hydrationMode)->execute();
    }

    /**
     * Retrieves a query builder to be used for querying by identifiers
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getEntityQueryBuilder()
    {
        $repository = $this->registry
            ->getManagerForClass($this->objectClass)
            ->getRepository($this->objectClass);
        return $repository->{$this->options['query_builder_method']}(static::ENTITY_ALIAS);
    }
}
