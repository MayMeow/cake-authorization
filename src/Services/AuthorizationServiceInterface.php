<?php

namespace MayMeow\Authorization\Services;

use Cake\Datasource\EntityInterface;
use MayMeow\Authorization\Attributes\Authorize;
use MayMeow\Authorization\IdentityInterface;

interface AuthorizationServiceInterface
{
    public function getPolicies(): array;

    public function handle(IdentityInterface $identity, Authorize $authorize);
}
