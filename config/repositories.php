<?php

use function DI\factory;

return [
    \App\Repository\Customer\CustomerRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\Customer');
    }),

    \App\Repository\Customer\CustomerAddressRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\CustomerAddress');
    }),

    \App\Repository\Customer\CustomerBankRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\CustomerBank');
    }),

    \App\Repository\Customer\CustomerContactRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\CustomerContact');
    }),

    \App\Repository\Customer\CustomerCardRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\CustomerCard');
    }),


    \App\Repository\Customer\CustomerDocumentsRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Customer\CustomerDocuments');
    }),

    \App\Repository\Proposal\ProposalRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Proposal\Proposal');
    }),

    \App\Repository\Policy\PolicyRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Policy\Policy');
    }),

    \App\Repository\Proposal\ProposalDocumentRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Proposal\ProposalDocument');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaim');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimObservationRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaimObservation');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimThirdPartyRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaimThirdParty');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimThirdPartyDocumentRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaimThirdPartyDocument');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimThirdPartyObservationRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaimThirdPartyObservation');
    }),

    \App\Repository\User\UserRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\User\User');
    }),

    \App\Repository\InsuranceClaim\InsuranceClaimDocumentRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\InsuranceClaim\InsuranceClaimDocument');
    }),

    \App\Repository\Policy\PolicyDocumentRepository::class => DI\factory(function (\Doctrine\ORM\EntityManager $entityManager) {
        return $entityManager->getRepository('App\Entity\Policy\PolicyDocument');
    }),

    \App\Repository\Company\CompanyRepository::class => DI\factory(function(\Doctrine\ORM\EntityManager $entityManager){
        return $entityManager->getRepository('App\Entity\Company\Company');
    }),

    \App\Repository\Administrator\AdministratorRepository::class => DI\factory(function(\Doctrine\ORM\EntityManager $entityManager){
        return $entityManager->getRepository('App\Entity\Administrator\Administrator');
    }),

    \App\Repository\SafeCompany\SafeCompanyRepository::class => DI\factory(function(\Doctrine\ORM\EntityManager $entityManager){
        return $entityManager->getRepository('App\Entity\SafeCompany\SafeCompany');
    }),

];
