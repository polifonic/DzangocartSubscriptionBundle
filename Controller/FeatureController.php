<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/feature")
 * @Template
 */
class FeatureController extends Controller
{
    /**
     * Lists all Plans Feature.
     *
     * @Route("/", name="features")
     * @Template("DzangocartSubscriptionBundle:Feature:index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * Finds and displays a Plan Feature entity.
     *
     * @Route("/show/{id}", name="feature_show")
     * @Template("DzangocartSubscriptionBundle:Feature:show.html.twig")
     */
    public function showAction($id)
    {
        
    }

    /**
     * Displays a form to edit an existing Plan Feature entity.
     * 
     * @Route("/edit/{id}", name="dzangocart_subscription_plan_feature_edit")
     * @Template("DzangocartSubscriptionBundle:Feature:edit.html.twig")
     */
    public function editAction($id)
    {
        return array();
    }

    /**
     * Deletes a Plan Feature entity.
     *
     */
    public function deleteAction($id)
    {
        
    }
    
    /**
     * Create a Plan Feature entity.
     * 
     * @Route("/create", name="dzangocart_subscription_plan_feature_create")
     * @Template("DzangocartSubscriptionBundle:Feature:create.html.twig")
     */
    public function createAction()
    {
        return array();
    }
}

