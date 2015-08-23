<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

interface SubscriptionInterface
{
	public function getPlan();

//	public function getExpiredAt();

//	public function isValid();

//	public function isExpired();

	public function isSuspended();

	public function isDisabled();

	public function isClosed();

//	public function hasFeature($feature);

//	public function close();

//	public function disable();

//	public function enable();

//	public function suspend();

//	public function reactivate();

	public function setFactory(SubscriptionFactoryInterface $factory);
}

