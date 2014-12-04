<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFeaturesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanPricesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PlanController
{
    protected $templating;
    protected $request_stack;
    protected $form_factory;
    protected $router;
    protected $session;
    protected $translator;

    public function __construct(FormFactory $form_factory, RequestStack $request_stack, Router $router, Session $session, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->templating = $templating;
        $this->request_stack = $request_stack;
        $this->form_factory = $form_factory;
        $this->router = $router;
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * Lists all Plans.
     * @Template("DzangocartSubscriptionBundle:Plan:index.html.twig")
     */
    public function indexAction()
    {
        $plans = $this->getQuery()
            ->find();

        return array(
                'plans' => $plans
            );
    }

    /**
     * Displays a Plan.
     * @Template("DzangocartSubscriptionBundle:Plan:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        return array(
            'plan' => $plan
        );
    }

    /**
     * Displays a form to edit an existing Plan.
     * @Template("DzangocartSubscriptionBundle:Plan:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->form_factory->create(
            new PlanFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->router->generate('dzangocart_subscription_plan_edit',
                    array('id' => $id)
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();

            $this->session->getFlashBag()->add(
                'plan.edit',
                $this->translator->trans('plan.edit.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * Delete existing Plan entity.
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->delete();

        $this->session->getFlashBag()->add(
            'success',
            $plan->getName() . " " . $this->translator->trans(
                'plan.delete.success',
                array(),
                'dzangocart_subscription',
                $request->getLocale()
            )
        );

        return new RedirectResponse($this->router->generate('dzangocart_subscription_plans'));
    }

    /**
     * Create a Plan entity.
     * @Template("DzangocartSubscriptionBundle:Plan:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $plan = new Plan();

        $plan->setLocale($request->getLocale());

        $form = $this->form_factory->create(
            new PlanFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->router->generate(
                    'dzangocart_subscription_plan_create'
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();

            return new RedirectResponse($this->router
                ->generate(
                    'dzangocart_subscription_plan',
                    array('id' => $plan->getId())
                )
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * @Template()
     */
    public function disableAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        if (!$plan->getTrial()) {
            $plan->disable();

            $plan->save();
        } else {
            $this->session->getFlashBag()->add(
                'dzangocart.plans.unsuccess',
                $this->translator->trans('plan.plans.actions.error.disable',
                    array(
                        '%plan%' => $plan->getName()
                    ),
                    'dzangocart_subscription',
                    $request->getLocale()
                )
            );
        }

        return new RedirectResponse($this->router
            ->generate(
                'dzangocart_subscription_plans'
            )
        );
    }

    /**
     * @Template()
     */
    public function enableAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->enable();

        $plan->save();

        return new RedirectResponse($this->router
            ->generate(
                'dzangocart_subscription_plans'
            )
        );
    }

    /**
     * set a plan as default plan for trial period.
     * @Template()
     */
    public function setDefaultAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        if (!$plan->isDisabled()) {
            $plan->setAsTrialPlan();
            $this->session->getFlashBag()->add(
                'dzangocart.plans.success',
                $this->translator->trans('plan.plans.actions.success.set_default',
                    array(
                        '%plan%' => $plan->getName()
                    ),
                    'dzangocart_subscription',
                    $request->getLocale()
                )
            );
        } else {
            $this->session->getFlashBag()->add(
                'dzangocart.plans.unsuccess',
                $this->translator->trans('plan.plans.actions.error.set_default',
                    array(
                        '%plan%' => $plan->getName()
                    ),
                    'dzangocart_subscription',
                    $request->getLocale()
                )
            );
        }

        return new RedirectResponse($this->router
            ->generate(
                'dzangocart_subscription_plans'
            )
        );
    }

    /**
     * remove plan as default plan for trial period
     * @Template()
     */
    public function removeDefaultAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->unsetAsTrialPlan();

        return new RedirectResponse($this->router
            ->generate(
                'dzangocart_subscription_plans'
            )
        );
    }

    /**
     * Displays a form to edit a Plan's features.
     * @Template("DzangocartSubscriptionBundle:Plan:features.html.twig")
     */
    public function featuresAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->form_factory->create(
            new PlanFeaturesFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->router
                ->generate(
                    'dzangocart_subscription_plan_features',
                    array('id' => $id)
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();

            $this->session->getFlashBag()->add(
                'plan.features',
                $this->translator->trans('plan.features.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit a Plan's prices.
     * @Template("DzangocartSubscriptionBundle:Plan:prices.html.twig")
     */
    public function pricesAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->form_factory->create(
            new PlanPricesFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->router
                ->generate(
                    'dzangocart_subscription_plan_prices',
                    array('id' => $id),
                    UrlGeneratorInterface::ABSOLUTE_PATH
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();
            $this->session->getFlashBag()->add(
                'plan.prices',
                $this->translator->trans('plan.prices.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * Lists all Plans.
     * @Template("DzangocartSubscriptionBundle:Plan:plans_tbody.html.twig")
     */
    public function changeRankAction(Request $request)
    {
        $plan_id = $request->query->get('plan_id');

        $plan = $this->getPlan($plan_id);
        
        $query = $this->getQuery();

        $new_rank = max(1, min($request->query->get('new_rank'), $query->count()));

        $plan->moveToRank($new_rank);
        $plan->save();

        $plans = $query->find();

        return array(
            'plans' => $plans
        );
    }

    protected function getQuery()
    {
        return PlanQuery::create()
            ->joinWithI18n($this->request_stack->getCurrentRequest()->getLocale())
            ->orderByRank();
    }

    protected function getPlan($id)
    {
        $plan = $this->getQuery()
            ->findPk($id);

        if (!$plan) {
            throw new NotFoundHttpException('Plan not found');
        }

        return $plan;
    }
}
