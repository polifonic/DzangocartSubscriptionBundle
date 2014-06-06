<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanPrice;
use NumberFormatter;

class PlanPrice extends BasePlanPrice
{

    protected $number_formatter;

    public function __toString()
    {
        return sprintf(
            '%s/%s',
            $this->getNumberFormatter()->formatCurrency($this->getPrice(), $this->getCurrency()),
            $this->getPeriod()->getName()
        );
    }

    public function format()
    {
        return $this->getNumberFormatter()->formatCurrency($this->getPrice(), $this->getCurrency());
    }

    protected function getNumberFormatter()
    {
        if (!$this->number_formatter) {
            $this->number_formatter = new NumberFormatter($this->getPlan()->getLocale(), NumberFormatter::CURRENCY);
        }

        return $this->number_formatter;
    }
}
