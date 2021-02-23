<?php

namespace App\Controller;

use App\Repository\Company\CompanyRepository;
use App\Repository\Customer\CustomerDocumentsRepository;
use App\Repository\Customer\CustomerRepository;
use App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository;
use App\Repository\InsuranceClaim\InsuranceClaimRepository;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository;
use App\Repository\Policy\PolicyDocumentRepository;
use App\Repository\Policy\PolicyRepository;
use App\Repository\Proposal\ProposalDocumentRepository;
use App\Repository\Proposal\ProposalRepository;
use App\Service\Claim\ClaimService;
use App\Service\Claim\ClaimThirdService;
use App\Service\Customer\CustomerService;
use App\Service\Policy\PolicyService;
use App\Service\Proposal\ProposalService;
use App\Repository\User\UserRepository;
use DI\Annotation\Inject;
use Plasticbrain\FlashMessages\FlashMessages;
use SlimSession\Helper as Session;

class Controller
{

	/**
     * @Inject("view")
	 */
	public $view;

    /**
     * @Inject
     * @var Session
     */
    public $session;

    /**
     * @Inject
     * @var FlashMessages
     */
    public $messages;

    /* -- CORE SERVICE -- */

    /**
     * @Inject
     * @var CustomerService
     */
    public CustomerService $customerService;

    /**
     * @Inject
     * @var ProposalService
     */
    public ProposalService $proposalService;

    /**
     * @Inject
     * @var PolicyService
     */
    public PolicyService $policyService;

    /**
     * @Inject
     * @var ClaimService
     */
    public ClaimService $claimService;

    /**
     * @Inject
     * @var ClaimThirdService
     */
    public ClaimThirdService $claimThirdService;


    /* -- CORE REPOSITORY  -- */

    /**
     * @Inject
     * @var CustomerRepository
     */
    public CustomerRepository $customerRepository;

    /**
     * @Inject
     * @var CustomerDocumentsRepository
     */
    public CustomerDocumentsRepository $customerDocumentsRepository;

    /**
     * @Inject
     * @var InsuranceClaimRepository
     */
    public InsuranceClaimRepository $claimRepository;

    /**
     * @Inject
     * @var InsuranceClaimDocumentRepository
     */
    public InsuranceClaimDocumentRepository $claimDocumentRepository;

    /**
     * @Inject
     * @var InsuranceClaimThirdPartyDocumentRepository
     */
    public InsuranceClaimThirdPartyDocumentRepository $claimThirdDocumentRepository;

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;

    /**
     * @Inject
     * @var ProposalRepository
     */
    public ProposalRepository $proposalRepository;

    /**
     * @Inject
     * @var ProposalDocumentRepository
     */
    public ProposalDocumentRepository $proposalDocumentRepository;

    /**
     * @Inject
     * @var PolicyRepository
     */
    public PolicyRepository $policyRepository;

    /**
     * @Inject
     * @var PolicyDocumentRepository
     */
    public PolicyDocumentRepository $policyDocumentRepository;


    /**
	 * @param $request
	 * @param $response
	 * @param string $url
	 * @param string $message
	 * @return mixed
	 */
	public function success($request, $response, $url = '/', $message = '')
	{
		$this->messages->success($message);
		return $response
			->withHeader('Location', $url)
			->withStatus(302);
	}

	/**
	 * @param $request
	 * @param $response
	 * @param string $url
	 * @param string $message
	 * @return mixed
	 */
	public function error($request, $response, $url = '/', $message = '')
	{
		$this->messages->error($message);
		return $response
			->withHeader('Location', $url)
			->withStatus(302);
	}

	/**
	 * @param $url
	 * @param $response
	 * @return mixed
	 */
	protected function redirect($url, $response)
	{
		return $response->withRedirect($url);
	}

}
