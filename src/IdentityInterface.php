<?php

namespace MayMeow\Authorization;

use Authentication\Authenticator\ResultInterface;

interface IdentityInterface extends \ArrayAccess
{
    /**
     * @return int|string|null
     */
    public function getIdentifier(): int|string|null;

    /**
     * @return array|\ArrayAccess<IdentityInterface>
     */
    public function getOriginalData(): array|\ArrayAccess;
}
