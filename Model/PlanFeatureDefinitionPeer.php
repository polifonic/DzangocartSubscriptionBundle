<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanFeatureDefinitionPeer;

class PlanFeatureDefinitionPeer extends BasePlanFeatureDefinitionPeer
{
  public static function getAll()
  {
    return PlanFeatureDefinitionQuery::create()
      ->orderByRank(Criteria::ASC)
      ->find();
  }
}
