<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanFeatureDefinition;

class PlanFeatureDefinition extends BasePlanFeatureDefinition
{
    public function createFeature(Plan $plan)
    {
        $feature = new PlanFeature();
        $feature->setDefinition($this);
        $feature->setPlan($plan);

        return $feature;
    }
}
