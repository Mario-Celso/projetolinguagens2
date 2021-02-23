<?php


namespace Test\Entity;


use App\Entity\Administrator\Administrator;
use App\Entity\Company\Company;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerDocuments;
use App\Entity\InsuranceClaim\InsuranceClaim;
use App\Entity\InsuranceClaim\InsuranceClaimThirdParty;
use App\Entity\Policy\Policy;
use App\Entity\Proposal\Proposal;
use App\Entity\SafeCompany\SafeCompany;
use App\Entity\User\User;
use Cassandra\Date;


class ScenarioInitialRegistersTest extends DbMaster
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->data = [
            'administrators' => [
                0 => [
                    'name' => 'adm01',
                    'email' => 'adm01@email.com',
                    'user' => 'ADM',
                    'password' => '123',
                    'password_confirmation' => '123'
                ],
                1 => [
                    'name' => 'adm02',
                    'email' => 'adm02@email.com',
                    'user' => 'ADM2',
                    'password' => '123456',
                    'status' => Administrator::ADMINISTRATOR_STATUS_INACTIVE
                ]
            ],
            'companies' => [
                0 => [
                    'name' => 'Caputo',
                    'document' => '123.456.678',
                ],
                1 => [
                    'name' => 'Empresa02',
                    'document' => '098.765.432',
                    'status' => Company::COMPANY_STATUS_INACTIVE,
                ]

            ],
            'users' => [
                0 => [
                    'name' => 'Henrique',
                    'email' => 'henrique@email.com',
                    'password' => '123',
                    'password_confirmation' => '123'


                ],
                1 => [
                    'name' => 'Eduarda',
                    'status' => User::USER_STATUS_INACTIVE,
                    'email' => 'eduarda@email.com',
                ],

            ],
            'customers' => [
                0 => [
                    'birthday' => '12/12/2001',
                    'document' => '123.456.789-00',
                    'first_name' => 'Daiara',
                    'last_name' => 'Silva',
                    'civil_status' => Customer::CIVIL_STATE_SOLTEIRO,
                    'profession' => 'Engenheira',
                    'gender' => "F",
                    'observation' => "nenhum",
                    'document_rg' => "2323223-3",
                    'document_rg_origin' => 'S-SP',
                    'document_rg_date' => "22/12/2020",
                    'emission_cnh_date' => "23/12/2020",
                    'document_cnh' => '111',
                    'cnh_due_date' => '24/12/2020',
                    'first_cnh_date' => '21/12/2020',
                    'address' => [
                        0 => [
                            'complement' => '1111',
                            'district' => 'Centro',
                            'address' => 'Rua Ferreiro Dom',
                            'number' => '45',
                            'state' => 'SP',
                            'city' => 'São José dos Campos',
                            'zip' => '09310-435',
                            'address_type' => 1,
                            'preferential' => 1,
                        ]
                    ],
                    'contacts' => [
                        0 => [
                            'contact' => '12 1234.12341',
                            'preferential' => 1,
                            'type' => 2,
                            'building_type' => 1
                        ]
                    ],

                    'banks' => [
                        0 => [
                            'observation' => 'nenhuma',
                            'account' => '12',
                            'agency' => '12345',
                            'bank' => '288'
                        ]
                    ],
                    'cards' => [
                        0 => [
                            'number' => '2222 2222 2222 2222',
                            'due_date' => '12/12/2020',
                            'title_name' => 'cartão 01'
                        ]
                    ],
                ],
                1 => [
                    'birthday' => '12/12/2001',
                    'document' => '123.456.789-00',
                    'first_name' => 'Lucas',
                    'last_name' => 'Silva',
                    'civil_status' => Customer::CIVIL_STATE_SOLTEIRO,
                    'profession' => 'Engenheira',
                    'gender' => "F",
                    'observation' => "nenhum",
                    'document_rg' => "2323223-3",
                    'document_rg_origin' => 'S-SP',
                    'document_rg_date' => "22/12/2020",
                    'emission_cnh_date' => "23/12/2020",
                    'document_cnh' => '111',
                    'cnh_due_date' => '24/12/2020',
                    'first_cnh_date' => '21/12/2020',
                    'address' => [
                        0 => [
                            'complement' => '1111',
                            'district' => 'Centro',
                            'address' => 'Rua Ferreiro Dom',
                            'number' => '45',
                            'state' => 'SP',
                            'city' => 'São José dos Campos',
                            'zip' => '09310-435',
                            'address_type' => 1,
                            'preferential' => 1,
                        ]
                    ],
                    'contacts' => [
                        0 => [
                            'contact' => '12 1234.8888',
                            'preferential' => 1,
                            'type' => 2,
                            'building_type' => 1
                        ]
                    ],

                    'banks' => [
                        0 => [
                            'observation' => 'nenhuma',
                            'account' => '12',
                            'agency' => '12345',
                            'bank' => '288'
                        ]
                    ],
                    'cards' => [
                        0 => [
                            'number' => '2222 2222 2222 2222',
                            'due_date' => '12/12/2020',
                            'title_name' => 'cartão 01'
                        ]
                    ],
                ],
            ],
            'safe_company' => [
                0 => [
                    'insurer' => 'teste 05'
                ],

                1 => [
                    'insurer' => 'teste 10',
                    'status' => SafeCompany::SAFE_COMPANY_STATUS_INACTIVE
                ]
            ],

            'proposal' => [
                0 => [
                    'observation' => 'observação',
                    'chassis' => '111',
                    'plate' => '222',
                    'policy_number' => '0',
                    'vehicle_state' => 1,
                    'proposal_due' => "12/12/2020",
                    'status' => Proposal::PROPOSAL_STATUS_CREATED,
                    'safe_company' => [
                        'insurer' => "teste 01",

                    ]
                ],
                1 => [
                    'observation' => 'observação 02',
                    'policy_number' => '02',
                    'vehicle_state' => 1,
                    'proposal_due' => "12/12/2020",
                    'status' => Proposal::PROPOSAL_STATUS_APPROVED,
                    'safe_company' => [
                        'insurer' => "teste 02",

                    ]
                ]
            ],
            'policy' => [
                0 => [
                    'plate' => '123123',
                    'chassis' => '4444',
                    'policy_number' => '5555',
                    'observations' => 'observações 123',
                    'policy_date' => '12/12/2020',
                    'branch' => 1,
                    'safe_company' => [
                        'insurer' => "teste 01",

                    ]

                ],
                1 => [
                    'observations' => 'observações 12345',
                    'safe_company' => [
                        'insurer' => "teste 02",

                    ]
                ]
            ],
            'claim' => [
                0 => [
                    'status' => 0,
                    'obstitle' => [
                        0 => "titulo a observação"
                    ],
                    'date' => [
                        0 => "13/12/2002"
                    ],
                    'observation' => [
                        0 => "obervação do sinistro"
                    ]
                ],
                1 => [
                    'status' => 1,
                    'obstitle' => [
                        0 => "titulo da observação"
                    ],
                    'date' => [
                        0 => "13/12/2002"
                    ],
                    'observation' => [
                        0 => "obervação do sinistro"
                    ]
                ]

            ],
            'third' => [
                0 => [
                    'name' => 'Diego',
                    'document' => '123.456.789-00',
                    'observation' => 'observação do sinistro terceiro'
                ]
            ]


        ];
    }

    /**
     * Test cadastro empresa
     * @return Company
     */
    public function testRegisterCompany(): Company
    {
        $register = self::$container->get(\App\Service\Company\Core\RegisterCompany::class);
        $company = $register->register($this->data['companies'][0]);

        self::assertInstanceOf(Company::class, $company);
        self::assertEquals('Caputo', $company->getName());
        self::assertEquals('123.456.678', $company->getDocument());
        self::assertEquals(Company::COMPANY_STATUS_ACTIVE, $company->getStatus());
        self::assertEquals(1, $company->getId());

        return $company;

    }

    /**
     *Test update empresa
     * @depends testCreateCompany
     * @param Company $company
     * @return Company
     */

    public function testUpdateCompany(Company $company)
    {
        $update = self::$container->get(\App\Service\Company\Core\UpdateCompany::class);
        $company = $update->update($this->data['companies'][1], $company);

        self::assertInstanceOf(Company::class, $company);
        self::assertEquals('Empresa02', $company->getName());
        self::assertNotEquals('Caputo', $company->getName());
        self::assertEquals('098.765.432', $company->getDocument());
        self::assertEquals(Company::COMPANY_STATUS_INACTIVE, $company->getStatus());
        return $company;
    }

    /**
     * Test cadastrar usuário
     * @depends testRegisterCompany
     * @param Company $company
     * @return User
     */
    public function testRegisterUser(Company $company): User
    {
        $register = self::$container->get(\App\Service\User\Core\RegisterUser::class);
        $user = $register->register($this->data['users'][0], $company);

        self::assertEquals('Henrique', $user->getName());
        self::assertEquals($company, $user->getCompany());
        return $user;

    }

    /**
     * Test update senha do usuário
     * @depends testRegisterUser
     * @param User $user
     * @return User
     */
    public function testUpdateUser($user)
    {
        $update = self::$container->get(\App\Service\User\Core\UpdateUser::class);
        $user = $update->update($this->data['users'][1], $user);

        self::assertEquals('eduarda@email.com', $user->getEmail());
        self::assertEquals(User::USER_STATUS_INACTIVE, $user->getStatus());

        return $user;
    }

    /**
     * Test cadastrar cliente
     * @depends testRegisterCompany
     * @param Company $company
     * @return Company
     */
    public function testRegisterCustomer(Company $company)
    {
        $register = self::$container->get(\App\Service\Customer\Core\RegisterCustomer::class);
        $customer = $register->register($this->data['customers'][0], $company);

        self::assertInstanceOf(Customer::class, $customer);
        self::assertEquals('123.456.789-00', $customer->getDocument());

        return $customer;
    }

    /**
     * Test cadastrar documentos
     * @depends testRegisterCustomer
     * @param Customer $customer
     * @return Customer
     */
    public function testUpdateCustomer(Customer $customer)
    {
        $update = self::$container->get(\App\Service\Customer\Core\UpdateCustomer::class);
        $customer = $update->update($this->data['customers'][1], $customer);

        self::assertEquals('Lucas', $customer->getFirstName());
        self::assertEquals('12 1234.8888', $customer->getContacts()->first()->getContact());
        return $customer;
    }

    /**
     * Test cadastrar cia seguro
     * @return SafeCompany
     */
    public function testRegisterSafeCompany()
    {
        $register = self::$container->get(\App\Service\SafeCompany\Core\RegisterSafeCompany::class);
        $safeCompany = $register->register($this->data['safe_company'][0]);

        self::assertInstanceOf(SafeCompany::class, $safeCompany);
        self::assertEquals("teste 05", $safeCompany->getInsurer());

        return $safeCompany;
    }

    /**
     * Test update cia seguro
     * @depends testRegisterSafeCompany
     * @param SafeCompany $safeCompany
     * @return SafeCompany
     */
    public function testUpdateSafeCompany(SafeCompany $safeCompany)
    {
        $update = self::$container->get(\App\Service\SafeCompany\Core\UpdateSafeCompany::class);
        $safeCompany = $update->update($this->data['safe_company'][1], $safeCompany);

        self::assertNotEquals('teste 05', $safeCompany->getInsurer());

        return $safeCompany;
    }

    /**
     * Test cadastrar proposta
     * @depends testRegisterCustomer
     * @param Customer $customer
     * @return Proposal
     */
    public function testRegisterProposal(Customer $customer)
    {
        $register = self::$container->get(\App\Service\Proposal\Core\RegisterProposal::class);
        $proposal = $register->register($this->data['proposal'][0], $customer);

        self::assertInstanceOf(Proposal::class, $proposal);
        self::assertEquals('111', $proposal->getChassis());

        return $proposal;
    }

    /**
     * Test update proposta
     * @depends testRegisterProposal
     * @param Proposal $proposal
     * @return Proposal
     */
    public function testUpdateProposal(Proposal $proposal)
    {
        $update = self::$container->get(\App\Service\Proposal\Core\UpdateProposal::class);
        $proposal = $update->update($this->data['proposal'][1], $proposal);

        self::assertEquals('111222', $proposal->getChassis());
        self::assertEquals('observação 02', $proposal->getObservation());

        return $proposal;

    }

    /**
     * Test cadastrar apólice
     * @depends testRegisterProposal
     * @param Proposal $proposal
     * @return Policy
     */
    public function testRegisterPolicy(Proposal $proposal)
    {
        $register = self::$container->get(\App\Service\Policy\Core\RegisterPolicy::class);
        $policy = $register->register($this->data['policy'][0], $proposal);

        self::assertEquals('123123', $policy->getPlate());

        return $policy;
    }

    /**
     * Test update apólice
     * @depends testRegisterPolicy
     * @param Policy $policy
     * @return Policy
     */
    public function testUpdatePolicy(Policy $policy)
    {
        $update = self::$container->get(\App\Service\Policy\Core\UpdatePolicy::class);
        $policy = $update->update($this->data['policy'][1], $policy);

        self::assertEquals('observações 12345', $policy->getObservation());

        return $policy;
    }

    /**
     * Test register sinistro
     * @depends  testRegisterPolicy
     * @param Policy $policy
     * @return InsuranceClaim
     */
    public function testRegisterClaim(Policy $policy)
    {
        $register = self::$container->get(\App\Service\Claim\Core\RegisterClaim::class);
        $claim = $register->register($this->data['claim'][0], $policy);

        self::assertInstanceOf(InsuranceClaim::class, $claim);
        self::assertEquals(0, $claim->getStatus());
        self::assertEquals("obervação do sinistro", $claim->getObservations()->first()->getObservation());

        return $claim;
    }

    /**
     * Test cadastrar sinistro terceiro
     * @depends testRegisterClaim
     * @param InsuranceClaim $claim
     * @return InsuranceClaimThirdParty
     */
    public function testRegisterClaimThird(InsuranceClaim $claim)
    {
        $register = self::$container->get(\App\Service\Claim\Core\RegisterClaimThird::class);
        $third = $register->register($this->data['third'][0], $claim);

        self::assertInstanceOf(InsuranceClaimThirdParty::class, $third);
        self::assertEquals('Diego', $third->getName());
        self::assertNull($third->getDeletedAt());

        return $third;
    }

    /**
     * Test delete sinistro terceiro
     * @depends testRegisterClaimThird
     * @param InsuranceClaimThirdParty $third
     */
    public function testDeleteClaimThird(InsuranceClaimThirdParty $third)
    {
        $delete = self::$container->get(\App\Service\Claim\Core\DeleteClaimThird::class);
        $third = $delete->delete($third);

        self::assertNotNull($third->getDeletedAt());
    }

    /**
     * Teste update sinistro
     * @depends testRegisterClaim
     * @param InsuranceClaim $claim
     * @return InsuranceClaim
     */
    public function testUpdateClaim(InsuranceClaim $claim)
    {
        $update = self::$container->get(\App\Service\Claim\Core\UpdateClaim::class);

        $claim = $update->update($this->data['claim'][1], $claim);

        self::assertEquals(1, $claim->getStatus());

        return $claim;
    }













































    /**
     * Test cadastrar administrador
     * @return Administrator
     */
    public function testRegisterAdmin(): Administrator
    {
        $create = self::$container->get(\App\Service\Administrator\Core\RegisterAdministrator::class);
        $admin = $create->register($this->data['administrators'][0]);

        self::assertInstanceOf(Administrator::class, $admin);
        self::assertEquals('ADM', $admin->getUser());
        return $admin;
    }

    /**
     * Test update administrador
     * @depends testRegisterAdmin
     * @param Administrator $admin
     * @return Administrator
     */
    public function testUpdateAdmin(Administrator $admin)
    {
        $update = self::$container->get(\App\Service\Administrator\Core\UpdateAdministrator::class);
        $admin = $update->update($this->data['administrators'][1], $admin);

        self::assertInstanceOf(Administrator::class, $admin);
        self::assertNotEquals('123456', $admin->getPassword());
        self::assertEquals('ADM2', $admin->getUser());
        self::assertEquals(Administrator::ADMINISTRATOR_STATUS_INACTIVE, $admin->getStatus());

    }


}