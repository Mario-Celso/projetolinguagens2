<?php


namespace App\Controller\System;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Service\User\Core\UpdatePasswordUser;
use DI\Annotation\Inject;

class UserPasswordController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var UpdatePasswordUser
     */
    protected UpdatePasswordUser $updatePasswordUser;

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
        $user = $this->userRepository->findOneBy(['hash' => $session->get('hash')]);
        return $this->view->render($response, "/system/user/update.twig", [
            'message' => $this->messages,
            'user' => $user,
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
                $user = $this->updatePasswordUser->update($post, $user);
                return $this->success($request, $response, '/system/user/update/' . $user->getHash(), 'Sua senha foi atualizada com sucesso.');

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/system/user/update/' . $user->getHash(), 'Houve problemas ao tentar atualizar a senha. ' . $exception->getMessage());
            }
        }
    }
}