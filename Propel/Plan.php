<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlan;

class Plan extends BasePlan
{
    public function isDisabled()
    {
        return $this->getDisabled();
    }

    public function isActive()
    {
        if ($this->isDisabled()) { return false; }

        $start = $this->getDateStart('U');
        $end = $this->getDateEnd('U');
        $now = time();

        return (($start == null || $start <= $now) &&
            ($end == null || $now <= $end));
    }

    public function isInactive()
    {
        return !$this->isActive();
    }

    public function isDefault()
    {
        return $this->getIsDefault();
    }

    public function isFree()
    {
        return !$this->getPrice();
    }

    public function getFree()
    {
        return $this->isFree();
    }

    public function getFeatures()
    {
        return PlanFeatureQuery::create()
            ->usePlanFeatureDefinitionQuery()
            ->orderByRank(Criteria::ASC)
            ->endUse()
            ->find();
    }

    public function getFeature(PlanFeatureDefinition $definition)
    {
        $feature = PlanFeatureQuery::create()
            ->usePlanFeatureDefinitionQuery()
            ->filterByRank($definition->getRank())
            ->endUse()
            ->findOneByPlanId($this->getId());

        if (!$feature) {
            $feature = $definition->createFeature($this);
        }

        return $feature;
    }

    public function getDefaultPrice()
    {
        return $this->getPrices(PlanPriceQuery::create()->getDefault());
    }
}
