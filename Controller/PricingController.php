<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Templating\EngineInterface;

class PricingController
{
    protected $templating;

    protected $theme;

    protected $max_plans;

    public function __construct(EngineInterface $templating, $theme, $max_plans)
    {
        $this->templating = $templating;

        $this->theme = $theme;

        $this->max_plans = $max_plans;
    }

    public function indexAction(Request $request)
    {
        return new Response(
            $this->templating
                ->render(
                    'DzangocartSubscriptionBundle:Pricing:index.html.twig',
                    array(
                        'theme' => $this->getTheme(),
                    )
                )
            );
    }

    public function pricingAction(Request $request)
    {
        $plans = $this->getPlans($request->getLocale());

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

        return new Response(
            $this->templating
                ->render(
                    'DzangocartSubscriptionBundle:Pricing:pricing.html.twig',
                    array(
                        'plans' => $plans,
                        'plan_cols' => $plan_cols,
                        'row_cols' => $row_cols,
                    )
                )
            );
    }

    protected function getTheme()
    {
        return $this->theme;
    }

    protected function getMaxPlans()
    {
        return $this->max_plans;
    }

    protected function getPlans($locale)
    {
        return PlanQuery::create()
            ->joinWithI18n($locale)
            ->active()
            ->orderByRank()
            ->limit($this->getMaxPlans())
            ->find();
    }
}
