<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanPriceQuery;

class PlanPriceQuery extends BasePlanPriceQuery
{
	public function getActive()
    {
        return $this->
            // start date
            condition('start_min', 'PlanPrice.Start <= ?', date('Y-m-d H:i:s'))->
            condition('start_null', 'PlanPrice.Start IS NULL')->
            combine(array('start_min', 'start_null'), 'or', 'start')->

            // finish date
            condition('finish_min', 'PlanPrice.Finish >= ?', date('Y-m-d H:i:s'))->
            condition('finish_null', 'PlanPrice.Finish IS NULL')->
            combine(array('finish_min', 'finish_null'), 'or', 'finish')->
            where(array('start', 'finish'), 'and')->

            filterByDisabled(false);
    }

	public function getDefault()
    {
        return $this
            ->getActive()
            ->orderByRank()
            ->findOneByIsDefault(true);
    }
}
