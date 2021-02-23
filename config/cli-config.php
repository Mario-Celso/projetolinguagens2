<?php
$filename = __DIR__ . '/../config.production.ini';

if (file_exists($filename)) {
    $config_server = parse_ini_file($filename);
} else {
    $config_server = parse_ini_file(__DIR__ . '/../config.dev.ini');
}

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/../vendor/autoload.php';

$host = $config_server['db-host'];
$db = $config_server['db-database'];
$user = $config_server['db-user'];
$pass = $config_server['db-pass'];

$settings = [
    'meta' => [
        'entity_path' => [
            __DIR__ . '/../app/Entity'
        ],
        'auto_generate_proxies' => true,
        'proxy_dir' => __DIR__ . '/../data/cache/proxies',
        'cache' => null,
    ],
    'connection' => [
        'driver' => 'pdo_mysql',
        'driverOptions' => [
            1002 => 'SET NAMES utf8'
        ],
        'dns' => "mysql:dbname={$db};host={$host}",
        'host' => $host,
        'dbname' => $db,
        'user' => $user,
        'password' => $pass
    ]
];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);
