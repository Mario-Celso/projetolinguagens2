<?php
$app->group('', function (\Slim\Routing\RouteCollectorProxy $group) {

    $group->map(['GET', 'POST'], '/', ['\App\Controller\IndexController', 'index'])->setName('index');
    $group->map(['GET', 'POST'], '/login', ['\App\Controller\IndexController', 'login'])->setName('system.login');
    $group->map(['GET', 'POST'], '/logout', ['\App\Controller\IndexController', 'logout'])->setName('system.logout');
    $group->map(['GET', 'POST'], '/password', ['\App\Controller\IndexController', 'password'])->setName('system.password');

    $group->group('/system', function (\Slim\Routing\RouteCollectorProxy $group) {

        $group->map(['GET', 'POST'], '', ['\App\Controller\System\IndexController', 'index'])->setName('dashboard');

        $group->group('/customer', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET'], '/v/search', ['\App\Controller\System\CustomerController', 'search'])->setName('customer.search');
            $group->map(['GET'], '/register', ['\App\Controller\System\CustomerController', 'form'])->setName('customer.form');

            $group->map(['GET'], '', ['\App\Controller\System\CustomerController', 'index'])->setName('customer.list');
            $group->map(['POST'], '/register', ['\App\Controller\System\CustomerController', 'post'])->setName('customer.post');
            $group->map(['GET'], '/{hash}', ['\App\Controller\System\CustomerController', 'get'])->setName('customer.get');
            $group->map(['POST'], '/{hash}', ['\App\Controller\System\CustomerController', 'put'])->setName('customer.put');
            $group->map(['GET'], '/details/{hash}', ['\App\Controller\System\CustomerController', 'details'])->setName('customer.details');
            $group->map(['DELETE'], '/bank/{hash}', ['\App\Controller\System\CustomerController', 'deleteBank'])->setName('bank.delete');
            $group->map(['DELETE'], '/address/{hash}', ['\App\Controller\System\CustomerController', 'deleteAddress'])->setName('address.delete');
            $group->map(['DELETE'], '/contact/{hash}', ['\App\Controller\System\CustomerController', 'deleteContact'])->setName('contact.delete');
            $group->map(['DELETE'], '/card/{hash}', ['\App\Controller\System\CustomerController', 'deleteCard'])->setName('card.delete');
            $group->map(['DELETE', 'POST'], '/file/{type}', ['\App\Controller\System\CustomerController', 'deleteFile'])->setName('file.delete');
        });

        $group->group('/proposal', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET'], '', ['\App\Controller\System\ProposalController', 'index'])->setName('proposal.list');
            $group->map(['GET'], '/v/search', ['\App\Controller\System\ProposalController', 'search'])->setName('proposal.search');
            $group->map(['GET'], '/view/{hash_proposal}', ['\App\Controller\System\ProposalController', 'get'])->setName('proposal.get');
            $group->map(['GET'], '/register[/{hash_customer}]', ['\App\Controller\System\ProposalController', 'form'])->setName('proposal.form');
            $group->map(['POST'], '/register', ['\App\Controller\System\ProposalController', 'post'])->setName('proposal.post');
            $group->map(['POST'], '/update/{hash_proposal}', ['\App\Controller\System\ProposalController', 'put'])->setName('proposal.put');

            $group->group('/insurance_policy', function (\Slim\Routing\RouteCollectorProxy $group) {
                $group->map(['GET'], '', ['\App\Controller\System\InsurancePolicyController', 'index'])->setName('policy.list');
                $group->map(['GET'], '/search', ['\App\Controller\System\InsurancePolicyController', 'search'])->setName('policy.search');
                //$group->map(['GET'], '[/{hash}]', ['\App\Controller\System\InsurancePolicyController', 'get'])->setName('policy.get');
                $group->map(['GET'], '/register[/{hash_customer}]', ['\App\Controller\System\InsurancePolicyController', 'form'])->setName('policy.form');
                $group->map(['POST'], '/register', ['\App\Controller\System\InsurancePolicyController', 'post'])->setName('policy.post');
                $group->map(['GET', 'POST'], '/view/{hash_policy}', ['\App\Controller\System\InsurancePolicyController', 'put'])->setName('policy.put');
            });
        });



        $group->group('/insurance_claim', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET'], '', ['\App\Controller\System\InsuranceClaimController', 'index'])->setName('claim.list');
            $group->map(['GET'], '/search', ['\App\Controller\System\InsuranceClaimController', 'search'])->setName('claim.search');
            $group->map(['GET'], '/view/{hash_claim}', ['\App\Controller\System\InsuranceClaimController', 'get'])->setName('claim.get');
            $group->map(['GET'], '/register', ['\App\Controller\System\InsuranceClaimController', 'form'])->setName('claim.form');
            $group->map(['POST'], '/register', ['\App\Controller\System\InsuranceClaimController', 'post'])->setName('claim.post');
            $group->map(['POST'], '/update/{hash_claim}', ['\App\Controller\System\InsuranceClaimController', 'put'])->setName('claim.put');

            $group->group('/claim_third', function (\Slim\Routing\RouteCollectorProxy $group) {
                $group->map(['GET'], '/view/{hash_third}', ['\App\Controller\System\ClaimThirdController', 'get'])->setName('claim-third.get');
                $group->map(['GET'], '/register/{hash_claim}', ['\App\Controller\System\ClaimThirdController', 'form'])->setName('claim-third.form');
                $group->map(['POST'], '/register', ['\App\Controller\System\ClaimThirdController', 'post'])->setName('claim-third.post');
                $group->map(['POST'], '/update/{hash_third}', ['\App\Controller\System\ClaimThirdController', 'put'])->setName('claim-third.put');
                $group->map(['GET'], '/delete/{hash_third}', ['\App\Controller\System\ClaimThirdController', 'delete'])->setName('claim-third.delete');

            });


        });



        $group->group('/upload', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['POST'], '/customer/{hash}', ['\App\Controller\System\UploadController', 'customer'])->setName('upload.customer');
            $group->map(['POST'], '/proposal/{hash}', ['\App\Controller\System\UploadController', 'proposal'])->setName('upload.proposal');
            $group->map(['POST'], '/policy/{hash}', ['\App\Controller\System\UploadController', 'policy'])->setName('upload.policy');
            $group->map(['POST'], '/claim/{hash}', ['\App\Controller\System\UploadController', 'claim'])->setName('upload.claim');
            $group->map(['POST'], '/claim-third/{hash}', ['\App\Controller\System\UploadController', 'claimThird'])->setName('upload.claim.third');
        });

        $group->group('/user', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET'], '/view/{hash}', ['\App\Controller\System\UserController', 'get'])->setName('user.get');
            $group->map(['POST'], '/view/{hash}', ['\App\Controller\System\UserController', 'put'])->setName('user.put');
            $group->map(['GET'], '/update/{hash}', ['\App\Controller\System\UserPasswordController', 'get'])->setName('user-password.get');
            $group->map(['POST'], '/update/{hash}', ['\App\Controller\System\UserPasswordController', 'put'])->setName('user-password.put');
        });

        $group->group('/safe_company', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET'], '', ['\App\Controller\System\SafeCompanyController', 'index'])->setName('safe-company.list');
           // $group->map(['GET'], '/search', ['\App\Controller\System\SafeCompanyController', 'search'])->setName('safe-company.search');
            $group->map(['GET'], '/view/{hash_safe_company}', ['\App\Controller\System\SafeCompanyController', 'get'])->setName('safe-company.get');
            $group->map(['GET'], '/register', ['\App\Controller\System\SafeCompanyController', 'form'])->setName('safe-company.form');
            $group->map(['POST'], '/register', ['\App\Controller\System\SafeCompanyController', 'post'])->setName('safe-company.post');
            $group->map(['POST'], '/update/{hash_safe_company}', ['\App\Controller\System\SafeCompanyController', 'put'])->setName('safe-company.put');
        });

    })

        ->add('\App\Component\SystemCheckSession');
});


$app->group('/manager', function (\Slim\Routing\RouteCollectorProxy $group) {
    $group->map(['GET'], '/out', ['\App\Controller\Administrator\LoginController', 'out'])->setName('manager.out');
    $group->map(['GET'], '/in', ['\App\Controller\Administrator\LoginController', 'in'])->setName('manager.in');
    $group->map(['POST'], '/in', ['\App\Controller\Administrator\LoginController', 'login'])->setName('manager.login');
    $group->map(['GET', 'POST'], '/index', ['\App\Controller\Administrator\IndexController', 'index'])->setName('manager.index');

    $group->group('/administrator', function (\Slim\Routing\RouteCollectorProxy $group) {
        $group->map(['GET'], '/form', ['\App\Controller\Administrator\AdministratorController', 'form'])->setName('manager.administrator.form');
        $group->map(['POST'], '/form', ['\App\Controller\Administrator\AdministratorController', 'post'])->setName('manager.administrator.post');
        $group->map(['GET'], '/update/{hash_adm}', ['\App\Controller\Administrator\AdministratorController', 'get'])->setName('manager.administrator.get');
        $group->map(['POST'], '/update/{hash_adm}', ['\App\Controller\Administrator\AdministratorController', 'put'])->setName('manager.administrator.put');
        $group->map(['GET'], '/index', ['\App\Controller\Administrator\AdministratorController', 'index'])->setName('manager.administrator.index');
    });

    $group->group('/companies', function (\Slim\Routing\RouteCollectorProxy $group) {
            $group->map(['GET', 'POST'], '/all', ['\App\Controller\Administrator\CompanyController', 'index'])->setName('manager.companies');
            $group->map(['GET'], '/update/{hash_company}', ['\App\Controller\Administrator\CompanyController', 'get'])->setName('manager.companies.get');
            $group->map(['GET'], '/record', ['\App\Controller\Administrator\CompanyController', 'record'])->setName('manager.companies.record');
            $group->map(['POST'], '/update/{hash_company}', ['\App\Controller\Administrator\CompanyController', 'update'])->setName('manager.companies.update');
            $group->map(['POST'], '/record', ['\App\Controller\Administrator\CompanyController', 'post'])->setName('manager.companies.post');
////        })->add('\App\Component\CheckSessionManager')
    });
    $group->group('/users', function (\Slim\Routing\RouteCollectorProxy $group) {
        $group->map(['GET'], '/update/{hash_user}', ['\App\Controller\Administrator\UserController', 'get'])->setName('manager.user.get');
        $group->map(['POST'], '/update/{hash_user}', ['\App\Controller\Administrator\UserController', 'put'])->setName('manager.user.put');
        $group->map(['GET'], '/form', ['\App\Controller\Administrator\UserController', 'form'])->setName('manager.user.form');
        $group->map(['POST'], '/form', ['\App\Controller\Administrator\UserController', 'post'])->setName('manager.user.post');
        $group->map(['GET'], '/index', ['\App\Controller\Administrator\UserController', 'index'])->setName('manager.user.index');

    });
});