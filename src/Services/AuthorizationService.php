<?php

namespace MayMeow\Authorization\Services;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use MayMeow\Authorization\Attributes\Authorize;
use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\IdentityInterface;
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

    public function handle(IdentityInterface $identity, Authorize $authorize): bool
    {
        /** @var AuthorizationInterface $authenticatedUser */
        $authenticatedUser = $this->_getAuthenticatedUser($identity);

        if ($authorize->isRoleBased()) {
            return $authorize->isAuthorized($authenticatedUser);
        }

        if ($authorize->isPolicyBased()) {
            return $authorize->can($identity, $authenticatedUser);
        }

        return false;
    }

    protected function _getAuthenticatedUser(IdentityInterface $identity) : EntityInterface
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');

        return $usersTable->get($identity->getIdentifier());
    }

}
