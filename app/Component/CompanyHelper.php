<?php


namespace App\Component;


use App\Repository\SafeCompany\SafeCompanyRepository;
use DI\Annotation\Inject;

class CompanyHelper
{
    /**
     * @Inject
     * @var SafeCompanyRepository
     */
    protected SafeCompanyRepository $safeCompanyRepository;

    /*static public function showInsuranceCompany(): string
    {
        //nada está sendo usando aqui, mas não está apagado pq tlvz no futuro vai poder precisar
        //$safe_company = SafeCompanyRepository::class->findOneBy(['id' => $insurance_company]);
        return "alas";

        switch ($insurance_company) {
            case 1:
                return 'Tokio Marine';
            case 2:
                return 'Allianz';
            case 3:
                return 'Porto Seguro';
            case 4:
                return 'Itaú';
            case 5:
                return 'Azul';
            case 6:
                return 'Sul América';
            case 7:
                return 'Liberty';
            case 8:
                return 'Generali';
            case 9:
                return 'HDI';
            case 10:
                return 'Chubb';
            case 11:
                return 'Mapfre';
            case 12:
                return 'Capemisa';
            case 13:
                return 'Bradesco';
            case 14:
                return 'Marí­tima';
            case 15:
                return 'Zurich';
            case 16:
                return 'AIG';
            case 17:
                return 'Met Life';
            case 18:
                return 'SUHAI';
        }
        return 'Invalido';
    }*/

}