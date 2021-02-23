<?php
return [

    'view' => DI\factory(function () {
        $v = \Slim\Views\Twig::create(__DIR__ . '/../app/View/', [
            'cache' => false,
            'auto_reload' => true
        ]);
        $v->getEnvironment()->addGlobal('session', new \SlimSession\Helper());
        return $v;
    }),
];
