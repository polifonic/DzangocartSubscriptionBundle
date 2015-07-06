<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SignupController
{
    protected $class;
    protected $query_class;
    protected $session;
    protected $router;
    protected $templating;
    protected $target_on_success;
    protected $form_factory;
    protected $trial_days;

    public function __construct(FormFactory $form_factory, Session $session, Router $router, EngineInterface $templating, $class, $target_on_success, $trial_days)
    {
        $this->class = $class;
        $this->query_class = $class.'Query';
        $this->session = $session;
        $this->router = $router;
        $this->templating = $templating;
        $this->target_on_success = $target_on_success;
        $this->form_factory = $form_factory;
        $this->trial_days = $trial_days;
    }

    /**
     * @Template()
     */
    public function signupAction(Request $request)
    {
        $subscription = $this->session->get('dzangocart_subscription_entity');

        if (!$subscription) {
            $subscription = new $this->class();
        }

        $form = $this->form_factory->create(
            'dzangocart_subscription_signup',
            $subscription,
            array(
                'action' => $this->router->generate('dzangocart_subscription_signup'),
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($subscription->getPlanId() == 'trial') {
                $trial_plan = Plan::getDefaultPlanForTrial();
                $subscription->setPlanId($trial_plan->getId());

                $now = date('Y-m-d', time());
                $expiry_date = date('Y-m-d', strtotime($now.' + '.$this->trial_days.' days'));

                $subscription->setExpiresAt($expiry_date);

                $this->session->set('dzangocart_subscription_entity', $subscription);

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(
                        array(
                            'redirectUrl' => $this->router->generate($this->target_on_success),
                        )
                    );
                }

                return new RedirectResponse($this->router->generate($this->target_on_success));
            }

            $this->session->set('dzangocart_subscription_entity', $subscription);

            // TODO redirect to paid registration page
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
