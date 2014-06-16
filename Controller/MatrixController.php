<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

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
		return array();
    }

    protected function getQuery()
    {
        return PlanQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank();
    }
}

