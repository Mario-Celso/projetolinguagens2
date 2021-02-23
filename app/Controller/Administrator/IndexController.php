<?php


namespace App\Controller\Administrator;


use App\Controller\Controller;
use App\Entity\Administrator\Administrator;
use App\Entity\Company\Company;
use App\Entity\User\User;
use App\Repository\Administrator\AdministratorRepository;
use App\Repository\Company\CompanyRepository;
use App\Repository\User\UserRepository;
use DI\Annotation\Inject;

class IndexController extends Controller
{
    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;


    /**
     * @Inject
     * @var AdministratorRepository
     */
    protected AdministratorRepository $administratorRepository;

    /**
     * @param $request
     * @param $response
     * @return mixed
     */

    public function index($request, $response)
    {
        $companies = $this->companyRepository->findBy(['status'=> Company::COMPANY_STATUS_ACTIVE]);
        $users = $this->userRepository->findBy(['status'=> User::USER_STATUS_ACTIVE]);
        $administartors = $this->administratorRepository->findBy(['status'=>Administrator::ADMINISTRATOR_STATUS_ACTIVE]);
        return $this->view->render($response, "/administrator/index/index.twig", [
            'message' => $this->messages,
            'companies' => count($companies),
            'users' => count($users),
            'administrators' => count($administartors),
        ]);
    }
}