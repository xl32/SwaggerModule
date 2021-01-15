<?php

use SwaggerModule\Controller\DocumentationController;
use SwaggerModule\Controller\DocumentationControllerFactory;

return [
    'router' => [
        'routes' => [
            'swagger-resources' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/api/docs',
                    'defaults' => [
                        'controller' => DocumentationController::class,
                        'action'     => 'display',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            DocumentationController::class =>
                DocumentationControllerFactory::class,
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
