<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

interface SubscriptionFactoryInterface
{
    /**
     * Returns the class of the accounts.
     */
    public function getAccountClass();

    /**
     * @return SubscriptionInterface
     */
    public function createAccount();

    /**
     * @returns all accounts
     */
    public function getAccounts($exclude_closed = true);

    /**
     * @return PlanInterface
     */
    public function getDefaultPlan();
}
