<?php

namespace App\Component;

/**
 * Class Hash
 * @package App\Component
 */
class Hash
{

    /**
     * @param $repository
     * @return string
     */
    static public function get($repository)
    {
        $a = substr(md5(openssl_random_pseudo_bytes(20)), -8);
        $b = substr(md5(openssl_random_pseudo_bytes(20)), -4);
        $c = substr(md5(openssl_random_pseudo_bytes(20)), -8);
        $hash = "$a-$b-$c";

        $company = $repository->findBy(['hash' => $hash]);

        if (is_object($company) && $company->getId())
            return Hash::get($repository);

        return $hash;
    }

}