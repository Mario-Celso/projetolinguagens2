<?php
$filename = __DIR__ . '/../config.production.ini';

if (file_exists($filename)) {
    $config_server = parse_ini_file($filename);
} else {
    $config_server = parse_ini_file(__DIR__ . '/../config.dev.ini');
}

return [
    'url' => $config_server['url'],
    'db.host' => $config_server['db-host'],
    'db.database' => $config_server['db-database'],
    'db.user' => $config_server['db-user'],
    'db.pass' => $config_server['db-pass'],
    'system.email.from' => $config_server['email-from'],
    'system.email.address' => $config_server['email-address'],
    'system.email.password' => $config_server['email-password'],
    'system.email.smtp.relay' => $config_server['email-smtp'],
    'system.email.port.relay' => $config_server['email-port'],
    'system.email.tls' => $config_server['email-tls']
];
