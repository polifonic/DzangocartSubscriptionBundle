<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use ArrayObject;
use PropelQuery;
use Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionFactoryInterface;

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

    public function getAccounts()
    {
        $query = $this->createQuery();

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
}
