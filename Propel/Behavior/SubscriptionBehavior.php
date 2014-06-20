<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column'      => 'plan_id',
        'expires_at_column'      => 'expires_at'
    );

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'type' => 'INTEGER'
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_at_column'),
                'type' => 'TIMESTAMP'
            ));
        }

        $fk = new ForeignKey();
        $fk->setForeignTableCommonName('plan');
        $fk->setDefaultJoin('LEFT JOIN');
        $fk->setOnDelete(ForeignKey::CASCADE);
        $fk->setOnUpdate(ForeignKey::NONE);
        $fk->addReference($this->getParameter('plan_id_column'),'id');
        $this->getTable()->addForeignKey($fk);
    }
}
