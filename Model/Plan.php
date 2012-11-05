<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlan;

class Plan extends BasePlan
{

  public function  __toString()
  {
    return $this->getName();
  }

  public function isDisabled()
  {
    return $this->getDisabled();
  }

  public function isActive()
  {
    if ($this->isDisabled()) { return false; }
    $start = $this->getDateStart('Y-m-d H:i:s');
    $end = $this->getDateEnd('Y-m-d H:i:s');
    $now = date('Y-m-d H:i:s');

    return (($start == null || $start <= $now) &&
             ($end == null || $now <= $end));
  }

  public function isDefault() { return $this->getIsDefault(); }

  public function isFree() { return !$this->getPrice(); }

  public function getFree() { return $this->isFree(); }

  public function getFeatures()
  {
    return PlanFeatureQuery::create()
    ->usePlanFeatureDefinitionQuery()
    ->orderByRank(Criteria::ASC)
    ->endUse()
    ->find();
  }

  public function getFeature(PlanFeatureDefinition $definition)
  {
    $feature = PlanFeatureQuery::create()
      ->usePlanFeatureDefinitionQuery()
      ->filterByRank($definition->getRank())
      ->endUse()
      ->findOneByPlanId($this->getId());
    if (!$feature) {
      $feature = $definition->createFeature($this);
    }

    return $feature;
  }

  public function getPrices()
  {
    return $this->getPlanPricesRelatedByPlanId();
  }

  public function getDefaultPrice()
  {
    if ($this->getDefaultPriceId()) {
      return $this->getPlanPriceRelatedByDefaultPriceId();
    } else {
      return PlanPriceQuery::create()->
        filterByPlanId($this->getId())->
        findOne();
    }
  }

}
