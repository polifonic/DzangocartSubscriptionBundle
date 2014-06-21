<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PricingController extends Controller
{
    //this is hard coded here to cap off the plans that are shown in the pricing page
    const PRICING_SHOW_LIMIT = 5;

    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $theme = $this->container->getParameter('dzangocart_subscription.pricing.theme');

        return array(
            'theme' => $theme
        );
    }

    /**
     * @Template
     */
    public function pricingAction()
    {
        $plans = $this->getPlans();

        $count = count($plans);

        if ($count == 0) {
            throw new NotFoundHttpException('No plans to display');
        }

        if ($count > 5) {
            $plan_cols = 2;
            $row_cols = 12;
        } else {
            $plan_cols = 12 / $count;
            $row_cols = $count * 3;
        }

        return array(
            'plans' => $plans,
            'plan_cols' => $plan_cols,
            'row_cols' => $row_cols,
        );
    }

    protected function getPlans()
    {
        return PlanQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->getActive()
            ->orderByRank()
            ->limit(self::PRICING_SHOW_LIMIT)
            ->find();
    }
}
