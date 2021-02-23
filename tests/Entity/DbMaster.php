<?php


namespace Test\Entity;


use App\Entity\Administrator\Administrator;
use App\Entity\Company\Company;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerAddress;
use App\Entity\Customer\CustomerBank;
use App\Entity\Customer\CustomerCard;
use App\Entity\Customer\CustomerContact;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimObservation;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\Policy\Policy;
use App\Entity\Proposal\Proposal;
use App\Entity\SafeCompany\SafeCompany;
use App\Entity\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

class DbMaster extends TestCase
{
    public $data;

    public static $classes;

    public static $entityManager;

    public static $container;

    public static function setUpBeforeClass(): void
    {
        self::$container = require(__DIR__ . '/../config.php');
        self::$entityManager = self::$container->get(EntityManager::class);

        $tool = new SchemaTool(self::$entityManager);
        self::$classes = [
            self::$entityManager->getClassMetadata(Company::class),
            self::$entityManager->getClassMetadata(User::class),
            self::$entityManager->getClassMetadata(Customer::class),
            self::$entityManager->getClassMetadata(CustomerAddress::class),
            self::$entityManager->getClassMetadata(CustomerBank::class),
            self::$entityManager->getClassMetadata(CustomerCard::class),
            self::$entityManager->getClassMetadata(CustomerContact::class),
            self::$entityManager->getClassMetadata(InsuranceClaim::class),
            self::$entityManager->getClassMetadata(InsuranceClaimObservation::class),
            self::$entityManager->getClassMetadata(InsuranceClaimThirdParty::class),
            self::$entityManager->getClassMetadata(Policy::class),
            self::$entityManager->getClassMetadata(Proposal::class),
            self::$entityManager->getClassMetadata(Administrator::class),
            self::$entityManager->getClassMetadata(SafeCompany::class),

        ];
        $tool->createSchema(self::$classes);
    }

    public function tearDownBeforeClass(): void
    {
        $tool = new SchemaTool($this->entityManager);
        $tool->dropSchema($this->classes);
    }

}