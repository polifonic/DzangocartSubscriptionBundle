<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

interface PlanInterface
{
    public function isDisabled();

    public function isActive();

    public function isInactive();

    public function isDefault();

    public function isFree();

    public function getFeatures();

    public function getPrices();

    public function getDefaultPrice();
}
