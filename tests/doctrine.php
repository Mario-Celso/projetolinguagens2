<?php
return [

    /**
     * DEPENDENCY DOCTRINE
     */
    \Doctrine\ORM\EntityManager::class => Di\factory(function () {
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [
                __DIR__ . '/../app/Entity',
            ],
            true,
            __DIR__ . '/../data/cache/proxies',
            null,
            false
        );
        return \Doctrine\ORM\EntityManager::create([
            'driver' => 'pdo_sqlite',
            'memory' => true
        ], $config);
    })

];
