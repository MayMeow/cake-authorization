<?php

namespace MayMeow\Authorization\Services;

interface AuthorizationServiceInterface
{
    public function getPolicies(): array;
}
