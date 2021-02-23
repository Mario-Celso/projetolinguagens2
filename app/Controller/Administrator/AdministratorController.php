<?php


namespace App\Controller\Administrator;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Entity\Administrator\Administrator;
use App\Repository\Administrator\AdministratorRepository;
use App\Service\Administrator\Core\RegisterAdministrator;
use App\Service\Administrator\Core\UpdateAdministrator;
use DI\Annotation\Inject;

class AdministratorController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var RegisterAdministrator
     */
    protected RegisterAdministrator $registerAdministrator;

    /**
     * @Inject
     * @var AdministratorRepository
     */
    protected AdministratorRepository $administratorRepository;

    /**
     * @Inject
     * @var UpdateAdministrator
     */
    protected UpdateAdministrator $updateAdministrator;

    /**
     * @param $request
     * @param $response
     */


    public function index($request, $response)
    {
        $administrators = $this->administratorRepository->findBy(['status' => Administrator::ADMINISTRATOR_STATUS_ACTIVE]);
        return $this->view->render($response, "/administrator/administrator/index.twig", [
            'message' => $this->messages,
            'administrators' => $administrators,
        ]);
    }

    public function search($request, $response)
    {
        // TODO: Implement search() method.
    }

    public function form($request, $response)
    {
        return $this->view->render($response, "/administrator/administrator/form.twig", [
            'message' => $this->messages,
        ]);
    }

    public function get($request, $response, $hash_adm = null)
    {

        $adm = $this->administratorRepository->findOneBy(['hash' => $hash_adm]);


        return $this->view->render($response, "/administrator/administrator/update.twig", [
            'message' => $this->messages,
            'adm' => $adm,
        ]);
    }

    public function post($request, $response)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();

            try {
                if ($adm = $this->registerAdministrator->register($post)) {
                    return $this->success($request, $response, '/manager/administrator/index', 'Administrador cadastrado com sucesso.');
                }

            } catch (\Exception $exception) {
                return $this->error($request, $response, '/manager/administrator/form', 'Problemas ao tentar cadastrar um novo administrador. ' . $exception->getMessage());
            }
        }
    }

    public function put($request, $response, $hash_adm = null)
    {
        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();
            $adm = $this->administratorRepository->findOneBy(['hash' => $hash_adm]);


            try {
                if ($adm = $this->updateAdministrator->update($post, $adm)) {
                    return $this->success($request, $response, '/manager/administrator/index', 'Dados atualizado com sucesso.');
                }

            } catch (\Exception $exception) {
                return $this->error($request, $response, '/manager/administrator/index', 'Problemas ao tentar atualizar os dados. ' . $exception->getMessage());
            }
        }
    }
}