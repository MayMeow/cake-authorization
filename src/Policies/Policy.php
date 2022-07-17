<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Policies;

/**
 * Policy
 */
enum Policy
{
    case requireRole;
    case requireUserName;
}
