<?php

namespace App\Controller\System;

use App\Component\CompanyHelper;
use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Repository\Company\CompanyRepository;
use App\Repository\Customer\CustomerAddressRepository;
use App\Repository\Customer\CustomerBankRepository;
use App\Repository\Customer\CustomerCardRepository;
use App\Repository\Customer\CustomerContactRepository;
use App\Repository\User\UserRepository;
use App\Service\Customer\Core\DeleteCustomerInfo;
use App\Service\Customer\Core\RegisterCustomer;
use App\Service\Customer\Core\UpdateCustomer;
use App\Service\User\UserService;
use DateTime;
use DI\Annotation\Inject;

/**
 * Class CustomerController
 * @package App\Controller
 */
class CustomerController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var RegisterCustomer
     */
    private RegisterCustomer $registerCustomer;

    /**
     * @Inject
     * @var UpdateCustomer
     */
    private UpdateCustomer $updateCustomer;

    /**
     * @Inject
     * @var DeleteCustomerInfo
     */
    private DeleteCustomerInfo $deleteCustomerInfo;

    /**
     * @Inject
     * @var CustomerBankRepository
     */
    protected CustomerBankRepository $bankRepository;

    /**
     * @Inject
     * @var CustomerAddressRepository
     */
    protected CustomerAddressRepository $addressRepository;

    /**
     * @Inject
     * @var CustomerContactRepository
     */
    protected CustomerContactRepository $contactRepository;

    /**
     * @Inject
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @Inject
     * @var CustomerCardRepository
     */
    protected CustomerCardRepository $cardRepository;


    /**
     * @param $request
     * @param $response
     * @return mixed
     */

    public function index($request, $response)
    {


        return $this->view->render($response, "/system/customer/index.twig", [
            'message' => $this->messages,
        ]);
    }

    public function search($request, $response)
    {
        $payload = [];
        $session = $this->session;
        $customers = $this->customerRepository->findBy(['deleted_at' => null, 'company' => $session->get('company')]);

        foreach ($customers as $customer) {
            $payload['data'][] = [
                "DT_RowId" => $customer->getHash(),
                'Nome' => $customer->getFirstName(),
                'Sobrenome' => $customer->getLastName(),
                'CPF/CNPJ' => $customer->getDocument()
            ];


        }

        $payload = json_encode($payload);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function get($request, $response, $hash = null)
    {
        $customer = $this->customerRepository->findOneBy(['hash' => $hash]);
        $banks = $this->bankRepository->findBy(['customer' => $customer->getId(), 'deleted_at' => null]);
        $address = $this->addressRepository->findBy(['customer' => $customer->getId(), 'deleted_at' => null]);
        $contacts = $this->contactRepository->findBy(['customer' => $customer->getId(), 'deleted_at' => null]);
        $cards = $this->cardRepository->findBy(['customer' => $customer->getId(), 'deleted_at' => NULL]);

        $path = '/upload/customer/';
        $documents = $this->customerDocumentsRepository->findBy(['customer' => $customer->getId(), 'deleted_at' => null]);

        $data = $this->proposalService->documentPreview($documents, $customer, $path);

        $helper = new CompanyHelper();
        return $this->view->render($response, "/system/customer/update.twig", [
            'message' => $this->messages,
            'customer' => $customer,
            'banks' => $banks,
            'address' => $address,
            'contacts' => $contacts,
            'cards' => $cards,
            'preview' => json_encode($data['preview']),
            'previewConfig' => json_encode($data['previewConfig']),
            'initialPreviewThumbTags' => json_encode($data['initialPreviewThumbTags']),
            'helper' => $helper
        ]);
    }

    /**
     * formulario em branco
     * submit post();
     *
     * @param $request
     * @param $response
     */
    public function form($request, $response)
    {
        return $this->view->render($response, "/system/customer/form.twig", [
            'message' => $this->messages,
        ]);
    }

    public function put($request, $response, $hash = null)
    {
        if ($request->getMethod() == 'POST') {
            $customer = $this->customerRepository->findOneBy(['hash' => $hash]);
            $post = $request->getParsedBody();

            try {
                if ($customer = $this->updateCustomer->update($post, $customer)) {
                    return $this->success($request, $response, '/system/customer/' . $hash, 'Cliente atualizado com sucesso.');
                }

            } catch (\Exception $exception) {
                $exception->getMessage();
                return $this->error($request, $response, '/system/customer/' . $hash, 'Problemas ao tentar atualizar cliente.' . $exception->getMessage());
            }
        }
    }

    //criação de customers
    public function post($request, $response)
    {


        if ($request->getMethod() == 'POST') {
            $post = $request->getParsedBody();

            $session = $this->session;
            $companyId = $session->get('company');
            $company = $this->companyRepository->findOneBy(['id' => $companyId]);


            try {
                if ($customer = $this->registerCustomer->register($post, $company)) {
                    return $this->success($request, $response, '/system/customer/' . $customer->getHash(), 'Cliente cadastrado com sucesso.');
                }

            } catch (\Exception $exception) {
                return $this->error($request, $response, '/system/customer/register', 'Problemas ao tentar cadastrar cliente. ' . $exception->getMessage());
            }
        }
    }

    public function details($request, $response, $hash = null)
    {
        $customer = $this->customerService->hash($hash);

        return $this->view->render($response, "/system/customer/details.twig", [
            'message' => $this->messages,
            'customer' => $customer,

        ]);
    }

    public function deleteBank($hash)
    {
        if ($bank = $this->deleteCustomerInfo->deleteInfo($hash, 'bank')) {
            die;
        }
    }

    public function deleteAddress($hash)
    {
        if ($address = $this->deleteCustomerInfo->deleteInfo($hash, 'address')) {
            die;
        }
    }

    public function deleteContact($hash)
    {
        if ($contact = $this->deleteCustomerInfo->deleteInfo($hash, 'contact')) {
            die;
        }
    }
    public function deleteCard($hash)
    {
        if ($card = $this->deleteCustomerInfo->deleteInfo($hash, 'card')) {
            die;
        }
    }

    public function deleteFile($request, $type)
    {
        $post = $request->getParsedBody();
        if ($doc = $this->deleteCustomerInfo->deleteInfo($post['key'], 'doc', $type)) {
            header('Content-Type: application/json'); // set json response headers
            echo json_encode(true); // return json data
            exit(); // terminate
        }
    }
}
