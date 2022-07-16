<?php

namespace MayMeow\Authorization\Services;

use MayMeow\Authorization\Policies\Requirements\PolicyRequirementInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var array<string,PolicyRequirementInterface>
     */
    protected array $policies = [];

    protected ServerRequestInterface $request;

    /**
     * @param string $policy
     * @return $this
     */
    public function addPolicy(string $policy, PolicyRequirementInterface $policyRequirement): AuthorizationService
    {
        $this->policies[$policy] = $policyRequirement;
        return $this;
    }

    /**
     * @return array<string, PolicyRequirementInterface>
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }
}
