<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanQuery;

class PlanQuery extends BasePlanQuery
{
    public function getActive()
    {
        return $this->
            // start date
            condition('start_min', PlanPeer::START.' <= ?', date('Y-m-d H:i:s'))->
            condition('start_null', PlanPeer::START.' IS NULL')->
            combine(array('start_min', 'start_null'), 'or', 'start')->

            // finish date
            condition('finish_min', PlanPeer::FINISH.' >= ?', date('Y-m-d H:i:s'))->
            condition('finish_null', PlanPeer::FINISH.' IS NULL')->
            combine(array('finish_min', 'finish_null'), 'or', 'finish')->
            where(array('start', 'finish'), 'and')->

            filterByDisabled(false);
    }

    public function isDefault()
    {
        return $this
            ->getActive()
            ->filterByTrial(true)
            ->orderByRank();
    }

    /**
     * @deprecated
     */
    public function getDefault()
    {
        return $this
            ->getActive()
            ->orderByRank()
            ->findOneByTrial(true);
    }
}
