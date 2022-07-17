<?php

namespace MayMeow\Authorization\Services;

interface AuthorizationServiceProviderInterface
{
    /**
     * @return AuthorizationServiceInterface
     */
    public function getAuthorizationService(): AuthorizationServiceInterface;
}
