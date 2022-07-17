<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use MayMeow\Authorization\Attributes\Authorize;
use MayMeow\Authorization\Services\AuthorizationService;

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
        'identity_model' => 'Users',
    ];

    /**
     * @param  \Cake\Controller\Controller $controller
     * @throws \ReflectionException
     */
    public function authorize(Controller $controller): void
    {
        $method = $controller->getRequest()->getParam('action');
        $identity = $controller->getRequest()->getAttribute('identity');

        $reflectionClass = new \ReflectionClass($controller);
        $attributes = $reflectionClass->getMethod($method)->getAttributes(Authorize::class);

        if (!empty($attributes)) {
            /**
 * @var \MayMeow\Authorization\Attributes\Authorize $authorization
*/
            $authorization = $attributes[0]->newInstance();
            $authorizationService = new AuthorizationService($authorization);

            // check if there is logged-in user
            if (empty($identity)) {
                throw new UnauthorizedException('Please login');
            }

            /**
 * @var \MayMeow\Authorization\Controller\Component\AuthorizationInterface $authenticatedUser
*/
            $authenticatedUser = $this->_getAuthenticatedUser($identity);

            if (!$authorizationService->handle($authenticatedUser)) {
                throw new UnauthorizedException("You are not allowed to preform $method action");
            }
        }
    }

    /**
     * @param  \MayMeow\Authorization\Controller\Component\AuthorizationInterface $identity User identity
     * @return \Cake\Datasource\EntityInterface Entity Interface
     */
    protected function _getAuthenticatedUser(AuthorizationInterface $identity): EntityInterface
    {
        /**
 * @var \Authentication\Identity $user
*/
        $user = $identity;
        $usersTable = TableRegistry::getTableLocator()->get($this->getConfig('identity_model'));

        return $usersTable->get($user->getIdentifier());
    }
}
