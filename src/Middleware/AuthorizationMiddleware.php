<?php

namespace MayMeow\Authorization\Middleware;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\Services\AuthorizationServiceInterface;
use MayMeow\Authorization\Services\AuthorizationServiceProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizationMiddleware implements MiddlewareInterface
{
    protected AuthorizationServiceInterface $authorizationService;

    /**
     * @param AuthorizationServiceProviderInterface $authorizationServiceProvider
     */
    public function __construct(AuthorizationServiceProviderInterface $authorizationServiceProvider)
    {
        $this->authorizationService = $authorizationServiceProvider->getAuthorizationService();
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var AuthorizationInterface $identity */
        $identity = $request->getAttribute('identity');

        $policies = $this->authorizationService->getPolicies();
        $request = $request->withAttribute('MayMeow/authorization/V1.policies', $policies);

        $response = $handler->handle($request);
        return $response;
    }
}
