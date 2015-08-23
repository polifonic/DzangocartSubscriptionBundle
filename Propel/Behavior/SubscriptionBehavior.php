<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;
use Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionInterface;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column' => 'plan_id',
        'expires_at_column' => 'expires_at',
        'trial_plan_id_column' => 'trial_plan_id',
        'trial_expires_at_column' => 'trial_expires_at',
        'plan_table' => 'dzangocart_subscription_plan',
    );

    protected $objectBuilderModifier;

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'phpName' => 'PlanId',
                'type' => 'INTEGER',
                'required' => true,
            ));

            $fk = new ForeignKey('FK_subscription_plan');
            $fk->setForeignTableCommonName($this->getParameter(
                'plan_table'));
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
                'required' => false,
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('trial_plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('trial_plan_id_column'),
                'phpName' => 'TrialPlanId',
                'type' => 'INTEGER',
                'required' => false,
            ));

            $fk = new ForeignKey('FK_subscription_trial_plan');
            $fk->setForeignTableCommonName($this->getParameter('plan_table'));
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
                'required' => false,
            ));
        }
    }

    public function objectFilter(&$script)
    {
        $pattern = '/abstract class (\w+) extends (\w+) implements (\w+)/i';
        $replace = 'abstract class ${1} extends ${2} implements ${3}, SubscriptionInterface';
        $script = preg_replace($pattern, $replace, $script);
    }

    public function getObjectBuilderModifier()
    {
        if (is_null($this->objectBuilderModifier)) {
            $this->objectBuilderModifier = new SubscriptionBehaviorObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
}
