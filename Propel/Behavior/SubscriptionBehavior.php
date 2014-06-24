<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;
use PropelTypes;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column'      => 'plan_id',
        'expires_at_column'   => 'expires_at'
    );

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'type' => 'INTEGER'
            ));
        } else {
            $plan_id_column = $this->getTable()->getColumn($this->getParameter('plan_id_column'));

            if (!(strtoupper($plan_id_column->getType()) == 'INTEGER' )) {
                $this->getTable()
                    ->removeColumn($plan_id_column);

                $plan_id_column->setType(PropelTypes::INTEGER);
                $plan_id_column->setSize(null);

                $this->getTable()
                    ->addColumn($plan_id_column);
            }

        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_at_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_at_column'),
                'type' => 'TIMESTAMP'
            ));
        } else {
            $expires_at_column = $this->getTable()->getColumn($this->getParameter('expires_at_column'));

            if (!(strtoupper($expires_at_column->getType()) == 'TIMESTAMP')) {
                $this->getTable()
                    ->removeColumn($expires_at_column);

                $expires_at_column->setType(PropelTypes::TIMESTAMP);
                $expires_at_column->setSize(null);

                $this->getTable()->addColumn($expires_at_column);
            }

        }

        $fk = new ForeignKey();
        $fk->setForeignTableCommonName('plan');
        $fk->setOnDelete(ForeignKey::RESTRICT);
        $fk->addReference($this->getParameter('plan_id_column'), 'id');
        $this->getTable()->addForeignKey($fk);
    }
}
