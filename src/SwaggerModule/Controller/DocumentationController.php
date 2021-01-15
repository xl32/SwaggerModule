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
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

declare(strict_types=1);

namespace SwaggerModule\Controller;

use OpenApi\Annotations\OpenApi;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use SwaggerModule\Options\ModuleOptions;

/**
 * DocumentationController. It is used to display a documentation in HTML
 */
class DocumentationController extends AbstractActionController
{
    /** @var OpenApi */
    protected $openApi;

    /** @var ModuleOptions */
    protected $moduleOptions;

    public function setOpenApi(OpenApi $openApi)
    {
        $this->openApi = $openApi;
    }

    public function setModuleOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Display the documentation
     *
     * @return JsonModel
     */
    public function displayAction()
    {
        return new JsonModel((array) $this->openApi->jsonSerialize());
    }
}
