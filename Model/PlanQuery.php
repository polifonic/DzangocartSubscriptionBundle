<?php

namespace Dzangocart\SubscriptionBundle\Model;

use Dzangocart\SubscriptionBundle\Model\om\BasePlanQuery;

class PlanQuery extends BasePlanQuery
{
  public function getActive()
  {
    return $this->
      // date start
      condition('date_start_min', 'Plan.DateStart <= ?', date('Y-m-d H:i:s'))->
      condition('date_start_null', 'Plan.DateStart IS NULL')->
      combine(array('date_start_min', 'date_start_null'), 'or', 'date_start')->
      // date end
      condition('date_end_min', 'Plan.DateEnd >= ?', date('Y-m-d H:i:s'))->
      condition('date_end_null', 'Plan.DateEnd IS NULL')->
      combine(array('date_end_min', 'date_end_null'), 'or', 'date_end')->
      where(array('date_start', 'date_end'), 'and')->
      filterByDisabled(false);

  }
}
