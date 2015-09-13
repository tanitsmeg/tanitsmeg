<?php

namespace DN\TMBundle\Paginator;

use FOS\ElasticaBundle\Paginator\RawPartialResults;
use FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface;
use Elastica\ResultSet;

/**
 * Partial transformed result set
 */
class TransformedPartialResults extends RawPartialResults
{
    protected $transformer;

    /**
     * @param ResultSet $resultSet
     * @param \FOS\ElasticaBundle\Transformer\ElasticaToModelTransformerInterface $transformer
     */
    public function __construct(ResultSet $resultSet, ElasticaToModelTransformerInterface $transformer)
    {
        parent::__construct($resultSet);

        $this->transformer = $transformer;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->transformer->hybridTransform($this->resultSet->getResults());
    }
}