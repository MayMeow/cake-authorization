<?php

namespace MayMeow\Authorization\Services;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;

interface AuthorizationServiceInterface
{
    /**
     * @param AuthorizationInterface $user
     * @return bool
     */
    public function handle(AuthorizationInterface $user): bool;
}
