<?php

namespace MayMeow\Authorization\Attributes;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\Identity;
use MayMeow\Authorization\IdentityInterface;
use MayMeow\Authorization\Policies\Requirements\Handlers\AuthorizationHandlerInterface;
use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

#[\Attribute]
class Authorize
{
    /**
     * @var string|null
     */
    protected ?string $role;

    /**
     * @var string|null
     */
    protected ?string $policy;

    /**
     * @param string|null $role
     * @param string|null $policy
     */
    public function __construct(?string $role = null, ?string $policy = null)
    {
        if ($role != null) {
            $this->role = $role;
        }

        if ($policy != null) {
            $this->policy = $policy;
        }
    }

    /**
     * Returns true if groups is set & there is no user
     *
     * @return bool
     */
    public function isRoleBased() :bool
    {
        if (isset($this->group) && !isset($this->user)) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if user is set
     * @TODO: finish this method
     * @return bool
     */
    public function isPolicyBased(): bool
    {
        if (isset($this->policy)) {
            return true;
        }

        return false;
    }

    /**
     * Check if role is in allowed roles
     *
     * @param string $name
     * @return bool Returns true if group is in array or match exact group name, False is default
     */
    public function hasRole(string $name) : bool
    {
        if (!isset($this->role)) {
            return false;
        }

        if (strpos($this->role, ',')) {
            // this is string with more groups representation
            $groups = explode(',', $this->role);

            if (in_array($name, $groups)) {
                return true;
            }
        } else {
            // this is only one group string
            if ($this->role == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param AuthorizationInterface $user
     * @return bool
     */
    public function isAuthorized(AuthorizationInterface $user): bool
    {
        if ($this->hasRole($user->getRoleName())) {
            return true;
        }

        return false;
    }

    /**
     * @param IdentityInterface|Identity $identity
     * @return bool
     */
    public function can(IdentityInterface|Identity $identity, AuthorizationInterface $user): bool
    {
        $policy = $identity->getAuthorization()->getPolicies()[$this->policy];
        $handler = $policy->getHandler();

        /** @var AuthorizationHandlerInterface $build */
        $build = new $handler();

        return $build->handleRequirement($user, $policy);
    }
}
