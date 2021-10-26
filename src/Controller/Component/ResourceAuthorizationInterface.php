<?php

namespace MayMeow\Authorization\Controller\Component;

interface ResourceAuthorizationInterface
{
    /**
     * It is used to return author id for given resource
     * Mostly user_id
     * @return int
     */
    public function getAuthorIdentifier() : int;
}
