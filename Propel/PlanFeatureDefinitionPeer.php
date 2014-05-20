<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

use Dzangocart\Bundle\SubscriptionBundle\Model\om\BasePlanFeatureDefinitionPeer;

class PlanFeatureDefinitionPeer extends BasePlanFeatureDefinitionPeer
{

	public static function getAll()
	{
		return PlanFeatureDefinitionQuery::create()
			->orderByRank(Criteria::ASC)
			->find();
	}
}
