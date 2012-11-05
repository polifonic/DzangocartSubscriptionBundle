<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanPrice;

class PlanPrice extends BasePlanPrice
{

  protected $number_formatter;

  public function __toString()
  {
    return sprintf('%s/%s',
                   $this->getNumberFormatter()->formatCurrency($this->getPrice(), $this->getCurrency()),
                   $this->getPeriod()->getName());
  }

  public function getPlan()
  {
    return $this->getPlanRelatedByPlanId();
  }

  public function getPeriod()
  {
    return $this->getPlanPeriod();
  }

  public function format()
  {
    return $this->getNumberFormatter()->formatCurrency($this->getPrice(), $this->getCurrency());
  }

  protected function getNumberFormatter()
  {
    if (!$this->number_formatter) {
      $this->number_formatter = new NumberFormatter($this->getPlan()->getCulture(), NumberFormatter::CURRENCY);
    }

    return $this->number_formatter;
  }
}
