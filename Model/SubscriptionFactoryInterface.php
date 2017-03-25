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

    public function disable(DomainSubscriptionInterface $account);

    public function enable(DomainSubscriptionInterface $account);

    public function suspend(DomainSubscriptionInterface $account);

    public function reinstate(DomainSubscriptionInterface $account);

    public function close(DomainSubscriptionInterface $account);

    public function delete(DomainSubscriptionInterface $account);

    public function getDeprecatedAccounts();

    /**
     * Definitively removes closed accounts.
     */
    public function purge();
}
