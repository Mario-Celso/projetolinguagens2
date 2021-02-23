<?php
require __DIR__ . '/../vendor/autoload.php';

$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);
$builder->useAnnotations(true);
$builder->addDefinitions(__DIR__ . '/doctrine.php');
$builder->addDefinitions(__DIR__ . '/../config/settings.php');
$builder->addDefinitions(__DIR__ . '/../config/repositories.php');
return $builder->build();
