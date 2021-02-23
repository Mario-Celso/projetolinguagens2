<?php


namespace App\Controller\System;


use App\Controller\Controller;
use App\Controller\InterfaceController;
use App\Repository\InsuranceClaim\InsuranceClaimRepository;
use App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository;
use App\Service\Claim\Core\DeleteClaimThird;
use App\Service\Claim\Core\RegisterClaimThird;
use DI\Annotation\Inject;

class ClaimThirdController extends Controller implements InterfaceController
{
    /**
     * @Inject
     * @var InsuranceClaimThirdPartyRepository
     */
    protected InsuranceClaimThirdPartyRepository $thirdRepository;

    /**
     * @Inject
     * @var RegisterClaimThird
     */
    protected RegisterClaimThird $registerClaimThird;

    /**
     * @Inject
     * @var DeleteClaimThird
     */
    protected DeleteClaimThird $deleteClaimThird;


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

    public function form($request, $response, $hash_claim = null)
    {
        $claim = $this->claimRepository->findOneBy(['hash'=>$hash_claim]);
        $session = $this->session;
        $session->set('hash_claim', $claim->getHash());
        return $this->view->render($response, "/system/claim-third/form.twig", [
            'message' => $this->messages,
        ]);
    }

    public function get($request, $response, $hash_third = null)
    {
        $third = $this->thirdRepository->findOneBy(['hash' => $hash_third]);

        $pathThird = "/upload/claim/{$third->getInsuranceClaim()->getHash()}/third/";
        $documentsThird = $this->claimThirdDocumentRepository->findBy(['third_party' => $third->getId(), 'deleted_at' => null]);
        $dataThird = $this->claimService->documentPreview($documentsThird, $third, $pathThird);
        return $this->view->render($response, "/system/claim-third/view.twig", [
            'message' => $this->messages,
            'third' => $third,
            'Preview' => json_encode($dataThird['preview']),
            'PreviewConfig' => json_encode($dataThird['previewConfig']),
            'InitialPreviewThumbTags' => json_encode($dataThird['initialPreviewThumbTags']),
        ]);
    }

    public function post($request, $response)
    {
        $post = $request->getParsedBody();
        $session = $this->session;
        $claim = $this->claimRepository->findOneBy(['hash'=> $session->get('hash_claim')]);

        try {
            $third = $this->registerClaimThird->register($post, $claim);
            return $this->success($request, $response, "/system/insurance_claim/view/" . $claim->getHash(), 'Sinistro Terceiro salvo com sucesso');
        } catch (\Exception $e) {
            return $this->error($request, $response, "/system/claim_third/register", 'Problemas ao tentar salvar o sinistro terceiro ' . $e->getMessage());
        }
    }

    public function put($request, $response, $hash_third = null)
    {
        $post = $request->getParsedBody();
        $third = $this->thirdRepository->findOneBy(['hash' => $hash_third]);
        $claim = $third->getInsuranceClaim();
        $post['upload'] = $_FILES;

        try {
            $third = $this->registerClaimThird->register($post,$claim,$third);
            return $this->success($request, $response, "/system/insurance_claim/view/" . $claim->getHash(), 'Sinistro terceiro atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->error($request, $response, "/system/claim_third/view/" . $third->getHash(), 'Problemas ao tentar atualizar o sinistro terceiro ' . $e->getMessage());
        }
    }


    public function delete($request, $response, $hash_third = null)
    {

        $third = $this->thirdRepository->findOneBy(['hash' => $hash_third]);
        $claim = $third->getInsuranceClaim();


        try {
            $third = $this->deleteClaimThird->delete($third);
            return $this->success($request,$response, "/system/insurance_claim/view/" . $claim->getHash(), 'Sinistro terceiro deletado com sucesso');
        } catch (\Exception $e) {
            return $this->error($request,$response, "/system/insurance_claim/view/" . $claim->getHash(), 'Problemas ao tentar deletar o sinistro terceiro ' . $e->getMessage());
        }
    }
}