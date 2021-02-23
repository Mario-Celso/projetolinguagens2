<?php
return [

    /**
     * DEPENDENCY DOCTRINE
     */
    \Doctrine\ORM\EntityManager::class => Di\factory(function ($host, $db, $user, $pass) {
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [
                __DIR__ . '/../app/Entity',
            ],
            false,
            __DIR__ . '/../data/cache/proxies',
            null,
            false
        );

        return \Doctrine\ORM\EntityManager::create([
            'driver' => 'pdo_mysql',
            'driverOptions' => [1002 => 'SET NAMES utf8'],
            'dns' => "mysql:{$db}=;host={$host}",
            'host' => $host,
            'dbname' => $db,
            'user' => $user,
            'password' => $pass
        ], $config);
    })
        ->parameter('host', DI\get('db.host'))
        ->parameter('db', DI\get('db.database'))
        ->parameter('user', DI\get('db.user'))
        ->parameter('pass', DI\get('db.pass'))

];
