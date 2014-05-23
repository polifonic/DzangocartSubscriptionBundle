DzangocartSubscriptionBundle
============================

Symfony 2 bundle for dzangocart subscription accounts

Requirements
~~~~~~~~~~~~

TODO

Installation
~~~~~~~~~~~~
Add the following to your project's `composer.json` file:

	{
		require: {
			"dzangocart/subscription-bundle": "dev-master"
		}
	}

Register the bundle:

	#app/AppKernel.php
	public function registerBundles()
    {
    	$bundles = array(
    		…
    		new DzangocartSubscriptionBundle()
    	);

    	return $bundles;
    }

If you are using assetic, add the bundle to the assetic configuration:

	#config.yml
	assetic:
		DzangocartSubscriptionBundle

Configuration
~~~~~~~~~~~~~

TODO

Usage
~~~~~

TODO

Fixtures
~~~~~~~~

For your convenience, several fixtures are included in the bundle, under `Resources\fixtures'.

Some of these fixtures only have demonstration value (plans, features) but others like units and periods,
may be of some practical use. To load the fixtures into your database using propel:

    php app/console propel:fixtures:load @DzangocartSubscriptionBundle