<?php

namespace MayMeow\Authorization\Policies\Requirements\Handlers;

use Cake\Datasource\EntityInterface;
use MayMeow\Authorization\Controller\Component\AuthorizationInterface;
use MayMeow\Authorization\Policies\Requirements\PolicyRequirementInterface;

class RoleHandler implements AuthorizationHandlerInterface
{
    /**
     * @param EntityInterface $context
     * @param PolicyRequirementInterface $requirement
     * @return bool
     */
    public function handleRequirement(EntityInterface $context, PolicyRequirementInterface $requirement): bool
    {
        $ref = new \ReflectionClass($context);

        if (!$ref->implementsInterface(AuthorizationInterface::class)) {
            return false;
        }

        return true;
    }
}
