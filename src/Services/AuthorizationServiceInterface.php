<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Services;

use MayMeow\Authorization\Controller\Component\AuthorizationInterface;

interface AuthorizationServiceInterface
{
    /**
     * @param \MayMeow\Authorization\Controller\Component\AuthorizationInterface $user
     * @return bool
     */
    public function handle(AuthorizationInterface $user): bool;
}
