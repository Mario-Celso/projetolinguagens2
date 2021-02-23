<?php

namespace App\Controller\System;

use App\Controller\Controller;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Controller
{

    /**
     * DASHBOARD
     *
     * @param $request
     * @param $response
     * @return mixed
     */
    public function index($request, $response)
    {
        $session =$this->session;
        $companyId =$session->get('company');


        $customer = $this->customerRepository->findBy(['company'=>$companyId]);
        $policies = $this->policyRepository->findBy(['company'=>$companyId]);
        $claims = $this->claimRepository->findBy(['company'=>$companyId]);
        $proposals = $this->proposalRepository->findBy(['company'=>$companyId]);

        return $this->view->render($response, "/system/index/index.twig", [
            'customer' => count($customer),
            'policies' => count($policies),
            'claims' => count($claims),
            'proposals' => count($proposals),
            'message' => $this->messages,
        ]);
    }

}
