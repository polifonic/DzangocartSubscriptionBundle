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
    
    public function getUnit(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUnit === null && ($this->unit_id !== null) && $doQuery) {
            $this->aUnit = UnitQuery::create()
                ->joinWithI18n($this->getPlan()->getLocale())
                ->findPk($this->unit_id, $con);
        }

        return $this->aUnit;
    }
    
    public function getPeriod(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPeriod === null && ($this->period_id !== null) && $doQuery) {
            $this->aPeriod = PeriodQuery::create()
                ->joinWithI18n($this->getPlan()->getLocale())
                ->findPk($this->period_id, $con);
        }

        return $this->aPeriod;
    }
	
    public function getPlan(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPlan === null && ($this->plan_id !== null) && $doQuery) {
            $this->aPlan = PlanQuery::create()
				->joinWithI18n($this->getDefinition()->getLocale())
				->findPk($this->plan_id, $con);
        }

        return $this->aPlan;
    }
}
