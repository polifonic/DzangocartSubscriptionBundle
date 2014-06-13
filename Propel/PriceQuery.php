<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Criteria;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePriceQuery;

class PriceQuery extends BasePriceQuery
{
    public function getDefault()
    {
		return $this
            ->filterByIsDefault(true)
			->orderByRank(Criteria::ASC)
			->limit(1);
	}
}
