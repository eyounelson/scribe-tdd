<?php

namespace AjCastro\ScribeTdd\Strategies\Responses;

use AjCastro\ScribeTdd\TestResults\RouteTestResult;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\RouteDocBlocker;
use Knuckles\Scribe\Extracting\Strategies\Responses\UseResponseTag;

class UseResponseTagFromScribeTdd extends UseResponseTag
{
    public function __invoke(ExtractedEndpointData $endpointData, array $routeRules): ?array
    {
        $testResult = RouteTestResult::getTestResultForRoute($endpointData->route);

        if (empty($testResult)) {
            return [];
        }

        [
            'method' => $methodDocBlock,
        ]
        = RouteDocBlocker::getDocBlocks($endpointData->route, [
            $testResult['test_class'],
            $testResult['test_method'],
        ]);

        return $this->getDocBlockResponses($methodDocBlock->getTags());
    }
}
