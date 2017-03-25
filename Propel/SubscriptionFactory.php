<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use ArrayObject;
use Criteria;
use PropelQuery;
use Dzangocart\Bundle\SubscriptionBundle\Model\Status;
use Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionFactoryInterface;
use Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionInterface;

class SubscriptionFactory implements SubscriptionFactoryInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getAccountClass()
    {
        return $this->class;
    }

    public function getAccounts($exclude_closed = true)
    {
        $query = $this->createQuery();

        if ($exclude_closed) {
            $query->filterByStatus(Status::CLOSED, Criteria::NOT_EQUAL);
        }

        $accounts = array();

        foreach ($query->find() as $account) {
            $account->setFactory($this);

            $accounts[] = $account;
        }

        return new ArrayObject($accounts);
    }

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

    /**
     * Create the propel query class corresponding to your account class.
     *
     * @return ModelCriteria the queryClass
     */
    protected function createQuery()
    {
        return PropelQuery::from(sprintf('%s %s', $this->getAccountClass(), 'account'))
            ->innerJoin('Plan');
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

    /**
     * {@inheritdoc}
     */
    public function disable(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function enable(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function suspend(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reinstate(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function close(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function delete(SubscriptionInterface $account)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getDeprecatedAccounts()
    {
        return $this->findAccountsByStatus(Status::CLOSED);
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        foreach ($this->getDeprecatedAccounts() as $account) {
            $account->delete();
        }
    }
}
