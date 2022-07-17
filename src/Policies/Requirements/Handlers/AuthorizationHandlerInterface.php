<?php

namespace MayMeow\Authorization\Policies\Requirements\Handlers;

use Cake\Datasource\EntityInterface;
use MayMeow\Authorization\Policies\Requirements\PolicyRequirementInterface;

/**
 * Authorization Handler
 *
 * Handle the requirement of a policy.
 */
interface AuthorizationHandlerInterface
{
    public function handleRequirement(EntityInterface $context, PolicyRequirementInterface $requirement): bool;
}
