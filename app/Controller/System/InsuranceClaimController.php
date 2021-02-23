<?php

namespace App\Controller\System;

use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Repository\InsuranceClaim\InsuranceClaimRepository;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use App\Service\Claim\ClaimService;
use App\Service\Claim\Core\RegisterClaim;
use App\Service\Claim\Core\UpdateClaim;
use DI\Annotation\Inject;

/**
 * Class InsuranceClaimController
 * @package App\Controller\System
 */
class InsuranceClaimController extends Controller implements InterfaceController
{

    /**
     * @Inject
     * @var ClaimService
     */
    public ClaimService $claimService;

    /**
     * @Inject
     * @var RegisterClaim
     */
    public RegisterClaim $registerClaim;

    /**
     * @Inject
     * @var UpdateClaim
     */
    public UpdateClaim $updateClaim;

    /**
     * @Inject
     * @var InsuranceClaimRepository
     */
    public InsuranceClaimRepository $claimRepository;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    public InsuranceClaimThirdPartyRepository $thirdRepository;

    /**
     * @param $request
     * @param $response
     */
    public function index($request, $response)
    {
        return $this->view->render($response, "/system/claim/index.twig", [
            'message' => $this->messages
        ]);
    }

    public function search($request, $response)
    {

        $payload = [];
        $claims = $this->claimRepository->search($this->session->get('company'));


        foreach ($claims as $claim) {

            $payload['data'][] = [
                "DT_RowId" => $claim['hash'],
                'Cliente' => $claim['first_name'] . ' ' . $claim['last_name'],
                'CPF/CNPJ' => $claim['document'],
                'Aberto_em' => $claim['created_at']->format('d/m/Y'),
                'Apólice' => $claim['policy_number'],
                'Status' => InsuranceClaim::showStatus(intval($claim['status']))
            ];
        }

        $payload = json_encode($payload);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function form($request, $response)
    {
        $session = $this->session;

        $policies = $this->policyRepository->findBy(['deleted_at' => null,'company'=>$session->get('company')]);

        return $this->view->render($response, "/system/claim/form.twig", [
            'message' => $this->messages,
            'policies' => $policies
        ]);
    }

    public function get($request, $response, $hash_claim = null)
    {
        $claim = $this->claimService->hash($hash_claim);

        $path = '/upload/claim/';
        $pathThird = '/upload/claim/' . $claim->getHash() . '/third/' ;
        $documents = $this->claimDocumentRepository->findBy(['insurance_claim' => $claim->getId(), 'deleted_at' => null]);
        $claimThird = $this->thirdRepository->findBy(['insurance_claim' => $claim->getId(), 'deleted_at' => null ]);
        $documentsThird = [];
       // if (is_object($claimThird = $claim->getThirdParty())) {
       //    $documentsThird = $this->claimThirdDocumentRepository->findBy(['third_party' => $claimThird->getId(), 'deleted_at' => null]);
       // }

        $data = $this->claimService->documentPreview($documents, $claim, $path);
        $dataThird = $this->claimService->documentPreview($documentsThird, $claim, $pathThird);

        return $this->view->render($response, "/system/claim/view.twig", [
            'message' => $this->messages,
            'claim' => $claim,
            //'claimThird' => $claimThird,
            'preview' => json_encode($data['preview']),
            'previewConfig' => json_encode($data['previewConfig']),
            'initialPreviewThumbTags' => json_encode($data['initialPreviewThumbTags']),
//            'thirdPreview' => json_encode($dataThird['preview']),
//            'thirdPreviewConfig' => json_encode($dataThird['previewConfig']),
//           'thirdInitialPreviewThumbTags' => json_encode($dataThird['initialPreviewThumbTags']),
            'claimThird' => $claimThird,
        ]);
    }

    public function post($request, $response)
    {
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;



        $policy = $this->policyService->hash($post['hash_policy']);
        try {
            $claim = $this->registerClaim->register($post, $policy);
            return $this->success($request, $response, "/system/insurance_claim/view/" . $claim->getHash(), 'Sinistro salvo com sucesso');
        } catch (\Exception $e) {
            return $this->error($request, $response, "/system/insurance_claim/register", 'Problemas ao tentar salvar sinistro ' . $e->getMessage());
        }

    }

    public function put($request, $response, $hash_claim = null)
    {
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;

        $claim = $this->claimService->hash($hash_claim);



        try {
            $claim = $this->updateClaim->update($post, $claim);
            return $this->success($request, $response, "/system/insurance_claim/view/" . $claim->getHash(), 'Sinistro salvo com sucesso');
        } catch (\Exception $e) {
            return $this->error($request, $response, "/system/insurance_claim/view/" . $claim->getHash(), 'Problemas ao tentar salvar sinistro ' . $e->getMessage());
        }
    }


}
