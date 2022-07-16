<?php

namespace MayMeow\Authorization\Policies\Requirements\Handlers;

use MayMeow\Authorization\Policies\Requirements\PolicyRequirementInterface;

/**
 * Authorization Handler
 *
 * Handle the requirement of a policy.
 */
interface AuthorizationHandlerInterface
{
    public function handleRequirement(string $context, PolicyRequirementInterface $requirement): bool;
}
