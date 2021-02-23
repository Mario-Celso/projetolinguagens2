<?php


namespace App\Controller\System;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Repository\Company\CompanyRepository;
use App\Repository\User\UserRepository;
use App\Service\User\Core\UpdateUser;
use App\Service\User\UserService;
use DI\Annotation\Inject;


/**
 * Class UserController
 * @package App\Controller\System
 */
class UserController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @Inject
     * @var UpdateUser
     */
    protected UpdateUser $updateUser;


    /**
     * @param $request
     * @param $response
     */


    public function index($request, $response)
    {
        // TODO: Implement index() method.
    }

    public function search($request, $response)
    {
        // TODO: Implement search() method.
    }

    public function form($request, $response)
    {
        // TODO: Implement form() method.
    }

    public function get($request, $response, $user = null)
    {
        $session = $this->session;
        $company = $this->companyRepository->findOneBy(['id' => $session->get('company')]);
        $user = $this->userRepository->findOneBy(['hash' => $session->get('hash')]);
        return $this->view->render($response, "/system/user/view.twig", [
            'message' => $this->messages,
            'user' => $user,
            'company' => $company,
        ]);
    }

    public function post($request, $response)
    {
        // TODO: Implement post() method.
    }

    public function put($request, $response, $user = null)
    {

        if ($request->getMethod() == 'POST') {
            $session = $this->session;
            $user = $this->userRepository->findOneBy(['hash' => $session->get('hash')]);
            $post = $request->getParsedBody();
            try {
                $user = $this->updateUser->update($post, $user);
                return $this->success($request, $response, '/system/user/view/' . $user->getHash(), 'Perfil atualizado com sucesso.');

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/system/user/view/' . $user->getHash(), 'Houve problemas ao tentar atualizar o perfil. ' . $exception->getMessage());
            }
        }
    }
}