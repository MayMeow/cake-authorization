<?php

namespace MayMeow\Authorization\Middleware;

#[\Attribute]
class Authorize
{
    /**
     * @var string|null
     */
    protected ?string $group;

    public function __construct(?string $group = null)
    {
        $this->group = $group;
    }

    /**
     * Check if Role is needed for authoriazation
     *
     * @return bool
     */
    public function isRoleBased() :bool
    {
        if ($this->group != null) {
            return true;
        }

        return false;
    }

    /**
     * @param string $name
     * @return bool Returns true if group is in array or match exact group name, False is default
     */
    public function contains(string $name) : bool
    {
        if (strpos($this->group, ',')) {
            // this is string with more groups representation
            $groups = explode(',', $this->group);

            if (in_array($name, $groups)) {
                return true;
            }
        } else {
            // this is only one group string
            if ($this->group == $name) {
                return true;
            }
        }

        return false;
    }
}
