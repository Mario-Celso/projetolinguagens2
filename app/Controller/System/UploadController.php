<?php

namespace App\Controller\System;

use App\Controller\Controller;
use App\Entity\Customer\Customer;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\Policy\Policy;
use App\Entity\Proposal\Proposal;
use App\Service\Claim\Core\RegisterClaimDocument;
use App\Service\Claim\Core\RegisterClaimThirdDocument;
use App\Service\Customer\Core\RegisterCustomerDocument;
use App\Service\Policy\Core\RegisterPolicyDocument;
use App\Service\Proposal\Core\RegisterProposalDocument;

/**
 * Class UploadController
 * @package App\Controller
 */
class UploadController extends Controller
{
    /**
     * @Inject
     * @var RegisterCustomerDocument
     */
    private RegisterCustomerDocument $registerCustomerDocument;

    /**
     * @Inject
     * @var RegisterProposalDocument
     */
    private RegisterProposalDocument $registerProposalDocument;

    /**
     * @Inject
     * @var RegisterPolicyDocument
     */
    private RegisterPolicyDocument $registerPolicyDocument;

    /**
     * @Inject
     * @var RegisterClaimDocument
     */
    private RegisterClaimDocument $registerClaimDocument;

    /**
     * @Inject
     * @var RegisterClaimThirdDocument
     */
    private RegisterClaimThirdDocument $registerThirdClaimDocument;

    /**
     * @param $request
     * @param $response
     * @param $hash
     * @throws \Exception
     */
    public function customer($request, $response, $hash)
    {
        $customer = $this->customerService->hash($hash);
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->upload($customer, $post); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate

    }

    /**
     * @param $request
     * @param $response
     * @param $hash
     * @throws \Exception
     */
    public function proposal($request, $response, $hash)
    {
        $proposal = $this->proposalService->hash($hash);
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->upload($proposal, $post); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate

    }

    /**
     * @param $request
     * @param $response
     * @param $hash
     * @throws \Exception
     */
    public function policy($request, $response, $hash)
    {
        $policy = $this->policyService->hash($hash);
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->upload($policy, $post); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate

    }

    /**
     * @param $request
     * @param $response
     * @param $hash
     * @throws \Exception
     */
    public function claim($request, $response, $hash)
    {
        $claim = $this->claimService->hash($hash);
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->upload($claim, $post); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate

    }

    /**
     * @param $request
     * @param $response
     * @param $hash
     * @throws \Exception
     */
    public function claimThird($request, $response, $hash)
    {
        $third = $this->claimThirdService->hash($hash);
        $post = $request->getParsedBody();
        $post['upload'] = $_FILES;
        header('Content-Type: application/json'); // set json response headers
        $outData = $this->upload($third, $post); // a function to upload the bootstrap-fileinput files
        echo json_encode($outData); // return json data
        exit(); // terminate

    }

    /**
     * @param $entity
     * @param $data
     * @return array|string[]
     * @throws \Exception
     */
    public function upload($entity, $data)
    {
        $registerDocument = $this->serviceProvider($entity);
        $doc = $registerDocument->register($data['upload']['file_data'], $entity, $data['upload']['file_data']['name']);

        return [
            [
                'initialPreview' => [
                    $doc['path']
                ],
                'initialPreviewConfig' => [
                    [
                        // check previewTypes (set it to 'other' if you want no content preview)
                        'caption' => $doc['document']->getDocument(), // caption
                        'key' =>$entity->getHash(),       // keys for deleting/reorganizing preview
                        'fileId' => $entity->getHash(),    // file identifier
                        'size' => $data['upload']['file_data']['size'],    // file size
                        'zoomData' => $doc['path'], // separate larger zoom data
                    ]
                ],
                'initialPreviewThumbTags' => $doc['document']->getId(),
                'initialPreviewAsData' => true,
                'overwriteInitial' => false,
                'append' => true
            ]
        ];
    }

    public function serviceProvider($entity)
    {
        if ($entity instanceof Customer)
            return $this->registerCustomerDocument;

        if ($entity instanceof Proposal)
            return $this->registerProposalDocument;

        if ($entity instanceof Policy)
            return $this->registerPolicyDocument;

        if ($entity instanceof InsuranceClaim)
            return $this->registerClaimDocument;

        if ($entity instanceof InsuranceClaimThirdParty)
            return $this->registerThirdClaimDocument;

        return false;

    }

}
