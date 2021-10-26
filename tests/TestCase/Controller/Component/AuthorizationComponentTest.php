<?php
declare(strict_types=1);

namespace MayMeow\Authorization\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use MayMeow\Authorization\Controller\Component\AuthorizationComponent;

/**
 * MayMeow\Authorization\Controller\Component\AuthorizationComponent Test Case
 */
class AuthorizationComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \MayMeow\Authorization\Controller\Component\AuthorizationComponent
     */
    protected $Authorization;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Authorization = new AuthorizationComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Authorization);

        parent::tearDown();
    }
}
