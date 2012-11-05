<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanPeer;

class PlanPeer extends BasePlanPeer
{
 public static function getDefaultPlan()
 {
    $c = new Criteria();
    $time = date('Y-m-d H:i:s');
    $c1 = $c->getNewCriterion(PlanPeer::DATE_START, null, Criteria::ISNULL);
    $c1->addOr($c->getNewCriterion(PlanPeer::DATE_START, $time, Criteria::LESS_EQUAL));
    $c2 = $c->getNewCriterion(PlanPeer::DATE_END, null, Criteria::ISNULL);
    $c2->addOr($c->getNewCriterion(PlanPeer::DATE_END, $time, Criteria::GREATER_EQUAL));
    $c->add($c1);
    $c->add($c2);
    $c->add(PlanPeer::IS_DEFAULT, 1);

    $c->addAscendingOrderByColumn(PlanPeer::RANK);

    return self::doSelectOne($c);
  }
}
