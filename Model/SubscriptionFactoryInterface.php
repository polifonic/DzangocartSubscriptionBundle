<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Model;

interface SubscriptionFactoryInterface
{
	/**
	 * Returns the class of the accounts
	 */
	public function getAccountClass();

	/**
	 * @return SubscriptionInterface
	 */
	public function createAccount();

	/**
	 * @return PlanInterface
	 */
	public function getDefaultPlan();
}