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

    public function objectMethods(PHP5ObjectBuilder $builder)
    {
        $this->builder = $builder;
        $script = '';
        $script .= $this->addIsExpired();
        return $script;
    }

    protected function addIsExpired()
    {
        return $this->behavior->renderTemplate('objectIsExpired', array(
            'column_name' => $this->table->getColumn($this->behavior->getParameter('expires_at_column'))->getPhpName()
        ));
    }
}
