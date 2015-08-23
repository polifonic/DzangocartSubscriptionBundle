
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
public function setFactory(DomainSubscriptionFactoryInterface $factory)
{
	$this->factory = $factory;
}
