<?php

namespace MayMeow\Authorization;

use Authentication\IdentityInterface as AuthenticationIdentityInterface;
use MayMeow\Authorization\Services\AuthorizationServiceInterface;

class Identity extends IdentityDecorator implements AuthenticationIdentityInterface
{
    /**
     * @var AuthenticationIdentityInterface $identity
     */
    protected $identity;

    /**
     * @param AuthorizationServiceInterface $service
     * @param AuthenticationIdentityInterface $identity
     */
    public function __construct(AuthorizationServiceInterface $service, AuthenticationIdentityInterface $identity)
    {
        $this->authorization = $service;
        $this->identity = $identity;
    }

    /**
     * @return int|string|null
     */
    public function getIdentifier(): int|string|null
    {
        return $this->identity->getIdentifier();
    }

    /**
     * @return array|\ArrayAccess<IdentityInterface>
     */
    public function getOriginalData(): array|\ArrayAccess
    {
        return $this->identity->getOriginalData();
    }

    /**
     * @return AuthorizationServiceInterface
     */
    public function getAuthorization(): AuthorizationServiceInterface
    {
        return $this->authorization;
    }
}
