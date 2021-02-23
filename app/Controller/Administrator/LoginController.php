<?php


namespace App\Controller\Administrator;


use App\Controller\Controller;
use App\Service\Administrator\AdministratorService;
use DI\Annotation\Inject;

class LoginController extends Controller
{
    /**
     * @Inject
     * @var AdministratorService
     */
    protected AdministratorService $administratorService;

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function in($request, $response)
    {
        return $this->view->render($response, "/administrator/login/login.twig", [
            'message' => $this->messages,
        ]);
    }

    public function out($request, $response)
    {
        return $this->view->render($response, "/administrator/login/login.twig", [
            'message' => $this->messages,
        ]);

    }

    public function login($request, $response)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();

            $user_login = $this->administratorService->login($post['user'], $post['password']);


            if (is_object($user_login)) {
                $session = $this->session;
                $session->set('hash', $user_login->getHash());
                return $this->success($request, $response, '/manager/index', 'Logado com sucesso.');
            }else{
                return $this->error($request, $response, '/manager/in', 'Problemas de autenticação. User e/ou senha estão incorretos. ');
            }
        }
    }
}