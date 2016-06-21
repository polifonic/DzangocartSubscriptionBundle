<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\FeatureQuery;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class MatrixController
{
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function indexAction(Request $request)
    {
        $plans = PlanQuery::create()
            ->joinWithI18n($request->getLocale())
            ->orderByRank()
            ->active()
            ->find();

        $plan_features = FeatureQuery::create()
            ->joinWithI18n($request->getLocale())
            ->orderByRank()
            ->find();

        return new Response(
            $this->templating
                ->render(
                    'DzangocartSubscriptionBundle:Matrix:index.html.twig',
                    array(
                        'plans' => $plans,
                        'planfeatures' => $plan_features,
                    )
                )
            );
    }
}
