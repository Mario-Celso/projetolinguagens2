<?php

namespace App\Controller\System;

use App\Component\CompanyHelper;
use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\SafeCompany\SafeCompany;
use App\Repository\Proposal\ProposalRepository;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\Proposal\Core\RegisterProposal;
use App\Service\Proposal\Core\UpdateProposal;
use App\Service\Proposal\ProposalService;
use DI\Annotation\Inject;

/**
 * Class ProposalController
 * @package App\Controller\System
 */
class ProposalController extends Controller implements InterfaceController
{

    /**
     * @Inject
     * @var RegisterProposal
     */
    public RegisterProposal $registerProposal;

    /**
     * @Inject
     * @var ProposalService
     */
    public ProposalService $proposalService;

    /**
     * @Inject
     * @var ProposalRepository
     */
    public ProposalRepository $proposalRepository;

    /**
     * @Inject
     * @var UpdateProposal
     */
    public UpdateProposal $updateProposal;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    public SafeCompanyRepository $safeCompanyRepository;

    /**
     * @param $request
     * @param $response
     */
    public function index($request, $response)
    {

        return $this->view->render($response, "/system/proposal/index.twig", [
            'message' => $this->messages
        ]);
    }

    public function search($request, $response)
    {
        $payload = [];
        $session = $this->session;
        $proposals = $this->proposalRepository->findBy(['deleted_at' => null,'company'=>$session->get('company')]);

        foreach ($proposals as $proposal) {
            $payload['data'][] = [
                "DT_RowId" => $proposal->getHash(),
                "Id" => $proposal->getId(),
                'Cliente' => $proposal->getCustomer()->getFirstName() . ' ' . $proposal->getCustomer()->getLastName(),
                'CPF/CNPJ' => $proposal->getCustomer()->getDocument(),
                'Aberto_em' => $proposal->getCreatedAt()->format('d/m/Y'),
                'Placa' => $proposal->getPlate(),
                'Seguradora' => $proposal->getSafeCompany()->getInsurer()
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
        $session = $this->session;
        $users = $this->customerRepository->findBy(['deleted_at' => null,'company'=>$session->get('company')]);

        $safeCompanies = $this->safeCompanyRepository->findBy(['status' => SafeCompany::SAFE_COMPANY_STATUS_ACTIVE], ['insurer' => 'ASC']);

        return $this->view->render($response, "/system/proposal/form.twig", [
            'message' => $this->messages,
            'users' => $users,
            'hash_customer' => $hash_customer,
            'safeCompanies' => $safeCompanies,
        ]);
    }

    public function get($request, $response, $hash_proposal = null)
    {
        $proposal = $this->proposalService->hash($hash_proposal);
        $safeCompanies = $this->safeCompanyRepository->findBy(['status' => SafeCompany::SAFE_COMPANY_STATUS_ACTIVE]);

        $path = '/upload/proposal/';
        $documents = $this->proposalDocumentRepository->findBy(['proposal' => $proposal->getId(), 'deleted_at' => null]);

        $data = $this->proposalService->documentPreview($documents, $proposal, $path);

        return $this->view->render($response, "/system/proposal/view.twig", [
            'message' => $this->messages,
            'proposal' => $proposal,
            'preview' => json_encode($data['preview']),
            'previewConfig' => json_encode($data['previewConfig']),
            'initialPreviewThumbTags' => json_encode($data['initialPreviewThumbTags']),
            'safeCompanies' => $safeCompanies,
        ]);
        // TODO: Implement get() method.
    }

    public function post($request, $response)
    {
        $post = $request->getParsedBody();

        $customer = $this->customerService->hash($post['hash_customer']);

        try {
            $safeCompany = $this->safeCompanyRepository->findOneBy(['hash'=>$post['safe_company']]);
            $proposal = $this->registerProposal->register($post, $customer);
            return $this->success($request, $response, "/system/proposal/view/" . $proposal->getHash(), 'Proposta salva com sucesso');
        } catch (\Exception $e) {
            return $this->success($request, $response, "/system/proposal/register", 'Problemas ao tentar salvar proposta ' . $e->getMessage());
        }
    }

    public function put($request, $response, $hash_proposal = null)
    {
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;

        $proposal = $this->proposalService->hash($hash_proposal);

        try {
            $proposal = $this->updateProposal->update($post, $proposal);
            return $this->success($request, $response, "/system/proposal/view/" . $proposal->getHash(), 'Proposta salva com sucesso');
        } catch (\Exception $e) {
            return $this->success($request, $response, "/system/proposal/view/" . $proposal->getHash(), 'Problemas ao tentar salvar proposta ' . $e->getMessage());
        }

    }

}
