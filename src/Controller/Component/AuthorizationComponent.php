<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Controller\Component;

use Authentication\Identity;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use MayMeow\Authorization\Attributes\Authorize;
use MayMeow\Authorization\IdentityInterface;

/**
 * Authorization component
 */
class AuthorizationComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'identity_model' => 'Users'
    ];

    /**
     * @param Controller $controller
     * @throws \ReflectionException
     */
    public function authorize(Controller $controller): void
    {
        $method = $controller->getRequest()->getParam('action');
        /** @var \MayMeow\Authorization\Identity $identity */
        $identity = $controller->getRequest()->getAttribute('identity');

        $reflectionClass = new \ReflectionClass($controller);
        $attributes = $reflectionClass->getMethod($method)->getAttributes(Authorize::class);

        if (!empty($attributes)) {
            /** @var Authorize $authorization */
            $authorization = $attributes[0]->newInstance();

            // check if there is logged-in user
            if (empty($identity)) {
                throw new UnauthorizedException('Please login');
            }

            if (!$identity->getAuthorization()->handle($identity, $authorization)) {
                throw new UnauthorizedException("You are not allowed to preform $method action");
            }
        }
    }
}
