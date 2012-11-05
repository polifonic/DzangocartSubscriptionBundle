<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanPeriod;

class PlanPeriod extends BasePlanPeriod
{
  public function __toString() { return $this->getCurrentTranslation()->getName(); }}
