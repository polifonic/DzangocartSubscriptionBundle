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
 * @boolean true if the subscription is expired, false otherwise
 */
public function isExpired()
{
    \$expire = \$this->get{$this->table->getColumn($this->behavior->getParameter('expires_at_column'))->getPhpName()}('U');

    return ( \$expire != null && \$expire < time());
}\n";
    }
}
