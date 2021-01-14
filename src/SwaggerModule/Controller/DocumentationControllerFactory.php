<?php

/**
 * SwaggerModule
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright  Copyright (c) 2017 OuterEdge UK Ltd (https://outeredgeuk.com)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

declare(strict_types=1);

namespace SwaggerModule\Controller;

use Interop\Container\ContainerInterface;
use OpenApi\Annotations\OpenApi;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use SwaggerModule\Options\ModuleOptions;

class DocumentationControllerFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return class_exists($requestedName);
    }

    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): DocumentationController {
        $controller = new DocumentationController();
        /** @var OpenApi $openApi */
        $openApi = $container->get(OpenApi::class);
        $controller->setOpenApi($openApi);

        $moduleOptions = $container->get(ModuleOptions::class);
        $controller->setModuleOptions($moduleOptions);
        return $controller;
    }
}
