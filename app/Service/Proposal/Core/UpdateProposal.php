<?php


namespace App\Service\Proposal\Core;

use App\Component\File;
use App\Entity\Proposal\Proposal;
use App\Repository\Proposal\ProposalDocumentRepository;
use App\Repository\SafeCompany\SafeCompanyRepository;
use App\Service\Proposal\ProposalDocumentService;
use Doctrine\ORM\EntityManager;

/**
 * Class UpdateProposal
 * @package App\Service\Proposal\Core
 */
class UpdateProposal
{

    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var ProposalDocumentService
     */
    private ProposalDocumentService $proposalDocumentService;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    private SafeCompanyRepository $safeCompanyRepository;

    /**
     * @param $data
     * @param Proposal $proposal
     * @return Proposal
     * @throws \Exception
     */
    public function update($data, Proposal $proposal): Proposal
    {
        $proposal->setObservation($data['observation']);
        $proposal->setChassis($data['chassis']);
        $proposal->setPlate($data['plate']);
        $proposal->setPolicyNumber($data['policy_number']);
        $proposal->setVehicleState($data['vehicle_state'] == 'zero' ?
            Proposal::STATE_NEW_VEHICLE : Proposal::STATE_USED_VEHICLE);
        $proposal->setVehicleState($data['vehicle_state'] == 0 ?
            Proposal::STATE_USED_VEHICLE : Proposal::STATE_NEW_VEHICLE);
        $proposal->setDueDateStart($data['proposal_due_start']);
        $proposal->setDueDateEnd($data['proposal_due_end']);
        $proposal->setStatus($data['status']);
        if ($data['status'] == Proposal::PROPOSAL_STATUS_DELETED) {
            $proposal->setDeletedAt(new \DateTime());
        }
        $proposal->setUpdatedAt(new \DateTime());

        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash'=> $data['safe_company']]);
        $proposal->setSafeCompany($safeCompany);

        $this->proposalDocumentService->updateDocument($data);

        try {
            $this->entityManager->persist($proposal);
            $this->entityManager->flush();

            return $proposal;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }


}