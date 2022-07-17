<?php

namespace MayMeow\Authorization\Policies\Requirements;

class RoleRequirement implements PolicyRequirementInterface
{
    protected string $role;

    protected string $handler;

    public function __construct(string $role, string $handler)
    {
        $this->role = $role;
        $this->handler = $handler;
    }

    public function getRequirement(): string|int
    {
        return $this->role;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }
}
