<?php


namespace App\Controller\System;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\SafeCompany\SafeCompany;
use App\Repository\Company\CompanyRepository;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\SafeCompany\Core\RegisterSafeCompany;
use App\Service\SafeCompany\Core\UpdateSafeCompany;
use DI\Annotation\Inject;

class SafeCompanyController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    protected SafeCompanyRepository $safeCompanyRepository;

    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @Inject
     * @var RegisterSafeCompany
     */
    protected RegisterSafeCompany  $registerSafeCompany;

    /**
     * @Inject
     * @var UpdateSafeCompany
     */
    protected UpdateSafeCompany $updateSafeCompany;

    /**
     * @param $request
     * @param $response
     * @return mixed
     */

    public function index($request, $response)
    {
        $session = $this->session;
        $companyId = $session->get('company');
        $company = $this->companyRepository->findOneBy(['id' => $companyId]);
        $safeCompanies = $this->safeCompanyRepository->findBy(['status'=> SafeCompany::SAFE_COMPANY_STATUS_ACTIVE, 'company' => $company->getId()], ['insurer' => 'ASC']);
        return $this->view->render($response, "/system/safe-company/index.twig", [
            'message' => $this->messages,
            'safeCompanies' => $safeCompanies,
        ]);
    }

    public function search($request, $response)
    {
        // TODO: Implement search() method.
    }

    public function form($request, $response)
    {
        return $this->view->render($response, "/system/safe-company/form.twig", [
            'message' => $this->messages
        ]);
    }

    public function get($request, $response, $hash_safe_company = null)
    {
        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash' => $hash_safe_company]);

        return $this->view->render($response, "/system/safe-company/view.twig", [
            'message' => $this->messages,
            'safeCompany' => $safeCompany,
        ]);
    }

    public function post($request, $response)
    {
        $post = $request->getParsedBody();
        $session = $this->session;
        $companyId = $session->get('company');
        $company = $this->companyRepository->findOneBy(['id' => $companyId]);
        try {
            $safeCompany = $this->registerSafeCompany->register($post, $company);
            return $this->success($request, $response, "/system/safe_company", 'Cia de seguro salva com sucesso');
        } catch (\Exception $e) {
            return $this->success($request, $response, "/system/safe-company/register", 'Problemas ao tentar salvar cia de seguro ' . $e->getMessage());
        }
    }

    public function put($request, $response, $hash_safe_company = null)
    {
        $post = $request->getParsedBody();
        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash' => $hash_safe_company]);

        try {
            $safeCompany = $this->updateSafeCompany->update($post, $safeCompany);
            return $this->success($request, $response, "/system/safe_company", 'Cia de seguro salva com sucesso');
        } catch (\Exception $e) {
            return $this->success($request, $response, "/system/safe-company/update/", 'Problemas ao tentar salvar cia de seguro ' . $e->getMessage());
        }
    }
}