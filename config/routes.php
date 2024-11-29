<?php

// Define app routes

use ApiPlatform\Metadata\Resource\Factory\AttributesResourceMetadataCollectionFactory;
use ApiPlatform\Metadata\Resource\Factory\AttributesResourceNameCollectionFactory;
use Slim\App;

return function (App $app) {
    // api
    $resourceNameMetadataCollectionFactory = new AttributesResourceNameCollectionFactory([PROJECT_ROOT_DIR . '/src/ApiResources']);
    $resourceMetadataCollectionFactory = new AttributesResourceMetadataCollectionFactory();

    foreach ($resourceNameMetadataCollectionFactory->create() as $resourceClass) {
        foreach ($resourceMetadataCollectionFactory->create($resourceClass) as $resourceMetadata) {
            foreach ($resourceMetadata->getOperations() as $operationName => $operation) {
                $app->map(
                    [$operation->getMethod()],
                    ($operation->getRoutePrefix() ?? '').$operation->getUriTemplate(),
                    \App\Controller\Api::class
                )
                ->setName($operationName)
                ->add(function (\Slim\Psr7\Request $request, \Psr\Http\Server\RequestHandlerInterface $handler) use ($operation) {
                    $request = $request->withAttribute('operation', $operation);

                    return $handler->handle($request);
                });
            }
        }
    }
};
