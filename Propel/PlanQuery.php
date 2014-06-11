<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanQuery;

class PlanQuery extends BasePlanQuery
{
    public function getActive()
    {
        return $this->
            // start date
            condition('start_min', 'plan.start <= ?', date('Y-m-d H:i:s'))->
            condition('start_null', 'plan.start IS NULL')->
            combine(array('start_min', 'start_null'), 'or', 'start')->

            // finish date
            condition('finish_min', 'plan.finish >= ?', date('Y-m-d H:i:s'))->
            condition('finish_null', 'plan.finish IS NULL')->
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
