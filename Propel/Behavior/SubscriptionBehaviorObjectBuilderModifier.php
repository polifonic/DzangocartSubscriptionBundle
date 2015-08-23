<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

class SubscriptionBehaviorObjectBuilderModifier
{
    protected $behavior, $table, $builder;

    public function __construct($behavior)
    {
        $this->behavior = $behavior;
        $this->table = $behavior->getTable();
    }

    public function objectAttributes($builder)
    {
        return $this->behavior->renderTemplate('objectAttributes');
    }

    public function objectMethods($builder)
    {
        $this->builder = $builder;

        $this->builder->declareClass('Propel\PropelBundle\Util\PropelInflector');

        $script = '';
        $script .= $this->addGetSetFactory();
        $script .= $this->addIsExpired();
        $script .= $this->addIsTrial();
        $script .= $this->add__call();

/*
        if (!$this->table->getBehavior('domainsubscription')) {
            $this->builder->declareClass('Symfony\Component\Validator\Constraints\NotNull');
            $script .= $this->addLoadValidatiorMetadata();
        }
*/
        return $script;
    }

    protected function addGetSetFactory()
    {
        return $this->behavior->renderTemplate('objectGetSetFactory');
    }

    protected function addIsExpired()
    {
        return $this->behavior->renderTemplate('objectIsExpired', array(
            'column_name' => $this->table->getColumn($this->behavior->getParameter('expires_at_column'))->getPhpName(),
        ));
    }

    protected function addIsTrial()
    {
        return $this->behavior->renderTemplate('objectIsTrial', array(
            'column_name' => $this->table->getColumn($this->behavior->getParameter('trial_expires_at_column'))->getPhpName(),
        ));
    }

    protected function addLoadValidatiorMetadata()
    {
        return $this->behavior->renderTemplate('objectLoadValidatorMetadata', array(
            'plan_id_column' => $this->table->getBehavior('subscription')->getParameter('plan_id_column'),
        ));
    }

    protected function add__call()
    {
        return $this->behavior->renderTemplate('objectCall', array());
    }
}
