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

    protected ?string $user;

    /**
     * @param string|null $role
     * @param string|null $user
     */
    public function __construct(?string $role = null, ?string $user = null)
    {
        if ($role != null) {
            $this->role = $role;
        }

        if ($user != null) {
            $this->user = $user;
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
     *
     * @return bool
     */
    public function isUserBased(): bool
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
     * @param string $bane
     * @return bool
     */
    public function hasUser(string $name): bool
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
        if ($this->hasRole($user->getRoleName()) || $this->hasUser($user->getUserName())) {
            return true;
        }

        return false;
    }
}
