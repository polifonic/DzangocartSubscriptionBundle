<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanQuery;

class PlanQuery extends BasePlanQuery
{
    public function getActive()
    {
        return $this->
            // start date
            condition('start_min', 'dzangocart_plan.start <= ?', date('Y-m-d H:i:s'))->
            condition('start_null', 'dzangocart_plan.start IS NULL')->
            combine(array('start_min', 'start_null'), 'or', 'start')->

            // finish date
            condition('finish_min', 'dzangocart_plan.finish >= ?', date('Y-m-d H:i:s'))->
            condition('finish_null', 'dzangocart_plan.finish IS NULL')->
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
