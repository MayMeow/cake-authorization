<?php

namespace MayMeow\Authorization;

use Authentication\Authenticator\ResultInterface;

interface IdentityInterface extends \ArrayAccess
{
    public function getOriginalData();
}
