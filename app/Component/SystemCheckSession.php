<?php

namespace App\Component;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Plasticbrain\FlashMessages\FlashMessages;
use Slim\Psr7\Response;
use SlimSession\Helper as Session;
use App\Service\User\UserService;

class SystemCheckSession
{

	/**
	 * @Inject
	 * @var Session
	 */
	public $session;

	/**
	 * @Inject
	 * @var UserService
	 */
	protected $userService;

	/**
	 * @Inject
	 * @var FlashMessages
	 */
	public $messages;

	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();

		$session = $this->session;
		$user = $this->userService->user($session->get('email'));

		if ($session->get('authenticate') == false) {

			$this->messages->error("Autenticação obrigatória para acessar o painel");
			return $response
				->withHeader('Location', '/')
				->withStatus(302);

		}

		if ($user->getHash() != $session->get('hash')) {

			$this->messages->error("Autenticação obrigatória para acessar o painel");
			return $response
				->withHeader('Location', '/')
				->withStatus(302);

		}
		$response = $handler->handle($request);
		return $response;
	}

}
