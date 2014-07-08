<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePrice;
use NumberFormatter;

class Price extends BasePrice
{
    protected $number_formatter;

    public function __toString()
    {
        return sprintf(
            '%s/%s',
            $this->format(),
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

    public function getPeriod(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPeriod === null && ($this->period_id !== null) && $doQuery) {
            $this->aPeriod = PeriodQuery::create()
                ->joinWithI18n($this->getPlan()->getLocale())
                ->findPk($this->period_id, $con);
        }

        return $this->aPeriod;
    }

    public function getCurrencySymbol()
    {
        return Intl::getCurrencyBundle()->getCurrencySymbol($this->getCurrency());
    }
}
