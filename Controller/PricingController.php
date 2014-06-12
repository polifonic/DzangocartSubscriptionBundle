<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/pricing")
 * @Template
 */
class PricingController extends Controller
{
    //this is hard coded here to cap off the plans that are shown in the pricing page
    const PRICING_SHOW_LIMIT = 5;
    
    /**
     * @Template() 
     */
    public function pricingAction(Request $request)
    {
        $col_width = 2;
        $row_width = 12;

        $plans = $this->getQuery()
            ->getActive()
            ->limit(self::PRICING_SHOW_LIMIT)
            ->find();
        
        $plans_count = count($plans);

        if ($plans_count > 0 && $plans_count < 5  ) {
            $col_width = 12 / $plans_count;
            $row_width = $plans_count * 3;
        }

        return array(
            'plans' => $plans,
            'col_width' => $col_width,
            'row_width' => $row_width
        );
    }
    
    protected function getQuery()
    {
        return PlanQuery::create()
                ->joinWithI18n($this->getRequest()->getLocale())
                ->orderByRank();
    }

}

