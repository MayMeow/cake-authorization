<?php

namespace MayMeow\Authorization\Policies\Requirements\Handlers;

use MayMeow\Authorization\Policies\Requirements\PolicyRequirementInterface;

class RoleHandler implements AuthorizationHandlerInterface
{
    /**
     * @param string $context
     * @param PolicyRequirementInterface $requirement
     * @return bool
     */
    public function handleRequirement(string $context, PolicyRequirementInterface $requirement): bool
    {
        if ($context === (string)$requirement->getRequirement()) {
            return true;
        }

        return false;
    }
}
