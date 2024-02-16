<?php

namespace App\ApiResource;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);


        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT',

        ]);
        return $openApi;
    }
}
