<?php

namespace Sidus\EAVModelBundle\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Sidus\EAVModelBundle\Model\FamilyInterface;

/**
 * Build complex doctrine queries with the EAV model
 *
 * @author Vincent Chalnot <vincent@sidus.fr>
 */
class SingleFamilyQueryBuilder extends EAVQueryBuilder
{
    /** @var FamilyInterface */
    protected $family;

    /**
     * @param FamilyInterface $family
     * @param QueryBuilder    $queryBuilder
     * @param string          $alias
     */
    public function __construct(FamilyInterface $family, QueryBuilder $queryBuilder, $alias = 'e')
    {
        parent::__construct($queryBuilder, $alias);
        $this->family = $family;

        $queryBuilder
            ->andWhere($alias.'.family = :familyCode')
            ->setParameter('familyCode', $family->getCode());
    }

    /**
     * @return FamilyInterface
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $attributeCode
     *
     * @return AttributeQueryBuilderInterface
     */
    public function attributeByCode($attributeCode)
    {
        $attribute = $this->getFamily()->getAttribute($attributeCode);

        return $this->attribute($attribute);
    }

    /**
     * @param string $attributeCode
     *
     * @return AttributeQueryBuilderInterface
     */
    public function a($attributeCode)
    {
        return $this->attributeByCode($attributeCode);
    }
}
