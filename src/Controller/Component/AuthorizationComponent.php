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
    public function authorize(Controller $controller)
    {
        $method = $controller->getRequest()->getParam('action');
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

            // If authorization is Role based check for roles
            if ($authorization->isRoleBased()) {
                /** @var RoleAuthorizationInterface $authenticatedUser */
                $authenticatedUser = $this->_getAuthenticatedUser($identity);
                if ($authorization->contains($authenticatedUser->getRoleName()) == false) {
                    throw new UnauthorizedException("You are not allowed to preform $method action");
                }
            }
        }
    }

    protected function _getAuthenticatedUser(Identity $identity) : EntityInterface
    {
        $usersTable = TableRegistry::getTableLocator()->get($this->getConfig('identity_model'));

        return $usersTable->get($identity->getIdentifier());
    }
}
