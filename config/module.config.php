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

            'swagger-resource-detail' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/api/docs/:resource',
                    'defaults' => [
                        'controller' => DocumentationController::class,
                        'action'     => 'details',
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
