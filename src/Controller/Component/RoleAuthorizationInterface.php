<?php

namespace MayMeow\Authorization\Controller\Component;

interface RoleAuthorizationInterface
{
    /**
     * Return string representation of role
     *
     * @return string
     */
    public function getRoleName() : string;
}
