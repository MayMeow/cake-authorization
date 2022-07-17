<?php

namespace MayMeow\Authorization;

use ArrayAccess;
use Authentication\Authenticator\ResultInterface;
use MayMeow\Authorization\Services\AuthorizationServiceInterface;
use MayMeow\Authorization\Services\AuthorizationServiceProviderInterface;

class IdentityDecorator implements IdentityInterface
{
    /**
     * @var AuthorizationServiceInterface $authorization Authorization service
     */
    protected AuthorizationServiceInterface $authorization;

    /**
     * @var array|ArrayAccess<\Authentication\Identity> $identity Identity data
     */
    protected $identity;

    /**
     * @param AuthorizationServiceInterface $service
     * @param \Authentication\Identity|ArrayAccess<IdentityInterface> $identity
     * @throws \Exception
     */
    public function __construct(AuthorizationServiceInterface $service, $identity)
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_array($identity) && !$identity instanceof ArrayAccess) {
            $type = is_object($identity) ? get_class($identity) : gettype($identity);
            $message = sprintf(
                'Identity data must be an `array` or implement `ArrayAccess` interface, `%s` given.',
                $type
            );
            throw new \Exception($message);
        }

        $this->authorization = $service;
        $this->identity = $identity;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->identity[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet(mixed $offset): mixed
    {
        if (isset($this->identity[$offset])) {
            return $this->identity[$offset];
        }

        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value): mixed
    {
        return $this->identity[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->identity[$offset]);
    }

    /**
     * @return array|ArrayAccess<\Authentication\Identity>
     */
    public function getOriginalData(): array|\ArrayAccess
    {
        if (
            $this->identity
            && !is_array($this->identity)
            && method_exists($this->identity, 'getOriginalData')
        ) {
            return $this->identity->getOriginalData();
        }

        return $this->identity;
    }


    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call(string $method, array $args): mixed
    {
        if (!is_object($this->identity)) {
            throw new \Exception("Cannot call `{$method}`. Identity data is not an object.");
        }
        $call = [$this->identity, $method];

        return $call(...$args);
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function __get(string $property): mixed
    {
        return $this->identity->{$property};
    }

    /**
     * @param string $property
     * @return bool
     */
    public function __isset(string $property): bool
    {
        return isset($this->identity->{$property});
    }

    /**
     * @return int|string|null
     * @throws \Exception
     */
    public function getIdentifier(): int|string|null
    {
        throw new \Exception('Method `getIdentifier` is not implemented.');
    }
}
