<?php

namespace MayMeow\Authorization\Attributes;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
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
        if (!$this->isRoleBased() && isset($this->user)) {
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
     * Check if name is in allowed usernames
     * @TODO add policy check
     * @param string $name
     * @return bool
     */
    public function hasPolicy(string $name): bool
    {
        if (!isset($this->user)) {
            return false;
        }

        if (strpos($this->user, ',')) {
            $users = explode(',', $this->user);

            if (in_array($name, $users)) {
                return true;
            }
        } else if ($this->user == $name) {
            return true;
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

        // TODO add check against policy

        return false;
    }
}
