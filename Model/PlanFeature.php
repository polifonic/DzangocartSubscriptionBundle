<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanFeature;

class PlanFeature extends BasePlanFeature
{

  public function __toString()
  {
    return $this->getValue() .
      ($this->getUnitId() ? $this->getUnit()->getName() : '') .
      ($this->getPeriodId() ? '/' . $this->getPeriod()->getName() : '');
  }

  public function getDefinition()
  {
    return $this->getPlanFeatureDefinition();
  }

  public function setDefinitionId($id)
  {
    if ($this->definition_id) { return; }
    parent::setDefinitionId($id);
  }

  public function setPlanFeatureDefinition(PlanFeatureDefinition $definition = null)
  {
    if ($this->definition_id) { return; }
    parent::setPlanFeatureDefinition($definition);
  }

  public function setDefinition(PlanFeatureDefinition $definition)
  {
    $this->setPlanFeatureDefinition($definition);
  }

  public function setPlanId($id)
  {
    if ($this->plan_id) { return; }
    parent::setPlanId($id);
  }

  public function setPlan(Plan $plan = null)
  {
    if ($this->plan_id) { return; }
    parent::setPlan($plan);
  }

  public function getUnit()
  {
    return $this->getPlanUnit();
  }

  public function getPeriod()
  {
    return $this->getPlanPeriod();
  }
}
