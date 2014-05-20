<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

use Dzangocart\Bundle\SubscriptionBundle\Model\om\BasePlanFeatureDefinition;

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
