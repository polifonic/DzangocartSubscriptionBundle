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

    public function getFeatures($criteria = null, PropelPDO $con = null)
    {
        $features = array();

        foreach (parent::getFeatures() as $feature) {
            $features[$feature->getDefinitionId()] = $feature;
        }

        $query = FeatureQuery::create()
            ->joinWithI18n($this->getLocale())
            ->orderByRank();


        foreach ($query->find() as $feature) {
            $id = $feature->getId();

            if (array_key_exists($id, $_features)) {
                $plan_feature = $features[$id];
            } else {
                $plan_eature = new PlanFeature();
                $plan_feature->setFeature($feature);
                $plan_feature->setPlan($this);
            }

            $features[$id] = $plan_feature;
        }

        return $features;
    }

    public function getDefaultPrice()
    {
        return $this->getPrices(PriceQuery::create()->getDefault())
            ->getFirst();
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
