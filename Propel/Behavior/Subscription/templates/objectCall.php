
/**
 * magic method to return subscription's feature value
 */
public function __call($name, $params)
{
    if (substr($name, 0, 3) == 'get') {
        $planFeatures = $this->getPlan()->getFeatures();

        foreach ($planFeatures as $planFeature) {
            $feature = $planFeature->getFeature();

            if ($feature->getName() == substr($name,3)) {
                return (string) $planFeature;
            }
        }
    }

    throw new PropelException('Call to undefined method: ' . $name);
}
