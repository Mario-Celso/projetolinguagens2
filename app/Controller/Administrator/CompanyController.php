<?php


namespace App\Controller\Administrator;


use App\Controller\Controller;
use App\Entity\Company\Company;
use App\Entity\User\User;
use App\Repository\Company\CompanyRepository;
use App\Repository\User\UserRepository;
use App\Service\Company\Core\RegisterCompany;
use App\Service\Company\Core\UpdateCompany;
use DI\Annotation\Inject;

class CompanyController extends Controller
{
    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @Inject
     * @var UpdateCompany
     */
    protected UpdateCompany $updateCompany;

    /**
     * @Inject
     * @var RegisterCompany
     */
    protected RegisterCompany $registerCompany;


    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function index($request, $response)
    {
        $companies = $this->companyRepository->findBy(['status'=>Company::COMPANY_STATUS_ACTIVE]);

        return $this->view->render($response, "/administrator/companies/index.twig", [
            'message' => $this->messages,
            'companies' => $companies,
        ]);
    }

    public function record($request, $response)
    {
        return $this->view->render($response, "/administrator/companies/record.twig", [
            'message' => $this->messages,
        ]);
    }

    public function post($request, $response, $hash_company = null)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();

            try {
                if ($company = $this->registerCompany->register($post)) {
                    return $this->success($request, $response, '/manager/companies/all', 'Empresa cadastrado com sucesso.');
                }

            } catch (\Exception $exception) {
                return $this->error($request, $response, '/manager/companies/record', 'Problemas ao tentar cadastrar uma empresa nova. ' . $exception->getMessage());
            }
        }
    }

    public function get($request, $response, $hash_company = null)
    {
        $company = $this->companyRepository->findOneBy(['hash'=>$hash_company]);
        $users = $this->userRepository->findBy(['company'=>$company, 'status'=> User::USER_STATUS_ACTIVE]);
        $session = $this->session;
        $session->set('company_hash', $hash_company);

        return $this->view->render($response, "/administrator/companies/update.twig", [
            'message' => $this->messages,
            'company' => $company,
            'users' => $users,
        ]);

    }

    public function update($request, $response, $hash_company = null)
    {
        if ($request->getMethod() == 'POST') {
            $company = $this->companyRepository->findOneBy(['hash' => $hash_company]);
            $post = $request->getParsedBody();

            try {
                $this->updateCompany->update($post,$company);
                if($company->getStatus() == Company::COMPANY_STATUS_INACTIVE){
                    $message= 'Empresa excluído com sucesso.';
                }else{
                    $message = 'Empresa atualizado com sucesso. ';
                }
                if(is_object($this)){
                    return $this->success($request, $response, '/manager/companies/all',
                        $message);
                }

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/manager/companies/update/' . $hash_company,
                    'Problemas ao tentar atualizar esta empresa.');
            }
        }
    }

    public function delete($request, $response)
    {

    }
}