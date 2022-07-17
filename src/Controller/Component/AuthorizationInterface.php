<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Controller\Component;

interface AuthorizationInterface
{
    /**
     * Return string representation of role
     *
     * @return string
     */
    public function getRoleName(): string;

    public function getUserName(): string;
}
