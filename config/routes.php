<?php

return [
    [
        'method' => 'GET',
        'route' => '/',
        'action' => 'Src\Controller\HomeController::home'
    ], [
        'method' => 'GET',
        'route' => '/register',
        'action' => function ($params = []) {
            echo 'estou na "/register"';
        }
    ],
    [
        'method' => 'GET',
        'route' => '/update/{ID}',
        'action' => 'Src\Controller\UpdateController::update'
    ]
];
