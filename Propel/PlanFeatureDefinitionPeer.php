<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanFeatureDefinitionPeer;

class PlanFeatureDefinitionPeer extends BasePlanFeatureDefinitionPeer
{

    public static function getAll()
    {
        return PlanFeatureDefinitionQuery::create()
            ->orderByRank(Criteria::ASC)
            ->find();
    }
}
