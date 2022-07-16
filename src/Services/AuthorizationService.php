<?php

namespace MayMeow\Authorization\Services;

class AuthorizationService implements AuthorizationServiceInterface
{
    protected array $policies = [];

    /**
     * @param string $policy
     * @param string $role
     * @return $this
     */
    public function addPolicy(string $policy, string $role): AuthorizationService
    {
        $this->policies[$policy] = $role;

        return $this;
    }

    /**
     * @return array
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }
}
