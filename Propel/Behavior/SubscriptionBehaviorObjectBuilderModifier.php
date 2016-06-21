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

    public function objectFilter(&$script)
    {
        $pattern = '/abstract class (\w+) extends (\w+) implements (\w+)/i';
        $replace = 'abstract class ${1} extends ${2} implements ${3}, SubscriptionInterface';
        $script = preg_replace($pattern, $replace, $script);
    }

    public function objectAttributes($builder)
    {
        $script = '
/**
 * The factory associated with this account
 * @var SubscriptionFactoryInterface
 */
protected $factory;
';

        return $script;
    }

    public function objectMethods($builder)
    {
        $this->builder = $builder;

        $this->declareClasses($this->builder);

        $script = '';
        $script .= $this->addGetSetFactory();
        $script .= $this->addIsExpired();
        $script .= $this->addIsTrial();
        $script .= $this->add__call();
        $script .= $this->addLoadValidatorMetadata();

        return $script;
    }

    protected function declareClasses($builder)
    {
        $builder->declareClass('PropelException');

        $builder->declareClass('Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionFactoryInterface');

        $builder->declareClass('Propel\PropelBundle\Util\PropelInflector');

        $builder->declareClass('Dzangocart\Bundle\SubscriptionBundle\Model\SubscriptionInterface');

        $builder->declareClass('Symfony\Component\Validator\Constraints\NotNull');

        $builder->declareClass('Symfony\Component\Validator\Mapping\ClassMetadata');
    }

    protected function addGetSetFactory()
    {
        $script = '
/**
 * {@inheritdoc}
 */
public function getFactory()
{
    return $this->factory;
}

/**
 * {@inheritdoc}
 */
public function setFactory(SubscriptionFactoryInterface $factory)
{
    $this->factory = $factory;
}
';

        return $script;
    }

    protected function addIsExpired()
    {
        $column = $this->table
            ->getColumn($this->behavior->getParameter('expires_at_column'))
            ->getPhpName();

        $script = sprintf("
/**
 * Whether the subscription is expired.
 *
 * @boolean true if the subscription is expired, false otherwise
 */
public function isExpired()
{
    \$expire = \$this->get%s('U');

    return (\$expire != null && \$expire < time());
}
",
        $column);

        return $script;
    }

    protected function addIsTrial()
    {
        $column = $this->table
            ->getColumn($this->behavior->getParameter('trial_expires_at_column'))
            ->getPhpName();

        $script = sprintf("
/**
 * Whether the subscription is currently during a trial period.
 *
 * @boolean true if the subscription is during a trial period, false otherwise
 */
public function isTrial()
{
    \$expire = \$this->get%s('U');

    return (\$expire != null && \$expire < time());
}
",
        $column);

        return $script;
    }

    protected function addLoadValidatorMetadata()
    {
        $script = sprintf('
/**
 * Add validation constraints.
 */
public static function loadValidatorMetadata(ClassMetadata $metadata)
{
%s
}
',
        $this->addLoadValidatorMetadataBody());

        return $script;
    }

    protected function addLoadValidatorMetadataBody()
    {
        $column = $this->table
            ->getColumn($this->behavior->getParameter('plan_id_column'))
            ->getName();

        $script = sprintf("
    \$metadata->addPropertyConstraint(
        '%s',
        new NotNull(array(
            'message' => 'validation.error.plan_id.null'
        ))
    );
",
        $column);

        return $script;
    }

    protected function add__call()
    {
        $script = "
/**
 * Magic method to return subscription's feature value
 */
public function __call(\$name, \$params)
{
    if (substr(\$name, 0, 3) == 'get') {
        \$planFeatures = \$this->getPlan()->getFeatures();

        foreach (\$planFeatures as \$planFeature) {
            \$feature = \$planFeature->getFeature();

            if (PropelInflector::camelize(\$feature->getPropertyName()) == PropelInflector::camelize(substr(\$name, 3))) {
                return (string) \$planFeature;
            }
        }
    }

    throw new PropelException('Call to undefined method ' . \$name);
}
";

        return $script;
    }
}
