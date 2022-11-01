<?php

namespace AjCastro\ScribeTdd\Strategies\UrlParameters;

use AjCastro\ScribeTdd\TestResults\RouteTestResult;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\UrlParameters\GetFromUrlParamTag;

class GetFromUrlParamTagFromScribeTdd extends GetFromUrlParamTag
{
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules = []): ?array
    {
        $testResult = RouteTestResult::getTestResultForRoute($endpointData->route);

        if (empty($testResult)) {
            return [];
        }

        [
            'method' => $methodDocBlock,
            'class' => $classDocBlock
        ]
        = RouteDocBlocker::getDocBlocks($endpointData->route, [
            $testResult['test_class'],
            $testResult['test_method'],
        ]);
    
        return $this->getFromTags($methodDocBlock->getTags(), $classDocBlock?->getTags() ?: []);
    }
}
