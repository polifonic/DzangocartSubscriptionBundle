<?php


namespace Dzangocart\Bundle\SubscriptionBundle\Model;

trait FactoryEnabledTrait
{
    protected $factory;

    public function getFactory()
    {
        return $this->factory;
    }

    public function setFactory(SubscriptionFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function getAccount()
    {
        return $this->getFactory()
            ->getAccount();
    }
}
