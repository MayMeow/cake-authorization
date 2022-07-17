<?php

namespace MayMeow\Authorization\Policies\Requirements;
/**
 * Policy requirement
 *
 * use to configure a policy requirement
 */
interface PolicyRequirementInterface
{
    public function getRequirement(): string|int;
}
