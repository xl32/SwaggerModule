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
 * @copyright  Copyright (c) 2012 OuterEdge UK Ltd (http://www.outeredgeuk.com)
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 */

declare(strict_types=1);

namespace SwaggerModule;

use OpenApi\Annotations\OpenApi;
use RuntimeException;
use SwaggerModule\Options\ModuleOptions as SwaggerModuleOptions;
use OpenApi\StaticAnalyser as OpenApiStaticAnalyser;
use OpenApi\Analysis as OpenApiAnalysis;
use OpenApi\Util as OpenApiUtil;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;

/**
 * SwaggerModule
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'service.swagger' => 'OpenApi\Annotations\OpenApi',
            ],

            'factories' => [
                SwaggerModuleOptions::class => function ($serviceManager) {
                    $config = $serviceManager->get('Config');
                    $config = (isset($config['swagger']) ? $config['swagger'] : null);

                    if ($config === null) {
                        throw new RuntimeException('Configuration for SwaggerModule was not found');
                    }

                    return new SwaggerModuleOptions($config);
                },

                OpenApi::class => function ($serviceManager) {
                    /** @var $options SwaggerModuleOptions */
                    $options    = $serviceManager->get(\SwaggerModule\Options\ModuleOptions::class);
                    $analyser   = new OpenApiStaticAnalyser();
                    $analysis   = new OpenApiAnalysis();
                    $processors = OpenApiAnalysis::processors();

                    // Crawl directory and parse all files
                    $paths = $options->getPaths();
                    foreach ($paths as $directory) {
                        $finder = OpenApiUtil::finder($directory);
                        foreach ($finder as $file) {
                            $analysis->addAnalysis($analyser->fromFile($file->getPathname()));
                        }
                    }
                    // Post processing
                    $analysis->process($processors);
                    // Validation (Generate notices & warnings)
                    $analysis->validate();

                    // Pass options to analyzer
                    $resourceOptions = $options->getResourceOptions();
                    $analysis->openapi->servers = $options->getServers($resourceOptions);

                    return $analysis->openapi;
                },
            ],
        ];
    }
}
