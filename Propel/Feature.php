<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BaseFeature;

class Feature extends BaseFeature
{
    public function __toString()
    {
        return $this->getValue() .
            ($this->getUnitId() ? $this->getUnit()->getName() : '') .
            ($this->getPeriodId() ? '/' . $this->getPeriod()->getName() : '');
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
}
