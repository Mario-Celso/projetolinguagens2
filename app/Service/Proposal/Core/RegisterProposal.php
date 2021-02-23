<?php


namespace App\Service\Proposal\Core;

use App\Component\File;
use App\Component\Hash;
use App\Entity\Customer\Customer;
use App\Entity\Proposal\Proposal;
use App\Repository\Proposal\ProposalRepository;
use App\Repository\SafeCompany\SafeCompanyRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class RegisterProposal
 * @package App\Service\Proposal\Core
 */
class RegisterProposal
{
    /**
     * @Inject
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @Inject
     * @var ProposalRepository
     */
    private ProposalRepository $proposalRepository;

    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    protected SafeCompanyRepository $safeCompanyRepository;

    /**
     * @param $data
     * @param Customer $customer
     * @return Proposal
     * @throws \Exception
     */
    public function register($data, Customer $customer): Proposal
    {
        $proposal = new Proposal();

        $proposal->setHash(Hash::get($this->proposalRepository));
        $proposal->setObservation($data['observation']);
        $proposal->setChassis($data['chassis']);
        $proposal->setPlate($data['plate']);
        $proposal->setPolicyNumber($data['policy_number']);
        $proposal->setVehicleState($data['vehicle_state'] == 0 ?
            Proposal::STATE_USED_VEHICLE : Proposal::STATE_NEW_VEHICLE);
        $proposal->setDueDateStart($data['proposal_due_start']);
        $proposal->setDueDateEnd($data['proposal_due_end']);
        $proposal->setStatus($data['status']);

        $safeCompany = $this->safeCompanyRepository->findOneBy(['hash'=> $data['safe_company']]);
        $proposal->setSafeCompany($safeCompany);

        $company = $customer->getCompany();
        $proposal->setCompany($company);

        $proposal->setCustomer($customer);
        $customer->addProposal($proposal);



        try {
            $this->entityManager->persist($proposal);
            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return $proposal;

        } catch
        (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

}