<?php

namespace App\Controller;

use App\Service\User\UserService;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Controller
{

    /**
     * @Inject
     * @var UserService
     */
    public $userService;

    /**
     * SITE
     *
     * @param $request
     * @param $response
     * @param null $user
     * @return mixed
     */
    public function index($request, $response, $user = null)
    {
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    /**
     * TELA DE LOGIN DO USUARIO
     *
     * @param $request
     * @param $response
     * @return mixed
     * @throws \Exception
     */
    public function login($request, $response)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();

            $user_login = $this->userService->login($post['email'], $post['password']);
            if (is_object($user_login)) {

                $session = $this->session;
                $session->set('authenticate', true);
                $session->set('email', $user_login->getEmail());
                $session->set('name', $user_login->getName());
                $session->set('hash', $user_login->getHash());
                $session->set('company',$user_login->getCompany()->getId());
                return $this->success($request, $response, '/system', 'Acesso autorizado com sucesso');

            } else {

                return $this->error($request, $response, '/login', 'Problemas ao tentar autenticação');

            }
        }

        return $this->view->render($response, "/index/login.twig", [
            'message' => $this->messages,
        ]);
    }

    /**
     * LOGICA DE LOGOUT DO USUARIO
     *
     * @param $request
     * @param $response
     * @return mixed
     */
    public function logout($request, $response)
    {
        $this->session->clear();
        $this->success($request, $response, '/login', 'Sessão finalizada com sucesso');
        return $response->withRedirect('/login');
    }

}
