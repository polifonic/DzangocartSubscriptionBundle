<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionFactoryInterface;

abstract class AbstractSubscriptionFactory implements SubscriptionFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createAccount()
    {
        $class = $this->getAccountClass();

        $account = new $class();

        $account->setFactory($this);

        $account->setPlan($this->getDefaultPlan());

        return $account;
    }

    public function getPlans()
    {
        return PlanQuery::create()
            ->active()
            ->orderByRank();
    }

    public function getDefaultPlan()
    {
        return PlanQuery::create()
            ->active()
            ->defaultPlan()
            ->orderByRank()
            ->findOne();
    }
}
