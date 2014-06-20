<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\FeatureDefinitionQuery;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatrixController extends Controller
{
   /**
    * @Route("/matrix", name = "dzangocart_subscription_matrix")
    * @Template()
    */
    public function indexAction(Request $request)
    {
        $plans = PlanQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank()
            ->getActive()
            ->find();

        $features = FeatureDefinitionQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank()
            ->find();

        return array(
            'plans' => $plans,
            'features' => $features
        );
    }
}
