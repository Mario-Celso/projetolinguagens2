<?php


namespace App\Controller\Administrator;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\User\User;
use App\Repository\Company\CompanyRepository;
use App\Repository\User\UserRepository;
use App\Service\User\Core\RegisterUser;
use App\Service\User\Core\UpdateUser;
use DI\Annotation\Inject;

class UserController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var UpdateUser
     */
    protected UpdateUser $updateUser;

    /**
     * @Inject
     * @var RegisterUser
     */
    protected RegisterUser $registerUser;

    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @param $request
     * @param $response
     */

    public function index($request, $response)
    {
        $users= $this->userRepository->findBy(['status'=>User::USER_STATUS_ACTIVE]);
        return $this->view->render($response, "/administrator/user/index.twig", [
            'message' => $this->messages,
            'users' => $users,
        ]);
    }

    public function search($request, $response)
    {
        // TODO: Implement search() method.
    }

    public function form($request, $response)
    {
        return $this->view->render($response, "/administrator/user/form.twig", [
            'message' => $this->messages,
        ]);

    }

    public function get($request, $response, $hash_user = null)
    {

        $user = $this->userRepository->findOneBy(['hash' => $hash_user]);
        return $this->view->render($response, "/administrator/user/view.twig", [
            'message' => $this->messages,
            'user' => $user,
        ]);
    }

    public function post($request, $response)
    {
        if ($request->getMethod() == 'POST') {

            $post = $request->getParsedBody();

            $session = $this->session;
            $company = $this->companyRepository->findOneBy(['hash'=> $session->get('company_hash')]);

            try {
                $user = $this->registerUser->register($post, $company);
                return $this->success($request, $response, '/manager/companies/update/' . $session->get('company_hash'), 'Usuário cadastrado com sucesso.');

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/manager/users/form', 'Houve problemas ao tentar cadastrar um novo usuário. ' . $exception->getMessage());
            }

        }
    }

    public function put($request, $response, $hash_user = null)
    {
        if ($request->getMethod() == 'POST') {

            $post = $request->getParsedBody();
            $user = $this->userRepository->findOneBy(['hash'=>$hash_user]);


            try {
                $user = $this->updateUser->update($post, $user);
                return $this->success($request, $response, '/manager/companies/update/' . $user->getCompany()->getHash() , 'Usuário atualizado com sucesso.');

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/manager/users/update/' . $user->getHash(), 'Houve problemas ao tentar atualizar o usuário. ' . $exception->getMessage());
            }
        }
    }
}