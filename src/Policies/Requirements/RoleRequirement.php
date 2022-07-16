<?php

namespace MayMeow\Authorization\Policies\Requirements;

class RoleRequirement implements PolicyRequirementInterface
{
    protected string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function getRequirement(): string|int
    {
        return $this->role;
    }
}
