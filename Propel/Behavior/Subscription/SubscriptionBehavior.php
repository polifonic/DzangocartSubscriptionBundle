<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior\Subscription;

use Behavior;
use ForeignKey;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column' => 'plan_id',
        'expires_at_column' => 'expires_at',
        'trial_plan_id_column' => 'trial_plan_id',
        'trial_expires_at_column' => 'trial_expires_at',
    );

    protected $objectBuilderModifier;

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'phpName' => 'PlanId',
                'type' => 'INTEGER',
                'required' => true
            ));

            $fk = new ForeignKey('FI_subscription_plan');
            $fk->setForeignTableCommonName('dzangocart_subscription_plan');
            $fk->setOnDelete(ForeignKey::RESTRICT);
            $fk->addReference($this->getParameter('plan_id_column'), 'id');
            $fk->setPhpName('Plan');
            $this->getTable()->addForeignKey($fk);
        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_at_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_at_column'),
                'phpName' => 'ExpiresAt',
                'type' => 'TIMESTAMP',
                'required' => false
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('trial_plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('trial_plan_id_column'),
                'phpName' => 'TrialPlanId',
                'type' => 'INTEGER',
                'required' => false
            ));

            $fk = new ForeignKey('FI_subscription_trial_plan');
            $fk->setForeignTableCommonName('dzangocart_subscription_plan');
            $fk->setOnDelete(ForeignKey::RESTRICT);
            $fk->addReference($this->getParameter('trial_plan_id_column'), 'id');
            $fk->setPhpName('TrialPlan');
            $this->getTable()->addForeignKey($fk);
        }

        if (!$this->getTable()->containsColumn($this->getParameter('trial_expires_at_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('trial_expires_at_column'),
                'phpName' => 'TrialExpiresAt',
                'type' => 'TIMESTAMP',
                'required' => false
            ));
        }

    }

    public function getObjectBuilderModifier()
    {
        if (is_null($this->objectBuilderModifier)) {
            $this->objectBuilderModifier = new SubscriptionBehaviorObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
}
