<?php

namespace MayMeow\Authorization\Attributes;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\Policies\AuthorizationPolicy;
use function PHPUnit\Framework\isNan;
use function PHPUnit\Framework\isNull;

#[\Attribute]
class Authorize
{
    /**
     * @var string|null
     */
    protected ?string $role;

    protected ?string $user;

    protected ?AuthorizationPolicy $policy;

    protected ?string $options;

    /**
     * @param string|null $role
     * @param string|null $policy
     * @param AuthorizationPolicy|null $policy
     * @param string|null $options
     */
    public function __construct(
        ?string $role = null,
        ?AuthorizationPolicy $policy = null,
        ?string $options = null)
    {
        if ($role != null) {
            $this->role = $role;
        }

        if ($policy != null) {
            $this->policy = $policy;
        }

        if ($options != null) {
            $this->options = $options;
        }
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
}
