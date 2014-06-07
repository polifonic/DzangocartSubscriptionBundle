<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Criteria;

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

        $start = $this->getStart('U');
        $end = $this->getFinish('U');
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

    public function getFeatures(PropelPDO $con = null)
    {
        $_features = array();

        foreach ($this->getPlanFeatures() as $feature) {
            $_features[$feature->getDefinitionId()] = $feature;
        }

        $definitions = PlanFeatureDefinitionQuery::create()
            ->joinWithI18n($this->getLocale())
            ->orderByRank()
            ->find();

        $features = array();

        foreach ($definitions as $definition) {
            $id = $definition->getId();

            if (array_key_exists($id, $_features)) {
                $feature = $_features[$id];
            } else {
                $feature = new PlanFeature();
                $feature->setDefinition($definition);
                $feature->setPlan($this);
            }

            $features[$id] = $feature;
        }

        return $features;
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

    public function disable()
    {
        $this->setDisabled(true);
    }

    public function enable()
    {
        $this->setDisabled(false);
    }
}
