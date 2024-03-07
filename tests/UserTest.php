<?php

namespace App\Tests;

use App\Entity\Resource;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private bool $failure = false;

    public function testAddResource(): void
    {
        $user = new User();
        $resource = new Resource();

        $user->addResource($resource);

        $this->assertTrue($user->getResources()->contains($resource));
    }

    public function testRemoveResource(): void
    {
        $user = new User();
        $resource = new Resource();

        $user->addResource($resource);
        $user->removeResource($resource);
        if ($this->failure) {
            $this->fail('testRemoveResource falure');

        }
        $this->assertFalse($user->getResources()->contains($resource));
    }
}
