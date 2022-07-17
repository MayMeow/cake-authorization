<?php

namespace MayMeow\Authorization\Policies;

/**
 * Policy
 */
enum Policy
{
    case requireRole;
    case requireUserName;
}
