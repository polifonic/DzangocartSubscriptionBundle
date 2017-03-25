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

    public function disable(SubscriptionInterface $account);

    public function enable(SubscriptionInterface $account);

    public function suspend(SubscriptionInterface $account);

    public function reinstate(SubscriptionInterface $account);

    public function close(SubscriptionInterface $account);

    public function delete(SubscriptionInterface $account);

    public function getDeprecatedAccounts();

    /**
     * Definitively removes closed accounts.
     */
    public function purge();
}
