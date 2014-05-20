<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

use Dzangocart\Bundle\SubscriptionBundle\Model\om\BasePlanPeriod;

class PlanPeriod extends BasePlanPeriod
{

	public function __toString()
	{
		return $this->getCurrentTranslation()->getName();
	}
}
