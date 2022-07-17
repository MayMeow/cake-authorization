<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Services;

use MayMeow\Authorization\Attributes\Authorize;
use MayMeow\Authorization\Controller\Component\AuthorizationInterface;

class AuthorizationService implements AuthorizationServiceInterface
{
    protected Authorize $authorize;

    public function __construct(Authorize $authorize)
    {
        $this->authorize = $authorize;
    }

    /**
     * @param  \MayMeow\Authorization\Controller\Component\AuthorizationInterface $user
     * @return bool
     */
    public function handle(AuthorizationInterface $user): bool
    {
        if ($this->authorize->isAuthorized($user)) {
            return true;
        }

        return false;
    }
}
