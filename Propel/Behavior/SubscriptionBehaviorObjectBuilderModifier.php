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
        $this->addIsExpired($script);
        
        return $script;
    }

    protected function addIsExpired(&$script)
    {
        $script .= "
 /**
 * Whether the subscription is expired
 *
 * @boolean tue if the subscription is expired, false otherwise
 */
public function isExpired()
{
    //codes here
}";
    }
}
