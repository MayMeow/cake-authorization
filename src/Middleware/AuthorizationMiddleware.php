<?php

namespace MayMeow\Authorization\Middleware;

use Authentication\IdentityInterface as AuthenticationIdentityInterface;
use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\Identity;
use MayMeow\Authorization\IdentityDecorator;
use MayMeow\Authorization\IdentityInterface;
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
        /** @var AuthenticationIdentityInterface $identity */
        $identity = $request->getAttribute('identity');


        if ($identity != null) {
            $request = $request->withAttribute(
                'identity', $this->_buildIdentity($this->authorizationService, $identity)
            );
        }

        $response = $handler->handle($request);
        return $response;
    }

    /**
     * @param AuthorizationServiceInterface $service
     * @param AuthenticationIdentityInterface $identity
     * @return IdentityInterface
     */
    protected function _buildIdentity(
        AuthorizationServiceInterface $service,
        AuthenticationIdentityInterface $identity
    ): IdentityInterface
    {
        return new Identity($service, $identity);
    }
}
