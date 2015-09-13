<?php

namespace DN\TMBundle\Transformer;

use DateTime;
use FOS\ElasticaBundle\Doctrine\AbstractElasticaToModelTransformer;
use Doctrine\ORM\Query;

class ElasticaToCustomPageTransformer extends AbstractElasticaToModelTransformer
{
    const ENTITY_ALIAS = 'cp';

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
            ->where($qb->expr()->in(static::ENTITY_ALIAS.'.'.$this->options['identifier'], ':values'))
            ->setParameters(array(
                'values' => $identifierValues,
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
