<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Controller\Component;

/**
 * @deprecated
 * @see AuthorizationInterface
 */
interface RoleAuthorizationInterface
{
    /**
     * Return string representation of role
     *
     * @return string
     */
    public function getRoleName(): string;
}
