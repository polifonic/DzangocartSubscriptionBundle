<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column' => 'plan_id',
        'expires_at_column' => 'expires_at'
    );

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'type' => 'INTEGER',
                'required' => 'true'
            ));

            $fk = new ForeignKey('FI_subscription_plan');
            $fk->setForeignTableCommonName('dzangocart_plan');
            $fk->setOnDelete(ForeignKey::RESTRICT);
            $fk->addReference($this->getParameter('plan_id_column'), 'id');
            $this->getTable()->addForeignKey($fk);
        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_at_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_at_column'),
                'type' => 'TIMESTAMP'
            ));
        }
    }
}
