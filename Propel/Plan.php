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

    public function getFeatures($criteria = null, PropelPDO $con = null)
    {
        $_features = array();

        foreach (parent::getFeatures() as $feature) {
            $_features[$feature->getDefinitionId()] = $feature;
        }

        $definitions = FeatureDefinitionQuery::create()
            ->joinWithI18n($this->getLocale())
            ->orderByRank()
            ->find();

        $features = array();

        foreach ($definitions as $definition) {
            $id = $definition->getId();

            if (array_key_exists($id, $_features)) {
                $feature = $_features[$id];
            } else {
                $feature = new Feature();
                $feature->setDefinition($definition);
                $feature->setPlan($this);
            }

            $features[$id] = $feature;
        }

        return $features;
    }

    public function getDefaultPrice()
    {
        return $this->getPrices(PriceQuery::create()->getDefault());
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
