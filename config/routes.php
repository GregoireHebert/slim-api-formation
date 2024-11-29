<?php

// Define app routes

use ApiPlatform\Metadata\Resource\Factory\AttributesResourceMetadataCollectionFactory;
use ApiPlatform\Metadata\Resource\Factory\AttributesResourceNameCollectionFactory;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // api
    $app->group('/api', function (RouteCollectorProxy $group) {
        $resourceNameMetadataCollectionFactory = new AttributesResourceNameCollectionFactory([PROJECT_ROOT_DIR . '/src/ApiResources']);
        $resourceMetadataCollectionFactory = new AttributesResourceMetadataCollectionFactory();

        foreach ($resourceNameMetadataCollectionFactory->create() as $resourceClass) {
            foreach ($resourceMetadataCollectionFactory->create($resourceClass) as $resourceMetadata) {
                foreach ($resourceMetadata->getOperations() as $operationName => $operation) {
                    $group->map(
                        [$operation->getMethod()],
                        ($operation->getRoutePrefix() ?? '') . $operation->getUriTemplate(),
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
    })->add(\App\Middlewares\NotAcceptableMiddleware::class);
};
