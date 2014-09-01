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
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PlanController
{
    protected $templating;
    protected $request_stack;
    protected $form_factory;
    protected $router;
    protected $session;
    protected $translator;

    public function __construct(FormFactory $form_factory, RequestStack $request_stack, Router $router, Session $session, EngineInterface $templating, Translator $translator)
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
            new PlanFormType(),
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

        $plan->disable();

        $plan->save();

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
    public function setTrialAction(Request $request, $id)
    {
        $default_plan = $this->getPlan($id);

        if (!$default_plan->isDisabled()) {
            $plans = PlanQuery::create()
                ->filterByTrial(true)
                ->find();

            foreach ($plans as $plan) {
                $plan->setTrial(false);
                $plan->save();
            }

            $default_plan->setTrial(true);

            $default_plan->save();
        } else {
            // TODO display flash error message
        }

        return new RedirectResponse($this->router
            ->generate(
                'dzangocart_subscription_plans'
            )
        );
    }

    /**
     * remove plan as default plan fortrial period
     * @Template()
     */
    public function unsetTrialAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->setTrial(false);

        $plan->save();

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
