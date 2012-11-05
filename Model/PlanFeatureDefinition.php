<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanFeatureDefinition;

class PlanFeatureDefinition extends BasePlanFeatureDefinition
{
  public function createFeature(Plan $plan)
  {
    $feature = new PlanFeature();
    $feature->setDefinition($this);
    $feature->setPlan($plan);

    return $feature;
  }

  public function __toString()
  {
    return $this->getName();
  }
}
