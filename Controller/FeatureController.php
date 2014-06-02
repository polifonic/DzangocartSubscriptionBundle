<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFeatureDefinitionFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinition;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinitionQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/feature")
 * @Template
 */
class FeatureController extends Controller
{
    /**
     * Lists all Plans Feature.
     *
     * @Route("/", name="dzangocart_subscription_features")
     * @Template("DzangocartSubscriptionBundle:Feature:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || 'json' == $request->getRequestFormat()) {

            $query = $this->getQuery();

            $total_count = $query
                ->count();

            $filtered_count = $total_count;

            $features = $query
                //->datatablesSort($request->query, $this->getDataTablesSortColumns())
                ->setLimit($request->query->get('iDisplayLength', 10))
                ->setOffset($request->query->get('iDisplayStart'))
                ->find();

            $data = array(
                'sEcho' => $request->query->get('sEcho'),
                'iStart' => 0,
                'iTotalRecords' => $total_count,
                'iTotalDisplayRecords' => $filtered_count,
                'features' => $features
            );

            $view = $this->renderView('DzangocartSubscriptionBundle:Feature:index.json.twig', $data);

            return new Response($view, 200, array('Content-Type' => 'application/json'));
        }
        
        return array();
    }
    
    /**
     * Finds and displays a Plan Feature entity.
     *
     * @Route("/show/{id}", name="dzangocart_subscription_feature_show")
     * @Template("DzangocartSubscriptionBundle:Feature:show.html.twig")
     */
    public function showAction($id)
    {
        
    }

    /**
     * Displays a form to edit an existing Plan Feature entity.
     * 
     * @Route("/edit/{id}", name="dzangocart_subscription_feature_edit")
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
     * @Route("/create", name="dzangocart_subscription_feature_create")
     * @Template("DzangocartSubscriptionBundle:Feature:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new PlanFeatureDefinitionFormType(), $feature_discription = new PlanFeatureDefinition());
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $feature_discription->save();
            return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
        }
        
        return array(
            'form' => $form->createView()
        );
    }
    
    protected function getQuery()
    {
        return PlanFeatureDefinitionQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale());
    }

    protected function getDatatablesSortColumns()
    {
        return array(
            1 => 'plan_feature_definition.name',
            2 => 'plan_feature_definition.description',
            3 => 'plan_feature_defination.rank'
        );
    }
}

