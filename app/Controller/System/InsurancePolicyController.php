<?php

namespace App\Controller\System;

use App\Component\CompanyHelper;
use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\SafeCompany\SafeCompany;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\Policy\Core\RegisterPolicy;
use App\Service\Policy\Core\UpdatePolicy;
use DI\Annotation\Inject;

/**
 * Class InsurancePolicyController
 * @package App\Controller\System
 */
class InsurancePolicyController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var RegisterPolicy
     */
    private RegisterPolicy $registerPolicy;

    /**
     * @Inject
     * @var UpdatePolicy
     */
    private UpdatePolicy $updatePolicy;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    private SafeCompanyRepository $safeCompanyRepository;


    /**
     * @param $request
     * @param $response
     * @return mixed
     * @throws \Exception
     */

    public function index($request, $response)
    {
        $query = $request->getUri()->getQuery();

        $params = $request->getQueryParams();

        if (!empty($params)){
            list($dI, $mI, $YI) = explode('/', @$params['start']);
            if (checkdate($mI, $dI, $YI)) {
                $drI = new \DateTime($YI . '-' . $mI . '-' . $dI);
                $params['start'] = $drI->format('Y-m-d');
            }

            list($dI, $mI, $YI) = explode('/', @$params['end']);
            if (checkdate($mI, $dI, $YI)) {
                $drI = new \Datetime($YI . '-' . $mI . '-' . $dI);
                $params['end'] = $drI->format('Y-m-d');
            }
        }

        return $this->view->render($response, "/system/policy/index.twig", [
            'message' => $this->messages,
            'query' => $query,
            'start' => @$params['start'],
            'end' => @$params['end'],
        ]);
    }

    public function search($request, $response)
    {
        $payload = [];

        $query = $request->getQueryParams();

        if (!empty($query['start']) && !empty($query['end'])){
            list($dI, $mI, $YI) = explode('/', $query['start']);
            if (checkdate($mI, $dI, $YI)) {
                $drI = new \DateTime($YI . '-' . $mI . '-' . $dI);
                $query['start'] = $drI->format('Y-m-d');
            }

            list($dI, $mI, $YI) = explode('/', $query['end']);
            if (checkdate($mI, $dI, $YI)) {
                $drI = new \Datetime($YI . '-' . $mI . '-' . $dI);
                $query['end'] = $drI->format('Y-m-d');
            }

            $policies = $this->policyRepository->query($query);

        } else {
            $session = $this->session;
            $policies = $this->policyRepository->findBy(['deleted_at' => null,'company'=>$session->get('company')]);
        }

        foreach ($policies as $policy) {
            $payload['data'][] = [
                "DT_RowId" => $policy->getHash(),
                "Id" => $policy->getId(),
                'Cliente' => $policy->getCustomer()->getFirstName() . ' ' . $policy->getCustomer()->getLastName(),
                'CPF/CNPJ' => $policy->getCustomer()->getDocument(),
                'Apólice' => $policy->getPolicyNumber(),
                'Seguradora' => $policy->getSafeCompany()->getInsurer(),
                'Aberto_em' => $policy->getCreatedAt()->format('d/m/Y'),
//                'Vencimento' => $policy->getDateEnd()->format('d/m/Y'),
            ];
        }

        $payload = json_encode($payload);

        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function form($request, $response, $hash_customer = null)
    {
        $proposals = $this->proposalRepository->searchForApprovedProposals($this->session->get('company'));
        $safeCompanies = $this->safeCompanyRepository->findBy(['status' => SafeCompany::SAFE_COMPANY_STATUS_ACTIVE], ['insurer' => 'ASC']);

        return $this->view->render($response, "/system/policy/form.twig", [
            'message' => $this->messages,
            'proposals' => $proposals,
            'hash_customer' => $hash_customer,
            'safeCompanies' => $safeCompanies,
        ]);
    }

    public function get($request, $response, $hash = null)
    {

        $this->view->render($response, "", [
            'customer' => $this->policyRepository->findOneBy(['hash' => $hash]),
        ]);
    }

    public function post($request, $response)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();
            $post['upload'] = $_FILES;

            $proposal = $this->proposalRepository->findOneBy(['hash' => $post['proposal_hash']]);
            try {
                if ($module = $this->registerPolicy->register($post, $proposal)) {
                    return $this->success($request, $response, '/system/proposal/insurance_policy/view/'. $module->getHash(), 'Apólice cadastrada com sucesso.');
                }

            } catch (\Exception $exception) {
                $this->messages->warning($exception->getMessage());
                print_r($exception->getMessage());
                return $this->error($request, $response, '/system/proposal/insurance_policy/register', 'Problemas ao tentar cadastrar apólice.');
            }
        }
    }

    /**
     * chamada do servico de edicacao
     *
     * @param $request
     * @param $response
     * @param null $hash_policy
     * @return mixed
     */
    public function put($request, $response, $hash_policy = null)
    {
        $policy = $this->policyService->hash($hash_policy);

        if($request->getMethod() == 'POST'){
            $post = $request->getParsedBody();
            $post['upload'] = $_FILES;

            try {
                if ($module = $this->updatePolicy->update($post, $policy)) {
                    return $this->success($request, $response, '/system/proposal/insurance_policy/view/'. $policy->getHash(), 'Apólice atualizada com sucesso.');
                }

            } catch (\Exception $exception) {
                $this->messages->warning($exception->getMessage());
                return $this->error($request, $response, '/system/proposal/insurance_policy/view/'. $policy->getHash() , 'Problemas ao tentar atualizar apólice.');
            }
        }

        $path = '/upload/policy/';
        $documents = $this->policyDocumentRepository->findBy(['policies' => $policy->getId(), 'deleted_at' => null]);

        $data = $this->policyService->documentPreview($documents, $policy, $path);
        $safeCompanies = $this->safeCompanyRepository->findBy(['status' => SafeCompany::SAFE_COMPANY_STATUS_ACTIVE]);

        return $this->view->render($response, "/system/policy/view.twig", [
            'message' => $this->messages,
            'policy' => $policy,
            'preview' => json_encode($data['preview']),
            'previewConfig' => json_encode($data['previewConfig']),
            'initialPreviewThumbTags' => json_encode($data['initialPreviewThumbTags']),
            'safeCompanies' => $safeCompanies,
        ]);
    }
}
