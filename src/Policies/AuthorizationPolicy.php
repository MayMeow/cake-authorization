<?php

namespace MayMeow\Authorization\Policies;

enum AuthorizationPolicy
{
    /**
     * Require that the user has role.
     */
    case hasRole;

    /**
     * Require minimal account age
     */
    case minAge;

    /**
     * Request must have valid signature parameter signature=<signature>
     */
    case signature;
}
